<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\BuildingsAddress;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function showAddPaymentPage($code)
    {
        $building = BuildingsAddress::where('building_code', $code)->first();

        $paymentsNames = DB::table('payments_names')
            ->get();

        $curMonth = Carbon::now()->format('Y-m');
        $minMonth = Carbon::now()->addMonths(-6)->format('Y-m');
        $maxMonth = Carbon::now()->addMonths(6)->format('Y-m');

        $apartments = DB::table('apartments')
            ->select('apartments.*', DB::raw('count(apartments.number) as inhabitants'))
            ->join('neighbors', 'neighbors.ap_num', '=', 'apartments.number')
            ->where('neighbors.status', '=', 'accepted')
            ->where('apartments.building_code', '=', $code)
            ->where('neighbors.building_code', '=', $code)
            ->groupBy('apartments.number')
            ->orderBy('apartments.number')
            ->get();

        return view('addPayment', ['building' => $building, 'paymentsTypes' => $paymentsNames,
            'minMonth' => $minMonth, 'maxMonth' => $maxMonth, 'curMonth' => $curMonth, 'apartments' => $apartments, 'inhabitantsNum' => $apartments->sum('inhabitants')]);
    }

    public function addPayment($code, Request $request)
    {
        $request->validate([
            'fileName.*' => 'image|mimes:jpeg,png,jpg,svg,JPG,PNG,JPEG|max:10240'
        ]);

        $fileName = null;
        if ($request->file('fileName') !== null) {
            foreach ($request->file('fileName') as $image) {
                $suffix = $image->getClientOriginalExtension();

                $fileName = date_timestamp_get(Carbon::now()) . "." . $suffix;
                $imagesPath = dirname(__DIR__, 3) . env('IMAGES_PATH'); // path of all uploaded images
                $image->move($imagesPath, $fileName); // upload new image onto server
            }
        }

        $apartments = DB::table('apartments')
            ->select('apartments.number')
            ->join('neighbors', 'neighbors.ap_num', '=', 'apartments.number')
            ->where('neighbors.status', '=', 'accepted')
            ->where('apartments.building_code', '=', $code)
            ->where('neighbors.building_code', '=', $code)
            ->groupBy('apartments.number')
            ->get();

        $payments = [];
        foreach ($apartments as $a) {
            $priceName = "ap" . strval($a->number);
            $price = $request->{$priceName};
            if ($price < 0) {
                return redirect()->back()->with('error', __('Сумата не може да е по-малка от 0') . "!");
            }

            if ($price > 0) {
                $payment = new Payment();
                $payment->building_code = $code;
                $payment->type = $request->paymentType;
                $payment->month = $request->month;
                $payment->ap_num = $a->number;
                $payment->value = $price;

                $existing = Payment::where([
                    ['building_code', '=', $payment->building_code],
                    ['type', '=', $payment->type],
                    ['ap_num', '=', $payment->ap_num],
                    ['month', '=', $payment->month]
                ])
                    ->first();

                if ($existing !== null) {
                    return redirect()->back()->with('error', __('Сумата за апартаментите, които вече имат записан разход от този вид за дадения месец, може да бъде само 0') . "!");
                }

                //image
                if ($fileName !== null) {
                    $payment->file_name = $fileName;
                }

                array_push($payments, $payment);
            }

            foreach ($payments as $p) {
                $p->save();
            }

        }

        return redirect()->back()->with('success', __('Успешно създаде нов разход') . "!");
    }

    public function showPayments($code, $month = null, $type = null)
    {
        $building = BuildingsAddress::where('building_code', $code)->first();

        $paymentsNames = DB::table('payments_names')
            ->get();

        $firstMonth = Payment::where('building_code', $code)
            ->select('month')
            ->orderBy('month')
            ->first();

        $lastMonth = Payment::where('building_code', $code)
            ->select('month')
            ->orderByDesc('month')
            ->first();

        $payments = null;
        if ($month !== null && $type !== null) {
            if ($type === "allPayments") {
                $payments = $this->getAllPayments($code, $month);
            } else {
                $payments = $this->getPaymentsForType($code, $month, $type);
            }
        }

        return view('payments', ['building' => $building, 'paymentsTypes' => $paymentsNames, 'minMonth' => $firstMonth,
            'maxMonth' => $lastMonth, 'payments' => $payments, 'month' => $month, 'type' => $type]);
    }

    private function getAllPayments($code, $month, $orderBy = null, $direction = null)
    {
        $payments = DB::table('payments')
            ->select(DB::raw('sum(payments.is_paid) as is_paid'), DB::raw('sum(payments.value) as value'),
                DB::raw('count(payments.is_paid) as payments_number'), 'apartments.number', 'apartments.floor', 'apartments.family_name')
            ->join('apartments', 'apartments.number', '=', 'payments.ap_num')
            ->where([
                ['payments.month', '=', $month],
                ['payments.building_code', $code],
                ['apartments.building_code', $code]
            ])
            ->groupBy('apartments.number');

        if (isset($orderBy) && isset($direction)) {
            if ($direction === "asc") {
                $payments->orderBy($orderBy);
            } else {
                $payments->orderByDesc($orderBy);
            }
        } else {
            $payments->orderBy('apartments.number');
        }

        $payments = $payments->get();

        foreach ($payments as $p) {
            if ($p->is_paid == $p->payments_number) $p->is_paid = 1;
            else $p->is_paid = 0;
        }

        return $payments;
    }

    private function getPaymentsForType($code, $month, $type, $orderBy = null, $direction = null)
    {
        $payments = DB::table('payments')
            ->select('payments.is_paid', 'payments.value', 'apartments.number', 'apartments.floor',
                'apartments.family_name', 'payments.file_name')
            ->join('apartments', 'apartments.number', '=', 'payments.ap_num')
            ->where([
                ['payments.month', '=', $month],
                ['payments.type', '=', $type],
                ['payments.building_code', $code],
                ['apartments.building_code', $code]
            ]);

        if (isset($orderBy) && isset($direction)) {
            if ($direction === "asc") {
                $payments->orderBy($orderBy);
            } else {
                $payments->orderByDesc($orderBy);
            }
        } else {
            $payments->orderBy('apartments.number');
        }

        return $payments->get();
    }

    public function changeIsPaid($code, $month, $type, $apNum, $isPaid)
    {

        if ($type === 'allPayments') {
            $payments = Payment::where([
                ['building_code', '=', $code],
                ['month', '=', $month],
                ['ap_num', '=', $apNum]
            ])->get();
        } else {
            $payments = Payment::where([
                ['building_code', '=', $code],
                ['month', '=', $month],
                ['type', '=', $type],
                ['ap_num', '=', $apNum]
            ])->get();
        }

        foreach ($payments as $payment) {
            $payment->is_paid = !$isPaid;
            $payment->update();
        }

        return redirect()->back();
    }


    public function sortPayments($code, $month, $type, $orderBy, $direction)
    {
        $building = BuildingsAddress::where('building_code', $code)->first();

        $paymentsNames = DB::table('payments_names')
            ->get();

        $firstMonth = Payment::where('building_code', $code)
            ->select('month')
            ->orderBy('month')
            ->first();

        $lastMonth = Payment::where('building_code', $code)
            ->select('month')
            ->orderByDesc('month')
            ->first();

        $payments = null;
        if ($month !== null && $type !== null) {
            if ($type === "allPayments") {
                $payments = $this->getAllPayments($code, $month, $orderBy, $direction);
            } else {
                $payments = $this->getPaymentsForType($code, $month, $type, $orderBy, $direction);
            }
        }

        //стрелка нагоре/надолу в зависимост от посоката на сортиране
        $arrow = ($orderBy === 'asc') ? ' &#9652' : ' &#9662';

        return view('payments', ['building' => $building, 'paymentsTypes' => $paymentsNames, 'minMonth' => $firstMonth,
            'maxMonth' => $lastMonth, 'payments' => $payments, 'month' => $month, 'type' => $type, 'orderBy' => $orderBy, 'direction' => $direction]);

    }
}

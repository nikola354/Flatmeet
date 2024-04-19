<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\BuildingsAddress;
use App\Models\Neighbor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class CommunitiesController extends Controller
{
    public function createCommunity(Request $request){
        $request->validate([
            'shortAddress' => 'required|min:7|max:128',
            'fullAddress' => 'required|min:12|max:360',
            'apNumber' => 'required|regex:/^[0-9]+/|max:3',
            'floor' => 'required|regex:/^[0-9]+/|max:2',
            'family' => 'max:100'
        ]);

        //Създаване на случаен уникален код
        $codeCheck = new BuildingsAddress();
        $buildingCode = "";
        while ($codeCheck !== null) {
            $buildingCode = "";
            for ($i = 0; $i < 6; $i++) {
                $buildingCode .= rand(0, 9);
            }

            $codeCheck = BuildingsAddress::where('building_code', $buildingCode)->first();
        }

        $building = new BuildingsAddress();
        $building->building_code = $buildingCode;
        $building->short_address = $request->shortAddress;
        $building->full_address = $request->fullAddress;
        $building->save();

        $user = auth()->user();

        $neighbor = new Neighbor();
        $neighbor->building_code = $buildingCode;
        $neighbor->email = $user->email;
        $neighbor->rights = 'admin';
        $neighbor->ap_num = $request->apNumber;
        $neighbor->status = 'accepted';
        $neighbor->save();

        $ap = new Apartment();
        $ap->building_code = $buildingCode;
        $ap->number = $request->apNumber;
        $ap->floor = $request->floor;
        if ($request->family == null) {
            $ap->family_name = $user->first_name . " " . $user->last_name;
        } else {
            $ap->family_name = $request->family;
        }
        $ap->save();


        return redirect('dashboard');
    }

    public function showCommunities(){
        $buildingCodes = Neighbor::select('neighbors.building_code')
            ->where('email', auth()->user()->email)
            ->where('status', 'accepted')
            ->get();

        $buildings = [];
        foreach ($buildingCodes as $code) {
            $address = BuildingsAddress::where('building_code', $code->building_code)->first();
            if ($address !== null) array_push($buildings, $address);
        }

        return view('dashboard', ['buildings' => $buildings]);
    }

    public function checkCode(Request $request){
        $building = BuildingsAddress::where('building_code', $request->code)->first();

        if ($building === null) {
            return response()->json(['ok' => false, 'error' => __('Не намерихме общност с въведения код. Проверете го и опитайте отново')]);

        }

        $neighbor = Neighbor::where('email', auth()->user()->email)
            ->where('building_code', $request->code)->first();

        if($neighbor !== null){
            if($neighbor->status === "pending"){
                return response()->json(['ok' => false, 'error' => __('Не можеш да кандидатстваш за присъединяване в един вход повече от веднъж')]);
            }elseif ($neighbor->status === "denied"){
                return response()->json(['ok' => false, 'error' => __('Достъпът ти до този вход е отказан')]);
            }else{
                return response()->json(['ok' => false, 'error' => __('Вече членуваш в този вход')]);
            }
        }

        return response()->json(['ok' => true]);

    }

    public function checkApartment(Request $request){
        $floor = "";
        $family = "";

        $ap = Apartment::where('building_code', $request->code)
            ->where('number', $request->ap)->first();

        if ($ap === null) $isFirst = true;
        else {
            $isFirst = false;
            $floor = $ap->floor;
            $family = $ap->family_name;
        }

        return response()->json(['isFirst' => $isFirst, 'floor' => $floor, 'family' => $family]);
    }
}

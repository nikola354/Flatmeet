<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\BuildingsAddress;
use App\Models\Neighbor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NeighborsController extends Controller
{
    public function enterWaitingRoom(Request $request)
    {
        $user = auth()->user();

        $building = BuildingsAddress::where('building_code', $request->code)->first();

        $allInhabitants = Neighbor::where('ap_num', $request->ap)
            ->where('building_code', $request->code)
            ->where('status', '!=', 'denied')
            ->count();

        if ($allInhabitants >= 6) {
            return response()->json(['ok' => false, 'error' => __('Максималният брой на обитатели на един апартамент е 6.
            Моля сменете номера на апартамента и опитайте отново')]);
        }
        try {
            $neighbor = new Neighbor();
            $neighbor->building_code = $request->code;
            $neighbor->email = $user->email;
            $neighbor->rights = 'neighbor';
            $neighbor->ap_num = $request->ap;
            $neighbor->save();

            $ap = Apartment::where('number', $request->ap)->first();
            if ($ap === null) {
                $ap = new Apartment();
                $ap->building_code = $request->code;
                $ap->number = $request->ap;
                $ap->floor = $request->floor;
                if ($request->family == "") {
                    $ap->family_name = $user->first_name . " " . $user->last_name;
                } else {
                    $ap->family_name = $request->family;
                }
                $ap->save();
            }
        } catch (QueryException $e) {
            return response()->json(['ok' => false, 'error' => __('Нещо се обърка')]);
        }

        return response()->json(['ok' => true, 'msg' => __('Успешно заяви желание да се присъединиш към '). $building->short_address . '! ' . __('След като домоуправителят на входа те одобри, ще можеш да общуваш със своите съседи онлайн!')]);

    }

    public function showPendings($code)
    {
        $building = BuildingsAddress::where('building_code', $code)->first();

        $pendings = DB::table('users')
            ->select('users.first_name', 'users.last_name', 'apartments.number as ap_num', 'apartments.floor', 'apartments.family_name', 'users.email')
            ->join('neighbors', 'neighbors.email', '=', 'users.email')
            ->leftJoin('apartments', 'apartments.number', '=', 'neighbors.ap_num')
            ->where('neighbors.building_code', $code)
            ->where('neighbors.status', 'pending')
            ->where('apartments.building_code', $code)
            ->get();

        return view('waitingRoom', ['building' => $building, 'pendings' => $pendings]);
    }

    public function markAsDenied($code, $email)
    {

        $neighbor = Neighbor::where('building_code', $code)
            ->where('email', $email)->first();

        $neighbor->status = 'denied';
        $neighbor->update();

        return redirect()->back();
    }

    public function markAsAccepted($code, $email)
    {

        $neighbor = Neighbor::where('building_code', $code)
            ->where('email', $email)->first();

        $neighbor->status = 'accepted';
        $neighbor->update();

        return redirect()->back();
    }

    public function showNeighbors($code)
    {
        $building = BuildingsAddress::where('building_code', $code)->first();

        $neighbors = DB::table('users')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.file_name', 'apartments.number as ap_num', 'apartments.floor', 'apartments.family_name', 'users.email', 'neighbors.rights')
            ->join('neighbors', 'neighbors.email', '=', 'users.email')
            ->leftJoin('apartments', 'apartments.number', '=', 'neighbors.ap_num')
            ->where('neighbors.building_code', $code)
            ->where('neighbors.status', 'accepted')
            ->where('apartments.building_code', $code)
            ->where('users.email', '!=', auth()->user()->email)
            ->orderBy('neighbors.ap_num')
            ->get();

        return view('neighbors', ['building' => $building, 'neighbors' => $neighbors]);
    }

    public function changeRights(Request $request)
    {
        $code = $request->code;
        $email = $request->email;
        $newRights = $request->newRights;
        $authNeighbor = Neighbor::where('email', auth()->user()->email)
            ->where('building_code', $code)
            ->first();

        if ($authNeighbor->rights === 'neighbor' || ($authNeighbor->rights === 'treasurer' && $newRights !== 'treasurer'))
            return response()->json(['ok' => false, 'error' => __('Нещо се обърка')]);

        $toChange = Neighbor::where('email', $email)
            ->where('building_code', $code)
            ->first();

        if ($toChange->rights === 'admin') return response()->json(['ok' => false, 'error' => __('Нещо се обърка')]);

        if($newRights === "kickOut"){
            $toChange->status = "denied";
        }else{
            $toChange->rights = $newRights;
        }

        $toChange->update();

        return response()->json(['ok' => true]);
    }


    public function redirectToMainPage($code){
        $neighbor = Neighbor::where('email', auth()->user()->email)->first();

        if($neighbor->rights === 'admin') return redirect(route('waitingRoom', $code));

        if($neighbor->rights === 'treasurer') return redirect(route('addPayment', $code));

        return redirect(route('neighbors', $code));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Neighbor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use function PHPUnit\Framework\isEmpty;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkAccess($code): bool{
        $neighbor = Neighbor::where('email', auth()->user()->email)
            ->where('building_code', $code)->first();

        if($neighbor === null) return false;
        return true;
    }
}

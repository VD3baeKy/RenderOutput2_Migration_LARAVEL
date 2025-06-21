<?php

namespace App\Http\Controllers;

use App\Models\Loves;
use App\Models\House;
use App\Dto\FaboriteHouseDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class FaboritesController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $page = $request->input('page', 1);
        $perPage = 5;

        $loves = Loves::where('user_id', $user->id)->paginate($perPage, ['*'], 'page', $page);

        $faboriteHouseDTOs = [];
        foreach ($loves as $love) {
            $house = House::find($love->house_id); // ← house_id に直す！
            if ($house) {
                 $faboriteHouseDTOs[] = new FaboriteHouseDTO($love, $house);
            }
        }

        $fabosPage = new \Illuminate\Pagination\LengthAwarePaginator(
            $faboriteHouseDTOs,
            $loves->total(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('faborites.index', ['fabosPage' => $fabosPage]);
    }

}


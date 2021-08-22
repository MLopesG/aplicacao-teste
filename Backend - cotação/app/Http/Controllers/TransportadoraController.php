<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransportadoraController extends Controller
{
    public function ListarTransportadoras()
    {
        $transportadoras = DB::table('transportadora')->get();
        return response()->json($transportadoras, 200);
    }
}

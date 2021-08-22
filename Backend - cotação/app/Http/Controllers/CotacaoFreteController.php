<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\CotacaoFrete;


class CotacaoFreteController extends Controller
{

    public function ListarUFS()
    {
        $ufs =  DB::table('cotacao_frete')->select('uf')->distinct()->get();
        return response()->json($ufs, 200);
    }

    public function ListarImpostos()
    {
        $impostos = DB::table('cotacao_frete')->get();
        return response()->json($impostos, 200);

    }

    public function CadastroCotacaoFrete(Request $request)
    {
         try{
            $data = $request->all();

            $validation = Validator::make($data,[ 
                'uf'=>'required',
                'percentual_cotacao'=>'required',
                'valor_extra'=>'required',
                'transportadora_id'=>'required'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    "errors" => $validation->errors()
                ], 500);
            }

            $verificarCadastroCotacao = DB::table('cotacao_frete')
                    ->where('uf', $request->input('uf'))
                    ->where('transportadora_id', $request->input('transportadora_id'))
                    ->first();

           if( $verificarCadastroCotacao){
            return response()->json([
                "mensagem" => "Não foi possivel realizar cadastro! Cotação já existe!"
            ], 500);
           }

            CotacaoFrete::create($data);

            return response()->json([
                "mensagem" => "Sucesso"
            ], 200);

         }catch(Exception $error){
            return response()->json([
                "error" => $error->getMessage()
            ], 500);
         }
    }

    public function SimularCotacaoFrete(Request $request){
        try{
            $data = $request->all();

            $validation = Validator::make($data,[ 
                'uf'=>'required',
                'valor_pedido'=>'required'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    "errors" => $validation->errors()
                ], 500);
            }

             $verificarCadastroCotacao = DB::table('cotacao_frete')
                    ->where('uf', $request->input('uf'))
                    ->first();

           if(!$verificarCadastroCotacao){
            return response()->json([
                "mensagem" => "Cotação não cadastrada para UF"
            ], 500);
           }

            $params = [
             $request->input('valor_pedido'), 
             $request->input('valor_pedido'), 
             $request->input('uf')
            ];

            $cotacoes = DB::select('
                SELECT 
                    uf, 
                    ? as valor_pedido, 
                    transportadora_id, 
                    (((?/100 * percentual_cotacao)) + valor_extra) as valor_cotacao 
                FROM cotacao_frete 
                where uf = ?
                order by valor_cotacao asc
                limit 3
            ', $params);

            return response()->json($cotacoes, 200);

         }catch(Exception $error){
            return response()->json([
                "error" => $error->getMessage()
            ], 500);
         }
    }
}

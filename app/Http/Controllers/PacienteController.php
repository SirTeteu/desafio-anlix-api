<?php

namespace App\Http\Controllers;

use App\Http\Resources\PacienteResource;
use App\Models\Paciente;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Lista vários pacientes com filtro de nome (opcional)
     * Se acrescentar os parâmetros latest-cardiaco-indice
     * ou latest-pulmonar-indice, acrescentará na resposta
     * o respectivo indice mais recente de cada paciente
     *
     * @param Request $request
     * @return PacienteResource
     */
    public function index(Request $request) {
        $pacientes = Paciente::query();

        // filtrando pacientes pelo nome
        if($request->has('nome')) {
            $nome = $request->input('nome');

            $pacientes->where('nome', 'like', "%$nome%");
        }

        // se o paramentro latest-cardiaco-indice for passado na request
        // entao acrescenta na resposta o indice cardiaco mais recente
        if ($request->has('latest-cardiaco-indice') && 
            $request->input('latest-cardiaco-indice') == 1) {
            
                $pacientes = $pacientes->with('latestCardiacoIndice');
        }   else if ($request->has('latest-pulmonar-indice') && 
            $request->input('latest-pulmonar-indice') == 1) {
                // se o paramentro latest-pulmonar-indice for passado na request
                // entao acrescenta na resposta o indice pulmonar mais recente
                $pacientes = $pacientes->with('latestPulmonarIndice');
        }
        
        $pacientes = $pacientes->get();
        return PacienteResource::collection($pacientes);
    }

    /**
     * Detalha o paciente junto com os indices pulmonar e cardiaco
     * mais recentes
     *
     * @param int $pacienteId
     * @return PacienteResource
     */
    public function detail($pacienteId) {
        $paciente = Paciente::where('id', $pacienteId)
            ->with('latestCardiacoIndice')
            ->with('latestPulmonarIndice')
            ->get();

        return PacienteResource::collection($paciente);
    }

    /**
     * Lista os pacientes com indices pulmonares ou cardiacos
     * registrados no range de datas selecionado
     *
     * @param Request $request
     * @return PacienteResource
     */
    public function indexByDate(Request $request) {
        
        // validando se a data foi passada no parametro
        if (!$request->has('data')) {
            return response()->json(['msg' => 'A data não foi passada corretamente.'], 500);
        }

        $data = $request->input('data');

        // validando se a data foi passada no formato correto
        try {
            $date = @Carbon::parse($data);
        } catch (InvalidFormatException $e) {
            return response()->json(['msg' => 'O formato da data deve ser yyyy-mm-dd.'], 500);
            
        }

        // selecionando apenas pacientes com caracteristicas existentes na data indicada
        $pacientes = Paciente::whereHas('cardiacoIndices', function ($q) use ($data) {
                $q->where('data', $data);
            })->orWhereHas('pulmonarIndices', function ($q) use ($data) {
                $q->where('data', $data);
            })->with(['cardiacoIndices' => function ($q) use ($data) {
                $q->where('data', $data);
            }])->with(['pulmonarIndices' => function ($q) use ($data) {
                $q->where('data', $data);
            }])->get();

        if (count($pacientes) == 0) {
            return response()->json(['msg' => 'Nenhum paciente para a data fornecida.'], 500);
        }

        return PacienteResource::collection($pacientes);
    }

    /**
     * Detalha os indices registrados dentro de um range de datas para um paciente
     *
     * @param Request $request
     * @param int $pacienteId
     * @return PacienteResource
     */
    public function detailDateRange(Request $request, $pacienteId) {

        // validando se as data foram passadas no parametro
        if (!$request->has('data_inicio') || !$request->has('data_fim')) {
            return response()->json(['msg' => 'A(s) data(s) não foram passadas corretamente.'], 500);
        }

        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');

        // validando se as datas foram passadas no formato correto
        try {
            $date = @Carbon::parse($data_inicio);
            $date = @Carbon::parse($data_fim);
        } catch (InvalidFormatException $e) {
            return response()->json(['msg' => 'O formato da data deve ser yyyy-mm-dd.'], 500);
        }

        $paciente = Paciente::where('id', $pacienteId);
        
        // pelo menos o cardiaco-indice ou pulmonar-indice sempre devem ser passados
        if ($request->has('cardiaco-indice') && 
            $request->input('cardiaco-indice') == 1) {
            
                // selecionando os indices das datas indicadas
                $paciente = $paciente->with(['cardiacoIndices' => function ($q) use ($data_inicio, $data_fim) {
                    $q->whereBetween('data', [$data_inicio, $data_fim]);
                }]);
        
        } else if ($request->has('pulmonar-indice') && 
            $request->input('pulmonar-indice') == 1) {
            
                // selecionando os indices das datas indicadas
                $paciente = $paciente->with(['pulmonarIndices' => function ($q) use ($data_inicio, $data_fim) {
                    $q->whereBetween('data', [$data_inicio, $data_fim]);
                }]);
        
        } else {
            return response()->json(['msg' => 'Nenhuma característica foi selecionada.'], 500);

        }

        $paciente = $paciente->get();

        return PacienteResource::collection($paciente);
    }

    /**
     * Detalha os indices registrados mais recentes dentro de um range de datas para um paciente
     *
     * @param Request $request
     * @param integer $pacienteId
     * @return PacienteResource
     */
    public function detailLatestInDateRange(Request $request, $pacienteId) {
        // validando se as data foram passadas no parametro
        if (!$request->has('data_inicio') || !$request->has('data_fim')) {
            return response()->json(['msg' => 'A(s) data(s) não foram passadas corretamente.'], 500);
        }

        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');

        // validando se as datas foram passadas no formato correto
        try {
            $date = @Carbon::parse($data_inicio);
            $date = @Carbon::parse($data_fim);
        } catch (InvalidFormatException $e) {
            return response()->json(['msg' => 'O formato da data deve ser yyyy-mm-dd.'], 500);
        }

        $paciente = Paciente::where('id', $pacienteId);
        
        // pelo menos o cardiaco-indice ou pulmonar-indice sempre devem ser passados
        if ($request->has('cardiaco-indice') && 
            $request->input('cardiaco-indice') == 1) {
            
                // selecionando os indices das datas indicadas
                $paciente = $paciente->with(['latestCardiacoIndice' => function ($q) use ($data_inicio, $data_fim) {
                    $q->whereBetween('data', [$data_inicio, $data_fim]);
                }]);
        
        } else if ($request->has('pulmonar-indice') && 
            $request->input('pulmonar-indice') == 1) {
            
                // selecionando os indices das datas indicadas
                $paciente = $paciente->with(['latestPulmonarIndice' => function ($q) use ($data_inicio, $data_fim) {
                    $q->whereBetween('data', [$data_inicio, $data_fim]);
                }]);
        
        } else {
            return response()->json(['msg' => 'Nenhuma característica foi selecionada.'], 500);

        }

        $paciente = $paciente->get();

        return PacienteResource::collection($paciente);
    }


}

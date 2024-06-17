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

}

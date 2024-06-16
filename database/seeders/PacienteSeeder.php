<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PacienteSeeder extends Seeder
{
    /**
     * Roda a seeder
     */
    public function run(): void
    {
        // Seedar a tabela apenas se não tiver nada nela
        if (!Paciente::count()) {
            // Pegando o arquivo de dados
            $seed = Storage::disk("seeds")->get("pacientes.json");
            $pacientes = json_decode($seed);

            // populando a tabela
            foreach ($pacientes as $paciente) {
                $model = new Paciente([
                    'nome' => $paciente->nome,
                    'idade' => $paciente->idade,
                    'cpf' => $paciente->cpf,
                    'rg' => $paciente->rg,
                    'data_nasc' => Carbon::createFromFormat("d/m/Y", $paciente->data_nasc)->format("Y-m-d"),
                    'sexo' => $paciente->sexo,
                    'signo' => $paciente->signo,
                    'mae' => $paciente->mae,
                    'pai' => $paciente->pai,
                    'email' => $paciente->email,
                    'senha' => bcrypt($paciente->senha),
                    'cep' => $paciente->cep,
                    'endereco' => $paciente->endereco,
                    'numero' => $paciente->numero,
                    'bairro' => $paciente->bairro,
                    'cidade' => $paciente->cidade,
                    'estado' => $paciente->estado,
                    'telefone_fixo' => $paciente->telefone_fixo,
                    'celular' => $paciente->celular,
                    'altura' => str_replace(',', '.', $paciente->altura) * 1,
                    'peso' => $paciente->peso,   
                    'tipo_sanguineo' => $paciente->tipo_sanguineo,
                    'cor' => $paciente->cor
                ]);

                $model->save();
            }
        }
    }
}

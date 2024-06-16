<?php

namespace Database\Seeders;

use App\Lib\AnlixCsvImport;
use App\Models\IndiceCardiaco;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class IndiceCardiacoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!IndiceCardiaco::count()) {
            $files = Storage::disk("seeds")->files("indice_cardiaco");
            
            foreach($files as $file) {
                // formatando a data do indice cardiaco coletado
                $data = explode("/", $file)[1];
                $data = Carbon::createFromFormat("dmY", $data)->format("Y-m-d");

                // gerando o array com os dados da data
                $seed = Storage::disk("seeds")->get($file);
                $anlixCsvImport = new AnlixCsvImport($seed);
                $indices_cardiaco = $anlixCsvImport->getCsvContent();

                // importando os dados para a tabela
                foreach($indices_cardiaco as $indice_cardiaco) {
                    $model = new IndiceCardiaco([
                        "data" => $data,
                        "epoch" => $indice_cardiaco["EPOCH"],
                        "ind_card" => $indice_cardiaco["ind_card"]
                    ]);

                    $paciente = Paciente::where("cpf", $indice_cardiaco['CPF'])->first();
                    $model->paciente()->associate($paciente->id);

                    $model->save();
                }
        
            }
        }
    }
}

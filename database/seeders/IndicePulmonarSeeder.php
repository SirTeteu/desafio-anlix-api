<?php

namespace Database\Seeders;

use App\Lib\AnlixCsvImport;
use App\Models\IndicePulmonar;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class IndicePulmonarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!IndicePulmonar::count()) {
            $files = Storage::disk("seeds")->files("indice_pulmonar");
            
            foreach($files as $file) {
                // formatando a data do indice pulmonar coletado
                $data = explode("/", $file)[1];
                $data = Carbon::createFromFormat("dmY", $data)->format("Y-m-d");

                // gerando o array com os dados da data
                $seed = Storage::disk("seeds")->get($file);
                $anlixCsvImport = new AnlixCsvImport($seed);
                $indices_pulmonar = $anlixCsvImport->getCsvContent();

                // importando os dados para a tabela
                foreach($indices_pulmonar as $indice_pulmonar) {
                    $model = new IndicePulmonar([
                        "data" => $data,
                        "epoch" => $indice_pulmonar["EPOCH"],
                        "ind_pulm" => $indice_pulmonar["ind_pulm"]
                    ]);

                    $paciente = Paciente::where("cpf", $indice_pulmonar['CPF'])->first();
                    $model->paciente()->associate($paciente->id);

                    $model->save();
                }
        
            }
        }
    }
}

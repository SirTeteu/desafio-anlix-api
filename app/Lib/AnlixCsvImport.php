<?php

namespace App\Lib;

class AnlixCsvImport {
    private $csv;

    public function __construct($csv) {
        $this->csv = $csv;
    }

    public function getCsvContent() {
        $content = [];
            
        $lines = explode("\n", $this->csv); // separando as linhas do csv
        $header = null;

        foreach ($lines as $line) {
            // verificando se a linha não é vazia
            if (empty($line)) {
                continue;
            }

            // separando os valores de cada linha e 
            // filtrando apenas os valores != null
            $data = explode(" ", $line);
            $data = array_filter($data);

            // Definindo o cabeçalho
            if (!$header) {
                $header = $data;
                continue;
            }

            // Associando os valores às chaves do cabeçalho
            $array_indexed = array_combine($header, $data);
            array_push($content, $array_indexed);
        }

        return $content;
    }
}
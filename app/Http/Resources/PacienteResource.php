<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'idade' => $this->idade,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'data_nasc' => $this->data_nasc,
            'sexo' => $this->sexo,
            'signo' => $this->signo,
            'mae' => $this->mae,
            'pai' => $this->pai,
            'email' => $this->email,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'telefone_fixo' => $this->telefone_fixo,
            'celular' => $this->celular,
            'altura' => $this->altura,
            'peso' => $this->peso,   
            'tipo_sanguineo' => $this->tipo_sanguineo,
            'cor' => $this->cor,

            'cardiacoIndices' => IndiceCardiacoResource::collection($this->whenLoaded('cardiacoIndices')),
            'pulmonarIndices' => IndicePulmonarResource::collection($this->whenLoaded('pulmonarIndices')),
            'latestCardiacoIndice' => new IndiceCardiacoResource($this->whenLoaded('latestCardiacoIndice')),
            'latestPulmonarIndice' => new IndicePulmonarResource($this->whenLoaded('latestPulmonarIndice'))
        ];

    }
}

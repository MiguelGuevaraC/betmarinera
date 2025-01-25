<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryResourceBet extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name ?? null,
            'status'       => $this->status ?? 'Sin Apuesta',
            'user_'       => Auth::user()->id,
            'bet'       =>  $this->bet() ? new BetResource($this->bet()) : null,
           
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'amount' => $this->amount,
            'description' => $this->description,
            'donation_type' => $this->donationType->name,
            'donor' => new DonorResource($this->donor),
            'wallet' => $this->wallet->name,
            'good_type' => $this->goodType->name,
            'completed_status' => $this->completed
        ];
    }


}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_number' => $this->invoice_number,
            'donation_type' => $this->donationType->name,
            'donor_type' => class_basename(str_replace('//', '/', $this->donor->donorable_type)),
            'no_kk' => $this->when($this->donor->donorable_type == 'App\\Models\\Resident', $this->donor->donorable->no_kk),
            'house_number' => $this->when($this->donor->donorable_type == 'App\\Models\\Resident', $this->donor->donorable->house_number),
            'donor_name' => $this->donor->name,
            'wallet' => $this->wallet->name,
            'good_type' => $this->goodType->name,
            'amount' => $this->amount,
            'completed_status' => $this->completed,
            "created" => $this->created_at,
            "updated" => $this->updated_at
        ];
    }
}

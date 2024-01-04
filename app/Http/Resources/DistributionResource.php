<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //todo : change the images value with only containing uuid
        return [
            'id' => $this->id,
            'title' => $this->title,
            'amount' => $this->amount,
            'wallet' => $this->wallet_id,
            'description' => $this->description,
            'images' => $this->GetMedia()
        ];
    }
}

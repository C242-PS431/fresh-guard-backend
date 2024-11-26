<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;

class ScanResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $created_at = Date::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC')->setTimezone('Asia/Jakarta');
        return [
            'id' => $this->id,
            // 'name' => $this->user->name,
            // 'username' => $this->user->username,
            'produce' => $this->produce,
            'is_tracked' => (boolean) $this->is_tracked,
            'freshness_score' => $this->freshness_score,
            'created_at' => $created_at->format('d-m-Y H:i:s')
        ];
    }
}

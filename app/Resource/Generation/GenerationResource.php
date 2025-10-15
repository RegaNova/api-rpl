<?php

namespace App\Resource\Generation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class GenerationResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'image' => $this->image,
            'image_url' => $this->image
                ? Storage::disk('public')->url($this->image)
                : null, // URL lengkap
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

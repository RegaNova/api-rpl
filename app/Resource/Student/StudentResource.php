<?php

namespace App\Resource\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Resource\Generation\GenerationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_birth' => $this->date_birth,
            'instagram' => $this->instagram,
            'words' => $this->words,
            'image' => $this->image,
            'image_url' => $this->image
                ? Storage::disk('public')->url($this->image)
                : null, // URL lengkap
            'generation_id' => $this->generation_id,
            'generation' => new GenerationResource($this->whenLoaded('generation')),
        ];
    }
}

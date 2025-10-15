<?php 

namespace App\Resource\Generation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GenerationPaginateResource extends ResourceCollection{
    protected array $paginate;

    public function __construct($resource, $paginate)
    {
        parent::__construct($resource);
        $this->paginate = $paginate;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => GenerationResource::collection($this->items()),
            'paginate' => $this->paginate,
        ];
    }
}
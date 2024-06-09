<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CandidateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return  $this->collection->map(function ($candidate) {
            return  [
                "id" => $candidate->id,
                "name" => $candidate->name,
                "source" => $candidate->source,
                "owner" => $candidate->owner,
                "created_at" => $candidate->created_at,
                "created_by" => $candidate->created_by,
            ];
        })->toArray();
    }
}

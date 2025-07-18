<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paginator = $this->resource;

        return [
            'current_page' => $paginator->currentPage(),
            // 'data' => $this->resource->items(),
            'first_page_url' => $paginator->url(1),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'last_page_url' => $paginator->url($paginator->lastPage()),
            'links' => [
                [
                    'url' => $paginator->previousPageUrl(),
                    'label' => '&laquo; Previous',
                    'active' => $paginator->onFirstPage() ? false : true,
                ],
                [
                    'url' => $paginator->url($paginator->currentPage()),
                    'label' => (string) $paginator->currentPage(),
                    'active' => true,
                ],
                [
                    'url' => $paginator->nextPageUrl(),
                    'label' => 'Next &raquo;',
                    'active' => $paginator->hasMorePages(),
                ]
            ],
            'next_page_url' => $paginator->nextPageUrl(),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'prev_page_url' => $paginator->previousPageUrl(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];
    }
}

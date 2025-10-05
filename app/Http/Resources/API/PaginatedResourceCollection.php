<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedResourceCollection extends ResourceCollection
{
    protected $resourceClass;
    protected $only = null;
    protected $except = null;

    public function __construct($resource, $resourceClass = null)
    {
        parent::__construct($resource);
        $this->resourceClass = $resourceClass;
    }

    /**
     * Specify which fields to include in the resource collection
     *
     * @param array $fields
     * @return $this
     */
    public function only(array $fields)
    {
        $this->only = $fields;
        return $this;
    }

    /**
     * Specify which fields to exclude from the resource collection
     *
     * @param array $fields
     * @return $this
     */
    public function except(array $fields)
    {
        $this->except = $fields;
        return $this;
    }

    public function toArray($request)
    {
        // Apply resource class with field filtering if applicable
        $items = $this->collection;

        if ($this->resourceClass) {
            if ($this->only !== null) {
                $items = $this->collection->map(function ($item) {
                    return (new $this->resourceClass($item))->only($this->only);
                });
            } elseif ($this->except !== null) {
                $items = $this->collection->map(function ($item) {
                    return (new $this->resourceClass($item))->except($this->except);
                });
            } else {
                $items = $this->resourceClass::collection($this->collection);
            }
        }

        return [
            'items' => $items,
            'meta' => [
                'pagination' => [
                    'total_items' => $this->resource->total(),
                    'total_pages' => $this->resource->lastPage(),
                    'current_page' => $this->resource->currentPage(),
                    'items_per_page' => (int) $this->resource->perPage(),
                    'count' => $this->resource->count(),
                    'from' => $this->resource->firstItem(),
                    'to' => $this->resource->lastItem(),
                ],
                'links' => [
                    'first' => $this->resource->url(1),
                    'last' => $this->resource->url($this->resource->lastPage()),
                    'prev' => $this->resource->previousPageUrl(),
                    'next' => $this->resource->nextPageUrl(),
                ],
                'has_pages' => $this->resource->hasPages(),
                'has_more_pages' => $this->resource->hasMorePages(),
                'is_first_page' => $this->resource->onFirstPage(),
                'is_last_page' => $this->resource->currentPage() === $this->resource->lastPage(),
            ]
        ];
    }

    /**
     * Add additional pagination metadata to the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}

<?php

namespace App\Services\Filters;

use Illuminate\Support\Facades\Log;

class OrderItemFilterService
{
    /**
     * Applies all available filters to the query based on params.
     */
    public function applyFilters($query, $params)
    {
        Log::info('Starting to apply order item filters with params:', $params);

        foreach ($params as $key => $value) {
            if ($value !== null && $value !== '') {
                Log::info("Applying order item filter for: $key with value:", ['value' => $value]);
                $this->applyFilter($query, $key, $value);
            } else {
                Log::info("Skipping order item filter for: $key as the value is null or empty.");
            }
        }

        logQuery($query);
        Log::info('All order item filters applied.');

        return $query;
    }

    /**
     * Applies the filter based on the key provided.
     */
    protected function applyFilter($query, $key, $value)
    {
        switch ($key) {
            case 'search':
                $this->filterBySearch($query, $value);
                break;
            case 'date_range':
                $this->filterByDateRange($query, $value, 'created_at');
                break;
            default:
                Log::warning("Unknown order item filter key: $key");
                break;
        }
    }

    /**
     * Filters the query by search term.
     */
    private function filterBySearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            // Search by order item ID
            $query->where('order_items.id', 'LIKE', '%' . $value . '%');

            // Search in product name (translatable)
            $query->orWhereHas('product', function ($productQuery) use ($value) {
                $locales = config('app.locales', ['en', 'ar', 'he']);
                $productQuery->where(function ($nameQuery) use ($value, $locales) {
                    foreach ($locales as $locale) {
                        $nameQuery->orWhereRaw(
                            "LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.{$locale}'))) LIKE ?",
                            ['%' . strtolower($value) . '%']
                        );
                    }
                });
            });
        });
    }

    /**
     * Filter by date range
     */
    private function filterByDateRange($query, $range, $field = 'created_at')
    {
        if (is_string($range) && strpos($range, ' to ') !== false) {
            [$from, $to] = explode(' to ', $range);

            if (! empty($from)) {
                $query->whereDate($field, '>=', trim($from));
            }
            if (! empty($to)) {
                $query->whereDate($field, '<=', trim($to));
            }
        } elseif (is_array($range)) {
            if (! empty($range['from'])) {
                $query->whereDate($field, '>=', $range['from']);
            }
            if (! empty($range['to'])) {
                $query->whereDate($field, '<=', $range['to']);
            }
        }
    }
}

<?php

namespace App\Services\Filters;

use Illuminate\Support\Facades\Log;

class AddressFilterService
{
    /**
     * Applies all available filters to the query based on params.
     */
    public function applyFilters($query, $params)
    {
        Log::info('Starting to apply category filters with params:', $params);

        foreach ($params as $key => $value) {
            if ($value !== null && $value !== '') {
                Log::info("Applying category filter for: $key with value:", ['value' => $value]);
                $this->applyFilter($query, $key, $value);
            } else {
                Log::info("Skipping category filter for: $key as the value is null or empty.");
            }
        }

        logQuery($query);
        Log::info('All category filters applied.');

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
            default:
                Log::warning("Unknown address filter key: $key");
                break;
        }
    }

    /**
     * Filters the query by search term.
     */
    private function filterBySearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            // Search in translatable name field
            $locales = config('app.locales', ['en', 'ar']);
            foreach ($locales as $locale) {
                $query->orWhereRaw(
                    "LOWER(JSON_UNQUOTE(JSON_EXTRACT(address, '$.{$locale}'))) LIKE ?",
                    ['%'.strtolower($value).'%']
                );
            }
        });
    }

}

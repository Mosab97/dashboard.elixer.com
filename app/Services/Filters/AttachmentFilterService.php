<?php

namespace App\Services\Filters;

use Illuminate\Support\Facades\Log;

class AttachmentFilterService
{
    /**
     * Applies all available filters to the query based on params.
     */
    public function applyFilters($query, $params)
    {
        Log::info("Starting to apply filters with params:", $params);

        foreach ($params as $key => $value) {
            if ($value !== null) {
                Log::info("Applying filter for: $key with value:", ['value' => $value]);

                $this->applyFilter($query, $key, $value);
            } else {
                Log::info("Skipping filter for: $key as the value is null.");
            }
        }

        // Log the final SQL query and its bindings.
        logQuery($query);

        Log::info("All filters applied.");
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

            case 'type_id':
                $this->filterByTypeId($query, $value);
                break;

            default:
                Log::warning("Unknown filter key: $key");
                break;
        }
    }
    /**
     * Filters the query by search term.
     */
    private function filterBySearch($query, $value)
    {
        $locales = config('app.locales'); // Fetch locales from the config file
        Log::info('Locales fetched from config:', $locales);

        // Loop through each locale to apply search on 'name' field
        foreach ($locales as $index => $locale) {
            Log::info("Applying search for 'name' in locale: $locale");

            if ($index === 0) {
                $query->whereRaw(
                    "json_extract(LOWER(name), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                    ['%' . $value . '%']
                );
                $query->orWhereRaw(
                    "json_extract(LOWER(description), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                    ['%' . $value . '%']
                );
            } else {
                $query->orWhereRaw(
                    "json_extract(LOWER(name), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                    ['%' . $value . '%']
                );
                $query->orWhereRaw(
                    "json_extract(LOWER(description), \"$.$locale\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci",
                    ['%' . $value . '%']
                );
            }
        }
        // $query->orWhereHas('type', function ($q) use($value){
        //     $q->where('name');
        // });
    }

    private function filterByTypeId($query, $value)
    {
        $Ids = filterArrayForNullValues($value);
        if (count($Ids) > 0) {
            $query->whereIn('type_id', $Ids);
        } else {
            Log::info('No valid type_id values to filter.');
        }
    }
}

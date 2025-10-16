<?php

namespace App\Services\Filters;

use Illuminate\Support\Facades\Log;

class OrderFilterService
{
    /**
     * Applies all available filters to the query based on params.
     */
    public function applyFilters($query, $params)
    {
        Log::info('Starting to apply order filters with params:', $params);

        foreach ($params as $key => $value) {
            if ($value !== null && $value !== '') {
                Log::info("Applying order filter for: $key with value:", ['value' => $value]);
                $this->applyFilter($query, $key, $value);
            } else {
                Log::info("Skipping order filter for: $key as the value is null or empty.");
            }
        }

        logQuery($query);
        Log::info('All order filters applied.');

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
            case 'payment_method':
                $this->filterByPaymentMethod($query, $value);
                break;
            case 'delivery_method':
                $this->filterByDeliveryMethod($query, $value);
                break;
            case 'date_range':
                $this->filterByDateRange($query, $value, 'created_at');
                break;
            default:
                Log::warning("Unknown order filter key: $key");
                break;
        }
    }

    /**
     * Filters the query by search term.
     */
    private function filterBySearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            // Search by order ID
            $query->where('orders.id', 'LIKE', '%' . $value . '%')
                // Search in first_name (plain string field)
                ->orWhere('orders.first_name', 'LIKE', '%' . $value . '%')
                // Search in last_name (plain string field)
                ->orWhere('orders.last_name', 'LIKE', '%' . $value . '%')
                // Search in phone (plain string field)
                ->orWhere('orders.phone', 'LIKE', '%' . $value . '%')
                // Search in email (plain string field)
                ->orWhere('orders.email', 'LIKE', '%' . $value . '%')
                // Search in address (plain string field)
                ->orWhere('orders.address', 'LIKE', '%' . $value . '%')
                // Search in coupon_code (plain string field)
                ->orWhere('orders.coupon_code', 'LIKE', '%' . $value . '%');
        });
    }

    /**
     * Filter by payment method
     */
    private function filterByPaymentMethod($query, $value)
    {
        if (is_array($value)) {
            $query->whereIn('payment_method', $value);
        } else {
            $query->where('payment_method', $value);
        }
    }

    /**
     * Filter by delivery method
     */
    private function filterByDeliveryMethod($query, $value)
    {
        if (is_array($value)) {
            $query->whereIn('delivery_method', $value);
        } else {
            $query->where('delivery_method', $value);
        }
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

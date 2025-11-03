<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display label for the order status
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => t('Pending'),
            self::PROCESSING => t('Processing'),
            self::DELIVERED => t('Delivered'),
            self::CANCELLED => t('Cancelled'),
        };
    }

    /**
     * Get the color class for the status badge
     */
    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PROCESSING => 'info',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    /**
     * Get the badge HTML for the status
     */
    public function getBadge(): string
    {
        return '<span class="badge badge-light-' . $this->getColor() . '">' . $this->getLabel() . '</span>';
    }
}

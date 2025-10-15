<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case VISA = 'VISA';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display label for the receive method
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::CASH => t('Cash'),
            self::VISA => t('Visa'),
        };
    }
}

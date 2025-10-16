<?php

namespace App\Enums;

enum DeliveryMethod: string
{
    case PICKUP = 'pickup';
    case DELIVERY = 'delivery';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the display label for the delivery method
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::PICKUP => t('Pickup from store'),
            self::DELIVERY => t('Home delivery'),
        };
    }

    /**
     * Check if delivery method has shipping fee
     */
    public function hasShippingFee(): bool
    {
        return match ($this) {
            self::PICKUP => false,
            self::DELIVERY => true,
        };
    }

    /**
     * Get description for the delivery method
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::PICKUP => t('Pick up your order from our store - No delivery fees'),
            self::DELIVERY => t('Get your order delivered to your home - Delivery fees apply'),
        };
    }
}

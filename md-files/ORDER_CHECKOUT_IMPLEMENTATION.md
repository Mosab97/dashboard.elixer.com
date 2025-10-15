# Order Checkout Implementation

## Overview
This document describes the order checkout process and calculation logic for the e-commerce system.

## Calculation Flow

### 1. Subtotal Calculation
The subtotal is calculated by summing up all product items in the cart:

```
For each item:
  - Get product price (use price_after_discount if discount > 0, otherwise use regular price)
  - Calculate item total: price × quantity
  - Add to subtotal

subtotal = sum of all item totals
```

### 2. Delivery Fee
The delivery fee is determined by the selected region:

```
delivery_fee = region.price
```

### 3. Discount Calculation
If a valid coupon code is provided:

```
discount = (subtotal × coupon.discount) / 100
```

**Important:** The discount applies **only to the subtotal**, not to the delivery fee.

### 4. Final Total Calculation

```
total_price_before_discount = subtotal
total_price_after_discount = (subtotal - discount) + delivery_fee
```

**Formula:** `(Subtotal - Discount) + Delivery Fee`

### Example Calculation

```
Product 1: $50 × 2 = $100
Product 2: $30 × 1 = $30
───────────────────────────
Subtotal:           $130
Discount (10%):     -$13    (applied to subtotal only)
───────────────────────────
Subtotal after discount: $117
Delivery Fee:       +$10    (not affected by discount)
───────────────────────────
Final Total:        $127
```

## Order Fields Stored

| Field | Description |
|-------|-------------|
| `sub_total` | Sum of all item totals |
| `delivery_fee` | Shipping cost based on region |
| `total_price_before_discount` | Subtotal (same as sub_total) |
| `discount` | Discount amount (percentage of subtotal) |
| `total_price_after_discount` | Final total: (subtotal - discount) + delivery_fee |
| `coupon_code` | Applied coupon code (if any) |

## Validations

1. **Region Validation**: Selected region must exist and be active
2. **Product Validation**: Products must exist and be active
3. **Quantity Validation**: Products must have sufficient quantity in stock
4. **Coupon Validation**:
   - Coupon must exist and be active
   - Coupon must not be expired (expiry_date >= current date)

## Transaction Safety

The entire checkout process is wrapped in a database transaction to ensure data consistency:
- If any step fails, all changes are rolled back
- Product quantities are only decremented after successful order creation

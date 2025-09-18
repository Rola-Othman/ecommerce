<?php

use Gloudemans\Shoppingcart\Facades\Cart;

/** Set sidebar items active */
function setActive(array $routes)
{
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
    }
}

/** Check if product have discount */
function checkDiscount($product)
{
    $currentDate = date('Y-m-d');

    if ($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
        return true;
    }

    return false;
}

/** Calculate discount percent */

function calculateDiscountPercent($originalPrice, $discountPrice)
{
    $discountAmount = $originalPrice - $discountPrice;
    $discountPercent = ($discountAmount / $originalPrice) * 100;

    return round($discountPercent);
}


/** Check the product type */

function productType($type)
{
    switch ($type) {
        case 'new_arrival':
            return 'New';
            break;
        case 'featured_product':
            return 'Featured';
            break;
        case 'top_product':
            return 'Top';
            break;

        case 'best_product':
            return 'Best';
            break;

        default:
            return '';
            break;
    }
}

/** get total cart amount */
function getCartTotal()
{
    $total = 0;
    // foreach(Cart::content() as $product){
    //     $total += ($product->price + $product->options->variants_total) * $product->qty;
    // }
    // return $total;

    $total = Cart::content()->sum(function ($product) {
        return ($product->price + $product->options->variants_total) * $product->qty;
    });
    return $total;
}

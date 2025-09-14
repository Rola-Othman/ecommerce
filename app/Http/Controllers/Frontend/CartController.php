<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariantItem;
use App\Models\Proudct;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /** Show cart page  */
    public function cartDetails()
    {
        // $cartItems = Cart::content();

        // if(count($cartItems) === 0){
        //     Session::forget('coupon');
        //     toastr('Please add some products in your cart for view the cart page', 'warning', 'Cart is empty!');
        //     return redirect()->route('home');
        // }

        // $cartpage_banner_section = Adverisement::where('key', 'cartpage_banner_section')->first();
        // $cartpage_banner_section = json_decode($cartpage_banner_section?->value);

        return view('frontend.pages.cart-detail');
        // return view('frontend.pages.cart-detail', compact('cartItems', 'cartpage_banner_section'));
    }

    /**
     ** Add item to cart
     ** اضافة المنتج ال السلة
     * @param Request $request
     */
    public function addToCart(Request $request)
    {
        $product = Proudct::findOrFail($request->product_id);

        /** استرجاع الخصائص لارسالها للسلة */
        $variants = [];
        $variantTotalAmount = 0;
        if ($request->has('variants_items')) { //**التحقق من ان المنتج لديه خصائص لان مو كل منتج عنده خصائص */

            $variantItems = ProductVariantItem::with('productVariant')
                ->whereIn('id', $request->variants_items)
                ->get(); // استرجاع العناصر مرة واحدة بدلا من جلبها واحدة واحد من داخل الحلقة وهذا يؤدي  الى n+1

            foreach ($variantItems as $variantItem) {
                // $variantItem = ProductVariantItem::find($item_id);
                //$variants[$variantItem->productVariant->name]['name'] هي مصفوفة متعددة الابعاد 
                $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
                $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
                $variantTotalAmount += $variantItem->price;
            }
        }

        /** check discount */
        $productPrice = 0;

        if (checkDiscount($product)) {
            $productPrice = $product->offer_price;
        } else {
            $productPrice = $product->price;
        }

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] =  $productPrice; //$product->price * $request->qty;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        // $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        Cart::add($cartData);
        return response(['status' => 'success', 'message' => 'Added to cart successfully!']);
    }
}

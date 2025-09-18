<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariantItem;
use App\Models\Proudct;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     ** Show cart page  
     ** عرض صفحة السلة
     * @return View
     */
    public function cartDetails()
    {
        $cartItems = Cart::content();
        if (count($cartItems) === 0) {
            // Session::forget('coupon');
            flash()->warning('Please add some products in your cart for view the cart page', ['title' => 'Cart is empty!']);
            // toastr('Please add some products in your cart for view the cart page', 'warning', 'Cart is empty!');
            return redirect()->route('home');
        }

        // $cartpage_banner_section = Adverisement::where('key', 'cartpage_banner_section')->first();
        // $cartpage_banner_section = json_decode($cartpage_banner_section?->value);

        return view('frontend.pages.cart-detail', compact('cartItems'));
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
        // check product quantity
        if ($product->qty === 0) {
            return response(['status' => 'error', 'message' => 'Product stock out']);
        } elseif ($product->qty < $request->qty) {
            return response(['status' => 'error', 'message' => 'Quantity not available in our stock']);
        }
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

    /**
     ** Update product quantity
     ** تحديث كمية المنتج
     * @param Request $request
     */
    public function updateProductQty(Request $request)
    {
        $productId = Cart::get($request->rowId)->id;
        $product = Proudct::findOrFail($productId);

        // check product quantity
        if ($product->qty === 0) {
            return response(['status' => 'error', 'message' => 'Product stock out']);
        } elseif ($product->qty < $request->qty) {
            return response(['status' => 'error', 'message' => 'Quantity not available in our stock']);
        }

        Cart::update($request->rowId, $request->quantity);
        $productTotal = $this->getProductTotal($request->rowId);

        return response(['status' => 'success', 'message' => 'Product Quantity Updated!', 'product_total' => $productTotal]);
    }
    /**
     ** get product total
     **   اجمالي المنتج
     * @param string $rowId
     */
    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_total) * $product->qty;
        return $total;
    }

    /** 
     **clear all cart products
     ** مسح جميع المنتجات من السلة
     * @return Response
     */
    public function clearCart()
    {
        Cart::destroy();

        return response(['status' => 'success', 'message' => 'Cart cleared successfully']);
    }

    /**
     ** Remove product form cart
     ** ازالة المنتج من السلة
     * @param string $rowId
     */
    public function removeProduct($rowId)
    {
        Cart::remove($rowId);
        flash()->success('Product removed successfully.');
        return redirect()->back();
    }

    /**
     **  Get cart count 
     ** عدد المنتجات في السلة 
     */
    public function getCartCount()
    {
        return Cart::content()->count();
    }

    /** 
     ** Get all cart products 
     ** جلب جميع المنتجات في السلة
     */
    public function getCartProducts()
    {
        return Cart::content();
    }

    /**
     ** Romve product form sidebar cart
     ** ازالة المنتج من سلة الشريط الجانبي
     * @param Request $request
     */
    public function removeSidebarProduct(Request $request)
    {
        Cart::remove($request->rowId);

        return response(['status' => 'success', 'message' => 'Product removed successfully!']);
    }


    /**
     ** get cart total amount
     ** اجمالي السلة
     */
    public function cartTotal()
    {
        $total = 0;
        // // OLD CODE
        // foreach (Cart::content() as $product) {
        //     $total += $this->getProductTotal($product->rowId);
        // }

        // // NEW CODE
        // $cartItems = Cart::content();
        // $cartItems->map(function ($item) use (&$total) {
        //     $total += $this->getProductTotal($item->rowId);
        //     return $total;
        // });

        // NEW CODE
        $total = Cart::content()->sum(function ($item) {
            return $this->getProductTotal($item->rowId);
        });
        return $total;
    }
}

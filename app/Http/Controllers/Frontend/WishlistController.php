<?php

namespace App\Http\Controllers\Frontend;

use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    /**
     ** Display a wishlist products list.
     ** عرض قائمة المنتجات في قائمة الرغبات.
     * @return View
     */
    public function index()
    {
        $wishlistProducts = WishList::with('product')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('frontend.pages.wishlist', compact('wishlistProducts'));
    }

    /**
     ** Add to wishlist product.
     ** إضافة منتج إلى قائمة الرغبات.
     * @param Request $request
     */
    public function addToWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response(['status' => 'error', 'message' => 'login before add a product into wishlist!']);
        }

        $wishlistCount = Wishlist::where(['product_id' => $request->id, 'user_id' => Auth::user()->id])->count();
        if ($wishlistCount > 0) {
            return response(['status' => 'error', 'message' => 'The product is already at wishlist!']);
        }

        $wishlist = new Wishlist();
        $wishlist->product_id = $request->id;
        $wishlist->user_id = Auth::user()->id;
        $wishlist->save();

        $count = Wishlist::where('user_id', Auth::user()->id)->count();

        return response(['status' => 'success', 'message' => 'Product added into the wishlist!', 'count' => $count]);
    }

    /**
     ** Remove product from wishlist.
     ** إزالة المنتج من قائمة الرغبات.
     * @param string $id
     */
    public function destory(string $id)
    {

        $wishlistProducts = Wishlist::where('id', $id)->firstOrFail();
        if ($wishlistProducts->user_id !== Auth::user()->id) {
            return redirect()->back();
        }
        $wishlistProducts->delete();

        flash()->success('Product removed successfully.');
        return redirect()->back();
    }
}

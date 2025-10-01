<?php

namespace App\Http\Controllers\Frontend;

use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class WishlistController extends Controller
{
    public function index()
    {
        $wishlistProducts = WishList::with('product')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

        return view('frontend.pages.wishlist', compact('wishlistProducts'));
    }

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

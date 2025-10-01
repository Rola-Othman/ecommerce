<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Proudct;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontentProductController extends Controller
{
    /**
     * display the specified product.
     * عرض المنتج المحدد
     * @param string $slug
     * @return View
     */
    public function showProduct(string $slug)
    {
        $product = Proudct::with(['vendor', 'variants', 'category', 'productImageGalleries'])->where('slug', $slug)->where('status', 1)->first();

        return view('frontend.pages.product-detail', compact('product'));
    }

    /**
     * Display a listing of the products.
     * عرض قائمة المنتجات
     * @param Request $request
     * @return View
     */
    public function productsIndex(Request $request)
    {

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $products = Proudct::with(['variants', 'category', 'productImageGalleries'])
                ->where([
                    'category_id' => $category->id,
                    'status' => 1,
                    'is_approved' => 1
                ])
                ->when($request->has('range'), function ($query) use ($request) {

                  

                    $price =explode(';', $request->range);
                    $from = $price[0];
                    $to = $price[1];

                    return $query->where('price', '>=', $from)->where('price', '<=', $to);
                })
                ->paginate(12);
             
        } elseif ($request->has('subcategory')) {
            $category = SubCategory::where('slug', $request->subcategory)->firstOrFail();
            $products = Proudct::with(['variants', 'category', 'productImageGalleries'])
                ->where([
                    'sub_category_id' => $category->id,
                    'status' => 1,
                    'is_approved' => 1
                ])
                ->when($request->has('range'), function ($query) use ($request) {
                    $price = explode(';', $request->range);
                    $from = $price[0];
                    $to = $price[1];

                    return $query->where('price', '>=', $from)->where('price', '<=', $to);
                })
                ->paginate(12);
        } elseif ($request->has('childcategory')) {
            $category = ChildCategory::where('slug', $request->childcategory)->firstOrFail();

            $products = Proudct::with(['variants', 'category', 'productImageGalleries'])
                ->where([
                    'child_category_id' => $category->id,
                    'status' => 1,
                    'is_approved' => 1
                ])
                ->when($request->has('range'), function ($query) use ($request) {
                    $price = explode(';', $request->range);
                    $from = $price[0];
                    $to = $price[1];

                    return $query->where('price', '>=', $from)->where('price', '<=', $to);
                })
                ->paginate(12);
        } elseif ($request->has('brand')) {
            $brand = Brand::where('slug', $request->brand)->firstOrFail();

            $products = Proudct::with(['variants', 'category', 'productImageGalleries'])
                ->where([
                    'brand_id' => $brand->id,
                    'status' => 1,
                    'is_approved' => 1
                ])
                ->when($request->has('range'), function ($query) use ($request) {
                    $price = explode(';', $request->range);
                    $from = $price[0];
                    $to = $price[1];

                    return $query->where('price', '>=', $from)->where('price', '<=', $to);
                })
                ->paginate(12);
        } elseif ($request->has('search')) {
            $products = Proudct::with(['variants', 'category', 'productImageGalleries'])
                ->where(['status' => 1, 'is_approved' => 1])
                ->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('long_description', 'like', '%' . $request->search . '%')
                        ->orWhereHas('category', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('long_description', 'like', '%' . $request->search . '%');
                        });
                })
                ->paginate(12);
        } else {
            $products = Proudct::with(['variants', 'category', 'productImageGalleries'])
                ->where(['status' => 1, 'is_approved' => 1])->orderBy('id', 'DESC')->paginate(12);
        }

        $categories = Category::where(['status' => 1])->get();
        $brands = Brand::where(['status' => 1])->get();
        // // banner ad
        // $productpage_banner_section = Adverisement::where('key', 'productpage_banner_section')->first();
        // $productpage_banner_section = json_decode($productpage_banner_section?->value);
       

        return view('frontend.pages.product', compact('products', 'categories', 'brands'));
    }

    /**
     * Change product list view style.
     * تغيير نمط عرض قائمة المنتجات
     * @param Request $request
     */
    public function chageListView(Request $request)
    {
        Session::put('product_list_style', $request->style);
    }
}

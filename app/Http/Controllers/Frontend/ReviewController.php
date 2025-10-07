<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserProductReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use FileUpload;
     public function index(UserProductReviewsDataTable $dataTable)
    {
        return $dataTable->render('frontend.dashboard.review.index');
    }

    public function create(Request $request)
    {

        $request->validate([
            'rating' => ['required'],
            'review' => ['required', 'max:200'],
            'images.*' => ['image']
        ]);

        $checkReviewExist = ProductReview::where(['proudct_id' => $request->product_id, 'user_id' => Auth::user()->id])->first();
        if($checkReviewExist){
            flash()->error('You already added a review for this product!');
            return redirect()->back();
        }

        $imagePaths =$this->uploadFiles($request->file('images'));
        

        $productReview = new ProductReview();
        $productReview->proudct_id = $request->product_id;
        $productReview->vendor_id = $request->vendor_id;
        $productReview->user_id = Auth::user()->id;
        $productReview->rating = $request->rating;
        $productReview->review = $request->review;
        $productReview->status = 0;

        $productReview->save();

        if(!empty($imagePaths)){

            foreach($imagePaths as $path){
                $reviewGallery = new ProductReviewGallery();
                $reviewGallery->product_review_id = $productReview->id;
                $reviewGallery->image = $path;
                $reviewGallery->save();
            }
        }
   flash()->success('Review added successfully.');

        return redirect()->back();

    }
}

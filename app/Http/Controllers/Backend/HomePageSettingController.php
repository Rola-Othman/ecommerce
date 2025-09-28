<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class HomePageSettingController extends Controller
{
    public function index()
    {
        // $categories = Category::where('status', 1)->get();
        // $popularCategorySection = HomePageSetting::where('key', 'popular_category_section')->first();
        // $sliderSectionOne = HomePageSetting::where('key', 'product_slider_section_one')->first();
        // $sliderSectionTwo = HomePageSetting::where('key', 'product_slider_section_two')->first();
        // $sliderSectionThree = HomePageSetting::where('key', 'product_slider_section_three')->first();

        return view('admin.home-page-setting.index', compact('categories', 'popularCategorySection', 'sliderSectionOne', 'sliderSectionTwo', 'sliderSectionThree'));
    }
}

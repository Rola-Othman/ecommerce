<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     ** Display a category blog page
     ** عرض صفحة فئات المدونة
     * @param BlogCategoryDataTable  $dataTable
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-category.index');
    }

    /**
     ** عرض صفحة إنشاء فئة مدونة جديدة
     ** Display a form to create a new blog category
     * @return View
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     ** حفظ فئة مدونة جديدة
     ** Store a newly created blog category
     * @param Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:blog_categories']
        ], [
            'name.unique' => 'Category already exist!'
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();
        flash()->success('Created successfully.');


        return redirect()->route('admin.blog-category.index');
    }


    /**
     ** عرض صفحة تعديل فئة مدونة
     ** Display a form to edit an existing blog category
     * @param string  $id
     * @return View
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.blog-category.edit', compact('category'));
    }

    /**
     ** تحديث فئة مدونة موجودة
     ** Update an existing blog category
     * @param Request  $request
     * @param string  $id
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200', 'unique:blog_categories,name,' . $id]
        ], [
            'name.unique' => 'Category already exist!'
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        flash()->success('Updated successfully.');

        return redirect()->route('admin.blog-category.index');
    }

    /**
     ** حذف فئة مدونة
     ** Remove the specified blog category
     * @param string  $id
     */
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return response(['status' => 'success', 'message' => 'Deleted successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $category = BlogCategory::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status has been updated!']);
    }
}

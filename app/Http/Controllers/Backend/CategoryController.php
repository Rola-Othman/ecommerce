<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * عرض قائمة التصنيقات
     * show the list of categories
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    /**
     * عرض نموذج إنشاء تصنيف جديد
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * حفظ تصنيف جديد 
     * Store a newly created category
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:200', 'unique:categories,name'],
            'status' => ['required']
        ]);

        $category = new Category();

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        flash()->success('Created successfully.');
        return redirect()->route('admin.category.index');
    }


    /**
     * عرض نموذج تحرير تصنيف موجود
     * Show the form for editing the specified resource.
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:200', 'unique:categories,name,' . $id],
            'status' => ['required']
        ]);

        $category = Category::findOrFail($id);

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        flash()->success('Updated successfully.');
        return redirect()->route('admin.category.index');
    }

    /**
     * حذف التصنيف المحدد
     * Remove the specified resource from storage.
     * @param string $id 
     * @return Response
     */
    public function destroy(string $id): Response
    {
        $category = Category::findOrFail($id);
         $subCategory = SubCategory::where('category_id', $category->id)->count();
        if($subCategory > 0){
            return response(['status' => 'error', 'message' => 'This items contain, sub items for delete this you have to delete the sub items first!']);
        }
        
        $category->delete();

        return response(['status' => 'success', 'Deleted Successfully!']);
    }

    /**
     * تغيير حالة التصنيف
     * Change the status of the category
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request): Response
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status has been updated!']);
    }
}

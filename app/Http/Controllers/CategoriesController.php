<?php

namespace App\Http\Controllers;

use App\Category;
use App\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CategoriesController extends Controller
{

    protected $categoryType;

    /**
     * CategoriesController constructor.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->categoryType = Route::current()->getParameter('categoryType');
    }

    public function index()
    {
        $cats = Category::where('type', $this->categoryType)->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.categories.index', [
            'cats' => $cats,
            'categoryType' => $this->categoryType,
        ]);
    }

    public function create()
    {
        $usedOrders = $this->getUsedCategoryOrders();
        return view('admin.categories.create', ['categoryType' => $this->categoryType, 'usedOrders' => $usedOrders]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'arabic_title' => 'required',
        ]);

        $data = $request->all();
        $data['type'] = $this->categoryType;
        $data['slug'] = str_slug($data['title']);

        $category = Category::create($data);
        $category->addOrUpdateTranslation('category_title', $data['arabic_title']);
        $category->addOrUpdateTranslation('category_description', $data['arabic_description']);

        return redirect()->route('categories', ['categoryType' => $this->categoryType])->with('success', 'Category created successfully');
    }

    public function edit($ct, Category $category)
    {
        $usedOrders = $this->getUsedCategoryOrders();
        return view('admin.categories.edit', [
            'categoryType' => $this->categoryType,
            'category' => $category,
            'usedOrders' => $usedOrders,
        ]);

    }

    public function update(Category $category, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'arabic_title' => 'required',
        ]);

        $data = $request->all();
        $data['slug'] = str_slug($data['title']);

        $category->update($data);
        $category->addOrUpdateTranslation('category_title', $data['arabic_title']);
        $category->addOrUpdateTranslation('category_description', $data['arabic_description']);

        return back()->with('success', 'Category updated successfully');
    }

    private function getUsedCategoryOrders()
    {
        return Category::where('type', $this->categoryType)
            ->select('order')
            ->get()
            ->pluck('order')
            ->toArray();
    }

    public function delete(Category $category)
    {
        $category->delete();
        return back();
    }

}

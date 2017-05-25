<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Forums\Collections\CategoryList;
use App\Forums\Collections\CategoryDetails;


class CategoryController extends Controller
{
    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryList $categoryList)
    {
        $categories = $this->category->active();

        return response()->json(['categories' => $categoryList->reply($categories)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json($this->category->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CategoryDetails $categoryDetails)
    {
        $categories = $this->category->updateOrCreate($request);

        return response()->json(['categories' => $categoryDetails->reply($categories)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Category $category)
    {
        $category = $category->find($id);
        $category->is_hidden = $category->is_hidden? false:true;
        $category->save();

        return fractal($category->withCount('channels', 'threads')->orderBy('order', 'asc')->get(), new CategoryDetails)->respond();
    }
}

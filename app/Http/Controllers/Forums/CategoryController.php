<?php

namespace App\Http\Controllers\Forums;

use App\Forums\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Forums\Fractal\CategoriesList;
use App\Forums\Fractal\CategoryDetails;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        return fractal($category->where('is_hidden', 0)->orderBy('order', 'asc')->get(), new CategoriesList)->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function All(Category $category)
    {
        return fractal($category->withCount('channels', 'threads')->orderBy('order', 'asc')->get(), new CategoryDetails)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $category->updateOrCreate($request);

        return fractal($category->withCount('channels', 'threads')->orderBy('order', 'asc')->get(), new CategoryDetails)->respond();
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

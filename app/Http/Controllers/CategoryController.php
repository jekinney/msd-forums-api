<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Category;
use App\Fractal\Threads;
use App\Fractal\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        return fractal($category->active(), new Categories)->respond();
    }

    public function hidden(Category $category) 
    {
        return fractal($category->hidden(), new Categories)->respond();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $category->addOrUpdate($request);

        $active = fractal($category->active(), new Categories);
        $hidden = fractal($category->hidden(), new Categories);

        return response()->json(['active' => $active, 'hidden' => $hidden]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id, Category $category)
    {
        $catData = $category->with('threads')->find($id);

        $category = fractal($catData, new Categories);
        $threads = fractal($catData->threads, new Threads);

        return response()->json(collect(['category' => $category, 'threads' => $threads]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
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
        $category->toggleHidden($id);

        $active = fractal($category->active(), new Categories);
        $hidden = fractal($category->hidden(), new Categories);

        return response()->json(['active' => $active, 'hidden' => $hidden]);
    }
}

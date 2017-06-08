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
    public function store(Request $request)
    {
        return response()->json($this->category->updateOrCreate($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->category->findByIdForShow($id));    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return response()->json($this->category->toggleHidden($id));
    }
}

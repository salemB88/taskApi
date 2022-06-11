<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model=auth()->user()->Categorys;
        return $model;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $user=auth()->user();

        $validation = $request->validate([
            'title' => 'required',
        ]);

        if (auth()->user()->Categorys()->create($request->all())) {
            return response()->json(['message' => 'Add Successful'], 401);
        } else {
            return response()->json(['message' => 'Error'], 402);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $Category)
    {

        if (auth()->user()->id != $Category->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
       // Eager loading
            $Category->load('Tasks');


            return  new CategoryResource($Category);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gategory $gategory)
    {
        //check if user not own this gategory or didn't have access
        if (auth()->user()->id != $gategory->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $validation = $request->validate([
                'title' => 'required',
            ]);
            $gategory->update($request->all());

            return response()->json(['message' => 'Update Successful'], 402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gategory $gategory)
    {
        //check if user not own this gategory or didn't have access
        if (auth()->user()->id != $gategory->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $gategory->delete();
            return response()->json(['message' => 'Delete Successful'], 402);
        }
    }

    public function restore($id)
    {
        $gategory = Gategory::withTrashed()->findOrFail($id);

        //check if user not own this gategory or didn't have access
        if (auth()->user()->id != $gategory->user_id) {
            return response()->json(['message' => 'Error not Auth'], 401);
        } else {
            $gategory->restore();
            return response()->json(['message' => 'Restore Successful'], 500);
        }
    }
}

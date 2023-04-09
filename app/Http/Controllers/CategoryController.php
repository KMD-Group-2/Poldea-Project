<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Jobs\SendAccountCredential;
use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:QA Manager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('Count(ideas.category_id) as idea_count'),
                'categories.created_at'
            )
            ->leftJoin('ideas', 'categories.id', '=', 'ideas.category_id')
            ->groupBy('ideas.category_id', 'categories.id', 'categories.name', 'categories.created_at')
            ->paginate(10);

        return view('pages.category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return response()->json(['success' => 'Succesfully Added']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if($category->ideas->count() > 0) {
            throw ValidationException::withMessages([
                'name' => 'This category cannot be edited or deleted because there are already ideas in this category.',
            ]);
        }

        $category->update($request->validated());

        return response()->json(['success' => 'Succesfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->ideas->count() > 0) {
            throw ValidationException::withMessages([
                'name' => 'This category cannot be edited or deleted because there are already ideas in this category.',
            ]);
        }

        $category->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }

    public function massDestroy(Request $request)
    {
        $categories = Category::whereIn('id', $request->ids)->get();

        foreach($categories as $category) {
            if($category->ideas->count() > 0) {
                throw ValidationException::withMessages([
                    'name' => $category->name . ' category cannot be edited or deleted because there are already ideas in this category.',
                ]);
            }
        }

        Category::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }
}

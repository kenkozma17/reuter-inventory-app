<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index', [
            'title' => 'Categories',
            'categories' => Category::orderBy('name', 'asc')->paginate(config('utilities.pagination.count', 10))->toJson()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create', [
            'title' => 'Create Category'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $validator = Validator::make($data, [
                'name' => 'required|unique:categories|max:75',
            ]);

            if ($validator->fails()) {
                return redirect('admin/categories/create')->withErrors($validator)->withInput();
            }

            $data['slug'] = Str::slug($data['name']);
            $category = new Category();
            $category->fill($data);
            $category->save();
            return back()->with('success', 'Category Created Successfully');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('categories.edit', [
            'title' => 'Edit Category',
            'category' => Category::where('id', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $validator = Validator::make($data, [
                'name' => ['required', Rule::unique('categories')->ignore($id)],
            ]);

            if ($validator->fails()) {
                return redirect('admin/categories/'.$id.'/edit')->withErrors($validator)->withInput();
            }

            $data['slug'] = Str::slug($data['name']);
            $category = Category::find($id);
            $category->fill($data);
            $category->save();
            return back()->with('success', 'Category Updated Successfully');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCategories(Request $request) {
        $query = $request->get('query');
        $categories = Category::where('name', 'LIKE', '%'. $query. '%')
            ->paginate(
                config('utilities.pagination.count', 10),
                ['*'],
                'page',
                $request->get('page'));

        return response()->json(['results' => $categories]);
    }
}

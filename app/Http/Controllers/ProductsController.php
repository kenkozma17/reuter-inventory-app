<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index', [
            'title' => 'Products',
            'products' => Product::orderBy('name', 'desc')
                            ->paginate(config('utilities.pagination.count', 10))->toJson()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $categories = $categories->mapWithKeys(function($item) {
            return [$item->id => $item->name];
        });
        return view('products.create', [
            'title' => 'Create Product',
            'categories' => $categories
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
                'name' => 'required|unique:products|max:75',
                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect('admin/products/create')->withErrors($validator)->withInput();
            }

            $data['slug'] = Str::slug($data['name']);
            $product = new Product();
            $product->fill($data);
            $product->save();
            return back()->with('success', 'Product Created Successfully');
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
        $categories = Category::orderBy('name', 'asc')->get();
        $categories = $categories->mapWithKeys(function($item) {
            return [$item->id => $item->name];
        });
        return view('products.edit', [
            'title' => 'Edit Product',
            'product' => Product::where('id', $id)->first(),
            'categories' => $categories,
            'transactions' => Transaction::where('product_id', $id)
                ->with('product')
                ->paginate(
                config('utilities.pagination.count', 10))->toJson()
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
                'name' => ['required', Rule::unique('products')->ignore($id)],
//                'quantity' => 'required|numeric',
                'price' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect('admin/products/'.$id.'/edit/')->withErrors($validator)->withInput();
            }

            $data['slug'] = Str::slug($data['name']);
            isset($data['has_notification']) ? $data['has_notification'] = true : $data['has_notification'] = false;
            $product = Product::find($id);
            $product->fill($data);
            $product->save();
            return back()->with('success', 'Product Updated Successfully');
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
        $product = Product::find($id);
        if($product) {
            $product->delete();
            return response()->json(['success' => true]);
        }
    }

    public function getProducts(Request $request) {
        $query = $request->get('query');
        $products = Product::where('name', 'LIKE', '%'. $query. '%')
            ->paginate(
                config('utilities.pagination.count', 10),
                ['*'],
                'page',
                $request->get('page'));

        return response()->json(['results' => $products]);
    }
}

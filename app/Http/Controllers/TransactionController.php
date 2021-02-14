<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')
            ->with('product')
            ->paginate(config('utilities.pagination.count', 10))
            ->toJson();
        return view('transactions.index', [
            'title' => 'Transactions',
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction($productId)
    {
        $product = Product::find($productId);
        if(!$product) { abort(404); }
        return view('transactions.create', [
            'title' => 'Create Transaction',
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productId)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'quantity' => 'required|numeric',
                'transaction_number' => 'required|string',
                'type' => 'required|string|not_in:0',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $product = Product::find($productId);
            if($product) {
                $data['product_id'] = $product['id'];
                $data['previous_quantity'] = $product['quantity'];
                $transaction = new Transaction();
                $transaction->fill($data);
                if ($transaction->save()) {
                    $this->handleTransaction($data['type'], $productId, $data['quantity']);
                }
            }
            return back()->with('success', 'Transaction Created Successfully');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    public function handleTransaction($type, $productId, $quantity) {
        $product = Product::find($productId);
        if($product) {
            switch ($type) {
                case 'withdrawal':
                    $product->quantity -= $quantity;
                break;
                case 'increase':
                    $product->quantity += $quantity;
                    break;
                case 'decrease':
                    $product->quantity -= $quantity;
                    break;
            }
            $product->save();
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
        $transaction = Transaction::find($id);
        return view('transactions.detail', [
            'title' => 'Transaction',
            'transaction' => $transaction
        ]);
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
    public function update(Request $request, $id)
    {
        //
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

    public function getTransactions(Request $request) {
        $query = $request->get('query');
        $transactions = Transaction::where('transaction_number', 'LIKE', '%'. $query. '%')
            ->where('customer_name', 'LIKE', '%'. $query. '%')
            ->paginate(
                config('utilities.pagination.count', 10),
                ['*'],
                'page',
                $request->get('page'));

        return response()->json(['results' => $transactions]);
    }
}

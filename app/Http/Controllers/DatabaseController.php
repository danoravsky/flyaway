<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function showProducts()
    {
        $product = DB::table('products')
            ->where('id', 3)
            ->get();

        $products = DB::table('products')
            ->get();
        $categories = DB::table('categories')
            ->get();
        // foreach ($products as $product) {
        //     echo $product->title;
        // }

        // $alsoProducts = ['book',  'other stuff'];

        // dd($products, $alsoProducts);

        return view('products', compact('products', 'categories'));
        // return view('products')->with('products', $products);

    }

    public function addProduct(Request $product)
    {
        $product->validate([
            'title' => 'required|string|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'required|string'
        ]);

        $update = DB::table('products')
            ->insert(['title' => $product->title,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category,
                'stock' => $product->stock,
                'photo' => $product->photo,
                'created_at' => date('Y-m-d H:i:s')
            ]);

        return redirect('/products');
    }


    public function newProduct(){

        $categories = DB::table('categories')
        ->get();

        return view('newproduct', compact('categories'));
    }

    public function editProduct(Request $product)
    {
        $product->validate([
            'id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'photo' => 'required|string'
        ]);
        $update = DB::table('products')
            ->updateOrInsert(['id' => $product->id],
                ['title' => $product->title,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category,
                'stock' => $product->stock,
                'photo' => $product->photo,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return redirect('/product/' . $product->id);
    }


    public function removeProduct($product_id)
    {
        $product = DB::table('products')
            ->where('id', $product_id)
            ->delete();

        return redirect('/products');
    }

    public function showProduct($id)
    {
        $product = DB::table('products')
            ->where('id', $id)
            ->first();
        $categories = DB::table('categories')
            ->get();

        return view('product', compact('product', 'categories'));
    }

    public function showCategory($category_id)
    {
        $products = DB::table('products')
            ->where('category_id', $category_id)
            ->get();
        // $products = DB::table('products')
        //     ->select('select * from products where category_id = ?', [$category_id])
        //     ->get();
        $categories = DB::table('categories')
            ->get();
        // dd($products);
        return view('products', compact('products', 'categories'));
    }

    public function showCart()
    {
        $user_id = auth()->user()->id;
        if (DB::table('orders')->where([['id_user', $user_id],['state', 'cart']])->exists()) {
            $empty = false;
            $cart = DB::table('orders')
                ->where([['id_user', $user_id], ['state', 'cart']])
                ->first(); // gives me order - id, total, usr_id ,state, ...

            // here i want products with their amounts
            $products = DB::table('products')
                ->join('amounts', function ($join) {
                    $join->on('products.id', '=', 'amounts.product_id')
                        ->where('amounts.order_id', '=', function($query){
                            $query
                                ->select('id')
                                ->from('orders')
                                ->where([['id_user', auth()->user()->id], ['state', 'cart']])
                                ->first();}
                            );
                        })
                        ->get();
            // dd($products);
            return view('cart', compact('products', 'cart', 'empty'));
        } else {
            $empty = true;
            return view('cart', compact('empty'));
        }
    }


    public function addToCart($product_id)
    {

        $user_id = auth()->user()->id;
        $product = DB::table('products')
            ->where('id', $product_id)
            ->first();
        // INSERT orders
        $orders = DB::table('orders')
            ->updateOrInsert(['id_user' => $user_id,
                'state' => 'cart'],
                [
                'id_user' => $user_id,
                'state' => 'cart',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        // GET orders
        $orders = DB::table('orders')
            ->where([['id_user', $user_id], ['state', 'cart']])
            ->first();
        if ($product->stock > 0) {
            // DECREASE stock
            $product_decrease = DB::table('products')
                ->where('id', $product_id)
                ->decrement('stock', 1);
            // INSERT amounts
            $amounts = DB::table('amounts')
                ->updateOrInsert(['order_id' => $orders->id,
                    'product_id' => $product_id],
                    ['order_id' => $orders->id,
                    'product_id' => $product_id,
                    'created_at' => date('Y-m-d H:i:s')
            ]);
            $amounts = DB::table('amounts')
                ->where([['order_id', $orders->id], ['product_id', $product_id]])
                ->increment('amount', 1);
            // GET amounts
            $amounts = DB::table('amounts')
                ->where('order_id', $orders->id)
                ->get();
            // UPDATE orders
            $orders = DB::table('orders')
                ->where([['id_user', $user_id], ['state', 'cart']])
                ->update(['price' => $amounts->sum('amount')*$product->price]);
            // GET orders
            $orders = DB::table('orders')
                ->where([['id_user', $user_id], ['state', 'cart']])
                ->first();
            }
        return redirect('/cart');
    }

    public function removeFromCart($product_id)
    {
        $user_id = auth()->user()->id;
        // GET order
        $order = DB::table('orders')
            ->where([['id_user', $user_id], ['state', 'cart']])
            ->first();
        // GET amount
        $remove = DB::table('amounts')
            ->where([['order_id', $order->id], ['product_id', $product_id]])
            ->decrement('amount', 1);
        // DELETE amount
        $deleted = DB::table('amounts')
            ->where('amount', '<', 1)
            ->delete();
        // GET amounts
        $amounts = DB::table('amounts')
            ->where('order_id', $order->id)
            ->get();
        // INCREMENT product stock
        $addback = DB::table('products')
            ->where('id', $product_id)
            ->increment('stock', 1);
        // GET product
        $product = DB::table('products')
            ->where('id', $product_id)
            ->first();
        if ($amounts->sum('amount') > 0){
            $orders = DB::table('orders')
                ->where([['id_user', $user_id], ['state', 'cart']])
                ->update(['price' => $amounts->sum('amount')*$product->price]);
        } else {
           $deleteOrder = DB::table('orders')
                ->where([['id_user', $user_id], ['state', 'cart']])
                ->delete();
           $deleteAmounts = DB::table('amounts')
                ->where('order_id', $order->id)
                ->delete();
        }

        return redirect('/cart');
    }

    public function checkout()
    {
        $user_id = auth()->user()->id;
        $orders = DB::table('orders')
            ->where([['id_user', $user_id], ['state', 'cart']])
            ->update(['state' => 'checkout']);

        return redirect('/orders');
    }

    public function showOrders()
    {
        $user_id = auth()->user()->id;
        $orders = DB::table('orders')
            ->where([['id_user', $user_id], ['state', 'checkout']])
            ->get();
        $amounts = DB::table('amounts')
            ->leftJoin('orders', 'amounts.order_id', '=', 'orders.id')
            ->get();
        $amount = $amounts->sum('amount');

        return view('orders', compact('orders', 'amount'));
    }
}

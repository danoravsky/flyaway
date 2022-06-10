@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-5"
        style="background-color: #f5f5f5; border-radius: 8px; padding: 24px;">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-center m-5">
                Cart
            </h1>
                @if ($empty)
                    <p>Your cart is empty</p>
                @else

                <table class="border-separate border-spacing-2 border border-slate-400">
                    <thead>
                        <tr>
                            <th>Product name</th>
                            <th>Items</th>
                            <th>Photo</th>
                            <th>Remove item</th>
                        </tr>
                    </thead>
                    <tbody
                    @foreach ($products as $product)
                        <tr>
                            <td class="border border-slate-400 text-center" >{{ $product->title }}</td>
                            <td class="border border-slate-400 text-center">{{ $product->amount }}</td>
                            <td class="border border-slate-400 text-center"><img class="h-24" src="{{ asset('img/' . $product->photo) }}" alt=""></td>
                            <td class="border border-slate-400 text-center"><a href="{{route('removefromcart', ['product_id' => $product->product_id])}}">Remove from cart</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="flex flex-col items-center">
                    <p class="text-center">
                        Total: {{ $cart->price }} €
                    </p>
                    <p class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">
                        <a href="{{route('checkout')}}">Checkout</a>
                    </p>
                </div>
                @endif
        </div>
@endsection

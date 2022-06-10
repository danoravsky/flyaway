@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-5"
        style="background-color: #f5f5f5; border-radius: 8px; padding: 24px;">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-center m-5">
                Categories
            </h1>
                {{-- {{ $products }} --}}
            <div class="flex flex-col items-center">
                <div class="inline-flex m-5">
                    <a href="{{route('products')}}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">>All</a>
                    @foreach ($categories as $category)
                        <a href="{{route('products_categorized', ['category_id' => $category->id])}}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">>{{ucfirst($category->category)}}</a>
                    @endforeach
                </div>
            </div>

            @if (auth()->user()->current_team_id == env('ADMIN_ID'))
                    <a href="{{route('newproduct')}}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">Add new product</a>
            @endif
                    @foreach ( $products as $item)
                    <div class="max-w-sm rounded overflow-hidden shadow-lg mt-6">
                        <a href="{{route('product', ['id' => $item->id])}}">
                        <img class="w-full" src="{{ asset('img/' . $item->photo) }}" alt="{{ $item->title }}">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $item->title }}</div>
                            <p class="text-gray-700 text-base">
                                {{ $item->description }}
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $item->price }} €</span>
                            @if ($item->stock > 0)
                                <a href="{{route('addtocart', ['product_id' => $item->id])}}" >
                                <span class="inline-block bg-green-800 rounded-md px-3 py-1 text-sm font-semibold text-white mr-2 mb-2">Add to cart</span></a>

                            @else
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Out of stock</span>
                            @endif
                            @if (auth()->user()->current_team_id == env('ADMIN_ID'))
                                <span class="inline-block bg-red-900 rounded-md px-3 py-1 text-sm font-semibold text-white mr-2 mb-2"><a href="{{route('removeproduct', ['product_id' => $item->id])}}" >Remove product</a></span>
                            @endif

                        </div>

                        </a>
                    </div>
                @endforeach

        </div>
@endsection

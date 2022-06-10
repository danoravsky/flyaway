@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-5" style="background-color: #f5f5f5; border-radius: 8px; padding: 24px;">
        <div class="flex flex-col items-center">
            <h1 class="text-4xl font-bold text-center m-5">
                {{ $product->title }} product page
            </h1>
            @if (auth()->user()->current_team_id == env('ADMIN_ID'))
                <a href="{{ route('newproduct') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">Add
                    new product</a>
                <p>{{ $product->title }}</p>
                <img src="{{ asset('img/' . $product->photo) }}" alt="">
                <p>{{ $product->description }}</p>
                <p>In stock: {{ $product->stock }}</p>
                <p>{{ $product->price }} €</p>

                <div class="w-full max-w-xs">
                    <form method="POST" action="{{ route('editproduct') }}"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Product title
                            </label>
                            <input name="title" type="text" value="{{ $product->title }}"
                                class="@error('title') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('title')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Product description
                            </label>
                            <input name="description" type="text" value="{{ $product->description }}"
                                class="@error('description') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                            @error('description')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                                Price
                            </label>
                            <input name="price" type="text"
                                class="@error('price') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                type="number" value="{{ $product->price }}" min="0" step="0.01">
                            @error('price')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                                Product category
                            </label>

                            <select name="category"
                                class="@error('category') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($categories as $category)
                                    <option @if ($product->category_id == $category->id) selected @endif
                                        value="{{ $category->id }}">{{ ucfirst($category->category) }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">
                                Stock
                            </label>
                            <input name="stock" type="number" value="{{ $product->stock }}" min="0" step="1"
                                class="@error('stock') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                            @error('stock')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">
                                Photo
                            </label>
                            <input name="photo" type="text" value="{{ $product->photo }}"
                                class="@error('photo') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                            @error('photo')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-center">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Update
                            </button>
                        </div>
                    </form>
                </div>

                @if ($product->stock > 0)
                    <a href="{{ route('addtocart', ['product_id' => $product->id]) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">Add
                        to cart</a>
                @else
                    <p>Out of stock</p>
                @endif
            @else
                <p>{{ $product->title }}</p>
                <img src="{{ asset('img/' . $product->photo) }}" alt="">
                <p>{{ $product->description }}</p>
                <p>In stock: {{ $product->stock }}</p>
                <p>{{ $product->price }} €</p>
                @if ($product->stock > 0)
                    <a href="{{ route('addtocart', ['product_id' => $product->id]) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-4">Add
                        to cart</a>
                @else
                    <p>Out of stock</p>
                @endif
            @endif
        </div>
    @endsection

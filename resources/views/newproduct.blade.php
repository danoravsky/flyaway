@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-5" style="background-color: #f5f5f5; border-radius: 8px; padding: 24px;">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-center m-5">
                Add a new product
            </h1>

            @if (auth()->user()->current_team_id == env('ADMIN_ID'))
                <div class="w-full max-w-xs">
                    <form method="POST" action="{{ route('addproduct') }}"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Product title
                            </label>
                            <input name="title" type="text" value="{{ old('title') }}"
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
                            <input name="description" type="text" value="{{ old('description') }}"
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
                            <input name="price" type="text" value="{{ old('price') }}"
                                class="@error('price') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                type="number" min="0" step="0.01">
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
                                    <option value="{{ $category->id }}">{{ ucfirst($category->category) }}</option>
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
                            <input name="stock" type="number" min="0" step="1" value="{{ old('stock') }}"
                                class="@error('stock') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                            @error('price')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">
                                Photo
                            </label>
                            <input name="photo" type="text" value="{{ old('photo') }}"
                                class="@error('photo') border-red-500 @enderror shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                            @error('photo')
                                <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    @endsection

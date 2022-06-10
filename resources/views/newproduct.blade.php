@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-24"
        style="background-color: #f5f5f5; border-radius: 8px; padding: 24px;">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-center">
                Add a new product
            </h1>

                @if (auth()->user()->current_team_id == env('ADMIN_ID'))

                    <div class="w-full max-w-xs">
                        <form method="POST" action="{{route('addproduct')}}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                            @csrf

                          <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Product title
                            </label>
                            <input name="title" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                          </div>
                          <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                              Product description
                            </label>
                            <input name="description" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                          </div>
                          <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                              Price
                            </label>
                            <input name="price" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"type="number" min="0" step="0.01" >
                          </div>
                          <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                              Product category
                            </label>
                            <input name="category" type="number" min="0" step="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                          </div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">
                              Stock
                            </label>
                            <input name="stock" type="number" min="0" step="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="photo">
                              Photo
                            </label>
                            <input name="photo" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                          </div>
                          <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                              Add Product
                            </button>
                          </div>
                        </form>
                      </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-500 list-none">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    @endif
                @endif
        </div>
@endsection

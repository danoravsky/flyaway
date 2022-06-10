@extends('layouts.app')
@section('content')
    <div class="max-w-lg mx-auto mt-24"
        style="background-color: #f5f5f5; border-radius: 8px; padding: 24px;">
        <div class="flex flex-col items-center">
            <h1 class="text-3xl font-bold text-center">
                Your orders history
            </h1>
            <div class="flex flex-col items-center">
            </div>
                <table class="border-separate border-spacing-2 border border-slate-400">
                    <thead>
                        <tr>
                            <th>Order created</th>
                            <th>Total</th>
                            <th>Invoice</th>
                            <th>Number of items</th>
                        </tr>
                    </thead>
                    <tbody
                    @foreach ($orders as $order)
                        <tr>
                            <td class="border border-slate-400 text-center" >{{ $order->created_at }}</td>
                            <td class="border border-slate-400 text-center">{{ $order->price }} €</td>
                            <td class="border border-slate-400 text-center">{{ $order->id }}</td>
                            <td class="border border-slate-400 text-center">{{ $amount }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
@endsection

@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
    @foreach($products as $product)
        <b>{{ $product->name }}</b>
        <p>¥{{ $product->price }} {{ $product->point }}ポイント</p>
        <p>{{ $product->detail }}</p>
    @endforeach
@endsection

@extends('layouts.horizontal.main')

@section('content.main')
    <div class="container">
        <form action="{{ route('product.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @include('products/partials/form', ["product" => new \App\Entities\Product()])
        </form>
    </div>
@endsection

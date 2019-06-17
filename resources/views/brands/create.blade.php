@extends('layouts.horizontal.main')

@section('content.main')
    <div class="container">
        <form action="{{ route('brand.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @include('brands.partials.form', ['brand' => new \App\Entities\Brand()])
        </form>
    </div>
@endsection





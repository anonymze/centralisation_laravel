@extends('layouts.horizontal.main')

@section('content.main')
    <form class="text-center " action="{{ route('brand.update', [$brand]) }}" enctype="multipart/form-data"
          method="POST">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        @include('brands.partials.form', ['brand' => $brand])
    </form>
@endsection

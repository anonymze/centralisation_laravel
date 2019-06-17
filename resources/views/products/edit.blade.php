@extends('layouts.horizontal.main')

@section('content.main')
    <form class="text-center"
          @if (Request::is('product/*'))
          action="{{ route('product.update', [$product]) }}
                  "
          enctype="multipart/form-data"
          method="POST">
        @else
            action="{{ route('derive.update', [$derive]) }}
            "
            enctype="multipart/form-data"
            method="POST">
        @endif
        @csrf
        <input name="_method" type="hidden" value="PUT">
        @include('products/partials/form',['derive' => $derive])
    </form>
@endsection



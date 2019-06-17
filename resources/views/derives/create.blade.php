@extends('layouts.horizontal.main')

<div class="wrapper mt-3">
    <div class="container-fluid">
        <form action="{{ route('derive.store') }}" method="POST">
            @csrf
            @include('derives/partials/form',["product" => new \App\Entities\Product()])
        </form>
    </div>
</div>


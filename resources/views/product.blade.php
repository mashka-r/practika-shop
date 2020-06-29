@extends('layouts\master')

@section('title', 'Товар') 

@section('content')
   
    <h1>Товар</h1>
    <h2>{{ $product }}</h2>
    <h2>Категория..</h2>
    <p>Цена: <b>...</b></p>
    <img src="">
    <p>Описание:..</p>

    <form action="" method="POST">
            <button type="submit" class="btn btn-success" role="button">
                Добавить в корзину
            </button>
            @csrf        
    </form>
@endsection
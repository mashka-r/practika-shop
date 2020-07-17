@extends('layouts\master')

@section('title', 'Корзина ')

@section('content')
    @if(Session::has('cart') && count($products) > 0)
    <h1>Корзина</h1>
    <p>Оформление заказа</p>
    <div class="panel">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <a href="">
                            <img height="56px" src="">
                            {{ $product['item']['name'] }}
                        </a>
                    </td>
                    <td><span class="badge">{{ $product['qty'] }}</span>
                        <div class="btn-group form-inline">
                               
                            <form action="{{ route('basket-remove' , $product['item']) }}" method="POST">
                                <button type="submit" class="btn btn-danger"
                                    href="">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                                @csrf
                            </form>
                            
                            <form action="{{ route('basket-add' , $product['item']) }}" method="POST">
                                <button type="submit" class="btn btn-success"
                                href=""><span
                                        class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                @csrf
                            </form>
                                                     
                        </div>
                    </td>
                    <td>{{ $product['item']['price'] }} руб.</td>
                    <td>{{ $product['price'] }} руб.</td>
                </tr>
                @endforeach
                
                <tr>
                <td colspan="3">Общая стоимость:</td>
                <td>{{ $totalPrice }} руб.</td>
            </tr>
            </tbody>
        </table>
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{ route('basket-place') }}">Оформить заказ</a>
        </div>
    </div>
    @else
        <p>Ваша корзина пуста</p>
    @endif
@endsection
<div class="col-sm-6 col-md-4">
    <div class="thumbnail">

        <img src="" alt="">
        <div class="caption">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->price }} руб.</p>
        @if($product->count_store - $product->count_res > 0) 
            <p> Количество на складе: {{ $product->count_store - $product->count_res}} </p>
        
        @else
            <p> На складе не осталось товара </p>
        @endif
        <p>
            <form action="{{ route('basket-add', $product->id) }}" method="POST">
                <button type="submit"  class="btn btn-primary" role="button">В корзину</button>
            
                <a href="{{ route('product', [$product->category->code, $product->code]) }}" class="btn btn-default"
                    role="button">Подробнее</a>
                @csrf
            </form>
            
        </p>
        </div>
    </div>
</div>
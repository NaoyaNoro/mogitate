@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="product-content">
    <div class="product-ttl">
        <h2>
            商品一覧
        </h2>
        <a href="/products/register" class="register-form__button-link">
            +商品を追加
        </a>
    </div>

    <div class="product-content-body">
        <div class="product-search">
            <div class="product-search__name">
                <form action="/products/search" class="product-search__form-name" method="POST">
                    @csrf
                    <input type="text" class="product-search__input" name="name" placeholder="商品名で検索">
                    <button class="product-search__button" type="submit">
                        検索
                    </button>
                </form>
            </div>

            <div class="product-search__sort">
                <div class="product-search__ttl">
                    <h3>
                        価格順で表示
                    </h3>
                </div>
                <form action="/products/sort" class="product-search__form-sort" method="POST">
                    @csrf
                    <select name="price_select" id="" class="product-search__select" onchange="this.form.submit()">
                        <option value="" selected hidden>選択してください</option>
                        <option value="高い順に表示" class="product-search__select-value">高い順に表示</option>
                        <option value="低い順に表示" class="product-search__select-value">低い順に表示</option>
                    </select>
                </form>

                @if(session('products'))
                <div class="sort-price__tag">
                    {{ session('sortOrder') }}
                    <a href="/products" class="sort-price__reset">
                        ✖︎
                    </a>
                </div>
                @endif

            </div>
        </div>

        <div class="product-item__group">
            @foreach(session('products', $products) as $product)
            <a href="/products/{{ $product->id }}" class="product-item__link">
                <div class="product-item">
                    <div class="product-item__img">
                        <img src="{{ asset('storage/img/'.$product->image) }}" alt="画像説明">
                    </div>
                    <div class="product-item__tag">
                        <div class="product-item__name">
                            {{ $product->name }}
                        </div>
                        <div class="product-item__price">
                            ¥{{ $product->price }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="product-pagination">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
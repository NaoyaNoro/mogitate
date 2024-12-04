@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/search.css')}}">
@endsection

@section('content')
<div class="product-content">
    <div class="product-ttl">
        <h2>
            "{{ $search_name }}"の商品一覧
        </h2>
    </div>
    <div class="product-content-body">
        <div class="product-search">
            <div class="product-search__name">
                <form action="/products/search" class="product-search__form-name" method="POST">
                    @csrf
                    <input type="text" class="product-search__input" name="name" value="{{ $search_name }}">
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
                    <input type="hidden" value="{{$search_name}}" name="name">
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
            @foreach($search_results as $result)
            <a href="/products/{{ $result->id }}" class="product-item__link">
                <div class="product-item">
                    <div class="product-item__img">
                        <img src="{{ asset('storage/img/'.$result->image) }}" alt="画像説明">
                    </div>
                    <div class="product-item__tag">
                        <div class="product-item__name">
                            {{ $result->name }}
                        </div>
                        <div class="product-item__price">
                            ¥{{ $result->price }}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
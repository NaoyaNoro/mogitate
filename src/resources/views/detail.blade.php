@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/detail.css')}}">
@endsection

@section('content')
<div class="detail-content">
    <div class="detail-content__inner">
        <div class="detail-link">
            <a href="/products" class="detail-link__top">
                商品一覧
            </a>
            >
            {{$detail_results->name}}
        </div>

        <form action="/products/{{$detail_results->id}}/update" class="detail-form__patch" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="detail-content__upper">

                <div class="detail-content__upper--left">
                    <div class="detail-image">
                        <img src="{{ asset('storage/img/'.$detail_results->image) }}" alt="画像説明">
                    </div>

                    <div class="detail-form__item">
                        <input type="file" class="detail-form__input" name="image">
                    </div>

                    @error('image')
                    <span class="error">{{$message}}</span>
                    @enderror
                </div>

                <div class="detail-content__upper--right">
                    <div class="detail-form__item">
                        <p class="detail-form__name">
                            商品名
                        </p>
                        <input type="text" class="detail-form__input" value="{{$detail_results->name}}" name="name" placeholder="商品名を入力">
                    </div>

                    @error('name')
                    <span class="error">{{$message}}</span>
                    @enderror

                    <div class="detail-form__item">
                        <p class="detail-form__name">
                            値段
                        </p>
                        <input type="text" class="detail-form__input" value="{{$detail_results->price}}" name="price" placeholder="値段を入力">
                    </div>

                    @error('price')
                    <span class="error">{{$message}}</span>
                    @enderror

                    <div class="detail-form__item">
                        <p class="detail-form__name">
                            季節
                        </p>
                        @php
                        $seasons_array=[];
                        @endphp

                        @foreach($detail_results->seasons as $season)
                        @php
                        $seasons_array[]=$season->id;
                        @endphp
                        @endforeach

                        <input type="checkbox" name="season[]" class="detail-item__input-checkbox" value="1" {{in_array(1, $seasons_array) ? 'checked' :''}}> 春
                        <input type="checkbox" name="season[]" class="detail-item__input-checkbox" value="2" {{in_array(2, $seasons_array) ? 'checked' :''}}> 夏
                        <input type="checkbox" name="season[]" class="detail-item__input-checkbox" value="3" {{in_array(3, $seasons_array) ? 'checked' :''}}> 秋
                        <input type="checkbox" name="season[]" class="detail-item__input-checkbox" value="4" {{in_array(4, $seasons_array) ? 'checked' :''}}> 冬
                    </div>

                    @error('season')
                    <span class="error">{{$message}}</span>
                    @enderror
                </div>
            </div>


            <div class="detail-form__item">
                <p class="detail-form__name">
                    商品説明
                </p>
                <textarea id="" class="detail-form__textarea" name="description" placeholder="商品の説明を入力">{{$detail_results->description}}</textarea>

                @error('description')
                <span class="error">{{$message}}</span>

                @enderror
            </div>

            <div class="detail-form__button">

                <a href="/products" class="detail-form__button-return">
                    戻る
                </a>
                <button class="detail-form__button-submit" type="submit">
                    変更を保存
                </button>
            </div>
        </form>

        <form action="/products/{{$detail_results->id}}/delete" class="detail-form__delete" method="POST">
            @method('DELETE')
            @csrf

            <button type="submit" style="background:none; border:none; cursor:pointer;" class="detail-form__delete-button">
                <i class="fas fa-trash" style="color:red;"></i>
            </button>
        </form>
    </div>
</div>

@endsection
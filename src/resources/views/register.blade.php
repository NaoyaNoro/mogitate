@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection

@section('content')
<div class="register-content">
    <div class="register-content__inner">
        <div class="register-ttl">
            <h2>
                商品登録
            </h2>
        </div>

        <form action="/products/register" class="register-item__form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="register-item">
                <div class="register-item__tag">
                    商品名
                    <span class="register-item__required">
                        必須
                    </span>
                </div>
                <div class="register-item__input">
                    <input type="text" class="register-item__input-name" name="name" placeholder="商品名を入力">
                </div>
                @error('name')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="register-item">
                <div class="register-item__tag">
                    値段
                    <span class="register-item__required">
                        必須
                    </span>
                </div>
                <div class="register-item__input">
                    <input type="text" class="register-item__input-price" name="price" placeholder="値段を入力">
                    @error('price')
                    <span class="error">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="register-item">
                <div class="register-item__tag">
                    商品画像
                    <span class="register-item__required">
                        必須
                    </span>
                </div>

                <div id="image-preview" class="image-preview">
                    
                </div>

                <div class="register-item__input">
                    <input type="file" class="register-item__input-image" name="image" accept="image/*" id="image-input">
                </div>

                @error('image')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="register-item">
                <div class="register-item__tag">
                    季節
                    <span class="register-item__required">
                        必須
                    </span>
                    <span class="register-item__required-season">
                        複数選択可
                    </span>
                </div>
                <div class="register-item__input">
                    <input type="checkbox" name="season[]" value="1" class="register-item__input-checkbox"> 春
                    <input type="checkbox" name="season[]" value="2" class="register-item__input-checkbox"> 夏
                    <input type="checkbox" name="season[]" value="3" class="register-item__input-checkbox"> 秋
                    <input type="checkbox" name="season[]" value="4" class="register-item__input-checkbox"> 冬
                </div>
                @error('season')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="register-item">
                <div class="register-item__tag">
                    商品説明
                    <span class="register-item__required">
                        必須
                    </span>
                </div>
                <div class="register-item__input">
                    <textarea name="description" id="" placeholder="商品の説明を入力" class="register-item__input-description"></textarea>
                    @error('description')
                    <span class="error">{{$message}}</span>
                    @enderror
                </div>
            </div>

            <div class="register-form__button">
                <div class="register-form__button-return">
                    <a href="/products" class="register-form__button-return--a">
                        戻る
                    </a>
                </div>
                <div>
                    <button type="submit" class="register-form__button-submit">
                        登録
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('image-input').addEventListener('change', function(event) {
        const file = event.target.files[0]; // 選択されたファイル
        const preview = document.getElementById('image-preview');
        preview.innerHTML = ""; // プレビューをクリア

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };

            reader.readAsDataURL(file); // ファイルをDataURLとして読み込む
        }
    });
</script>
@endsection
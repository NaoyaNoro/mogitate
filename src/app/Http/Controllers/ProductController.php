<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSeason;
use App\Http\Requests\DetailRequest;
use App\Http\Requests\RegisterRequest;


class ProductController extends Controller
{
    public function index()
    {
        $products=Product::paginate(6);
        return view('index',['products'=>$products]);
    }


    public function search(Request $request)
    {
        $search_name=$request->name;
        $search_results=Product::where('name','LIKE',"%{$request->name}%")->get();
        return view('search',compact('search_results','search_name'));
    }


    public function sort(Request $request)
    {
        $sortOrder = $request->price_select;
        if(is_null($request->name)){
            if ($sortOrder == '高い順に表示') {
                $products = Product::orderBy('price', 'desc')->get();
            } elseif ($sortOrder == '低い順に表示') {
                $products = Product::orderBy('price', 'asc')->get();
            } else {
                $products = Product::all();
            }
        }else{
            if ($sortOrder == '高い順に表示') {
                $products = Product::where('name', 'LIKE', "%{$request->name}%")->orderBy('price', 'desc')->get();
            } elseif ($sortOrder == '低い順に表示') {
                $products = Product::where('name', 'LIKE', "%{$request->name}%")->orderBy('price', 'asc')->get();
            } else {
                $products = Product::where('name', 'LIKE', "%{$request->name}%")->get();
            }
        }
        return redirect('/products')->with([
            'products' => $products,
            'sortOrder' => $sortOrder
        ]);
    }

    public function detail($id)
    {
        $detail_results=Product::with('seasons')->find($id);
        return view('detail', compact('detail_results'));
    }

    public function update(DetailRequest $request)
    {
        if ($request->hasFile('image')) {
            // 保存先のディレクトリを指定
            $destinationPath = storage_path('app/public/img');

            // オリジナルのファイル名を取得
            $filename = $request->file('image')->getClientOriginalName();

            // ファイルを保存
            $request->file('image')->move($destinationPath, $filename);
        } else {
            // 元の画像名を保持
            $filename = Product::find($request->id)->image;
        }

        // データベースを更新
        $product = Product::find($request->id);
        $product->update([
            'image' => $filename, // ファイル名のみを保存
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $seasons = ProductSeason::where('product_id', $request->id)->get();

        // seasons の数と request->season の数を比較
        $seasonsCount = $seasons->count();
        $requestSeasonsCount = count($request->season);

        // seasons の数が少ない場合、足りない分だけ新しく追加
        if ($seasonsCount < $requestSeasonsCount) {
            // 足りない分だけ追加
            foreach (array_slice($request->season, $seasonsCount) as $number) {
                ProductSeason::create([
                    'product_id' => $request->id,
                    'season_id' => $number,
                ]);
            }
        }

        // seasons の数が多い場合、余分なデータを削除
        if ($seasonsCount > $requestSeasonsCount) {
            // 超過した分を削除
            $excessSeasons = $seasons->slice($requestSeasonsCount);
            foreach ($excessSeasons as $excessSeason) {
                $excessSeason->delete();
            }
        }

        // seasons の数が一致している場合、各レコードを更新
        foreach ($seasons as $index => $season) {
            if (isset($request->season[$index])) {
                $season->update([
                    'season_id' => $request->season[$index],
                ]);
            }
        }

        return redirect('/products');
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect('/products');
    }

    public function register()
    {
        return view('register');
    }

    public function add(RegisterRequest $request)
    {
        // 保存先のディレクトリを指定
        $destinationPath = storage_path('app/public/img');

            // オリジナルのファイル名を取得
        $filename = $request->file('image')->getClientOriginalName();

            // ファイルを保存
        $request->file('image')->move($destinationPath, $filename);

        $product=Product::create([
            'image' => $filename,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $productID=$product->id;

        foreach($request->season as $number){
            ProductSeason::create([
                'product_id'=>$productID,
                'season_id'=>$number
            ]);
        }
        return redirect('/products');
    }
}

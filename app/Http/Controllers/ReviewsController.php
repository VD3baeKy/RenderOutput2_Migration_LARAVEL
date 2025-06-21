<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\House;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Log; // Logger
use Illuminate\Pagination\LengthAwarePaginator;

class ReviewsController extends Controller{
    public function index(Request $request){
        // パラメータ取得
        $keyword = $request->input('keyword');
        $area = $request->input('area');
        $price = $request->input('price');
        $order = $request->input('order');
        $reviewhouseId = $request->input('reviewhouseId', 0);
        $uid = $request->input('uid', 0);

        // 認証ユーザー情報
        $user = Auth::user();
        $currentUserId = $user ? $user->id : null;

        // ページネーション(デフォは1ページ5件でソート順ASC)
        $perPage = 5;
        $sortField = 'id';
        $sortDir = $request->input('direction', 'asc');

        // 基本クエリ
        $query = Review::with(['house', 'user']); // Eagerロード

        // -------- 検索条件 --------（ここはそのまま）
        if(!empty($keyword)) {
            if ($order === 'priceAsc') {
                $query->whereHas('house', function($q) use ($keyword){
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('address', 'like', "%{$keyword}%");
                })->join('houses', 'reviews.house_id', '=', 'houses.id')
                  ->orderBy('houses.price', 'asc');
            } else {
                $query->whereHas('house', function($q) use ($keyword){
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('address', 'like', "%{$keyword}%");
                })->orderByDesc('created_at');
            }
        } elseif (!empty($area)) {
            if ($order === 'priceAsc') {
                $query->whereHas('house', function($q) use ($area){
                    $q->where('address', 'like', "%{$area}%");
                })->join('houses', 'reviews.house_id', '=', 'houses.id')
                  ->orderBy('houses.price', 'asc');
            } else {
                $query->whereHas('house', function($q) use ($area){
                    $q->where('address', 'like', "%{$area}%");
                })->orderByDesc('created_at');
            }
        } elseif (!empty($price)) {
            if ($order === 'priceAsc') {
                $query->whereHas('house', function($q) use ($price){
                    $q->where('price', '<=', $price);
                })->join('houses', 'reviews.house_id', '=', 'houses.id')
                  ->orderBy('houses.price', 'asc');
            } else {
                $query->whereHas('house', function($q) use ($price){
                    $q->where('price', '<=', $price);
                })->orderByDesc('created_at');
            }
        } elseif ($reviewhouseId > 0) {
            if ($order === 'priceAsc') {
                $query->where('house_id', $reviewhouseId)
                    ->join('houses', 'reviews.house_id', '=', 'houses.id')
                    ->orderBy('houses.price', 'asc');
            } else {
                $query->where('house_id', $reviewhouseId)
                    ->orderByDesc('created_at');
            }
        } elseif ($uid == 1 && $currentUserId != null) {
            if ($order === 'priceAsc') {
                $query->where('user_id', $currentUserId)
                    ->join('houses', 'reviews.house_id', '=', 'houses.id')
                    ->orderBy('houses.price', 'asc');
            } else {
                $query->where('user_id', $currentUserId)
                    ->orderByDesc('created_at');
            }
        } else {
            if ($order === 'priceAsc') {
                $query->join('houses', 'reviews.house_id', '=', 'houses.id')->orderBy('houses.price', 'asc');
            } else {
                $query->orderByDesc('created_at');
            }
        }

        // ページネート。get()→LengthAwarePaginator。
        $page = (int) $request->input('page', 1);
        $total = $query->get()->count();
        $reviewModels = $query->skip(($page-1)*$perPage)->take($perPage)->get();

        // ★ DTO的な配列に変換
        $reviewList = $reviewModels->map(function($item) {
            return [
                'review' => $item,
                'house'  => $item->house,
                'user'   => $item->user,
            ];
        });

        // ★ DTO配列でページネータを作成
        $reviewPage = new LengthAwarePaginator($reviewList, $total, $perPage, $page, [
            'path' => url()->current(),
            'query' => $request->query()
        ]);

        // JSON化
        $reviewListJson = $reviewList->toJson(JSON_UNESCAPED_UNICODE);

        // ログ出力
        Log::debug('reviewPage', ['reviewPage' => $reviewPage]);
        Log::debug('keyword', ['keyword' => $keyword]);
        Log::debug('area', ['area' => $area]);
        Log::debug('price', ['price' => $price]);
        Log::debug('order', ['order' => $order]);
        Log::debug('pageable', ['page' => $page, 'perPage' => $perPage]);

        // レビューの有無チェック
        $hasWrittenReview = false;
        if ($user) {
            $hasWrittenReview = $reviewList->contains(function($r) use($currentUserId){
                return optional($r['review']->user_id) === $currentUserId;
            });
        }

        // Bladeで使う変数を渡す
        return view('reviews.index', [
            'reviewList'       => $reviewList,
            'reviewListJson'   => $reviewListJson,
            'reviewPage'       => $reviewPage,
            'reviews'          => $reviewPage, // ← ここがポイント
            'keyword'          => $keyword,
            'area'             => $area,
            'price'            => $price,
            'order'            => $order,
            'reviewhouseId'    => $reviewhouseId,
            'currentUserId'    => $currentUserId ?? -1,
            'hasWrittenReview' => $hasWrittenReview,
            'loginwas'         => $user !== null,
            'isAuthenticatedData' => Auth::check(),
            'uidid'               => $uid,
        ]);
    }
}



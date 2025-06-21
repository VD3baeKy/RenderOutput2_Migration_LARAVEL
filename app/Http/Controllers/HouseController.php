<?php
    namespace App\Http\Controllers;

    use App\Models\House;
    use App\Models\Review;
    use App\Models\Loves;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class HouseController extends Controller{
        
	public function index(Request $request)
        {
            // 例: ページネーション付きで民宿取得
            $query = House::query();

            // 検索条件等
            if ($request->filled('keyword')) {
                $query->where('name', 'like', '%'.$request->input('keyword').'%');
            }
            if ($request->filled('area')) {
                $query->where('address', 'like', '%'.$request->input('area').'%');
            }
            if ($request->filled('price')) {
                $query->where('price', '<=', $request->input('price'));
            }
            if ($request->input('order') === 'priceAsc') {
                $query->orderBy('price', 'asc');
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = 5;
            $housePage = $query->paginate($perPage);

            // Bladeに$housePageを渡す
            return view('houses.index', [
                'housePage' => $housePage,
                // ...他の変数も必要なら追加
            ]);
	}

        public function show($id){
            $house = House::findOrFail($id);
            $reviews = Review::where('house_id', $id)->orderBy('created_at', 'desc')->get();
            $userAll = User::all();

            $user = Auth::user();
            $likeThis = false;
            $hasWrittenReview = false;

            if($user) {
                // お気に入り判定
                $likeThis = Loves::where('user_id', $user->id)->where('house_id', $id)->exists();
                // レビュー済み判定
                $hasWrittenReview = Review::where('user_id', $user->id)->where('house_id', $id)->exists();
            }

            return view('houses.show', compact('house', 'reviews', 'userAll', 'user', 'likeThis', 'hasWrittenReview'));
	}

	public function favoriteAdd($houseId, $userId)
        {
            // 既にお気に入り登録済みかチェック
            $exists = Loves::where('house_id', $houseId)->where('user_id', $userId)->exists();
            if (!$exists) {
                $love = new Loves();
                $love->house_id = $houseId;
                $love->user_id = $userId;
                $love->save();
                session()->flash('successMessage', 'お気に入り登録しました。');
            } else {
                session()->flash('successMessage', 'すでにお気に入り登録済みです。');
            }
            return redirect()->route('houses.show', ['id' => $houseId]);
        }

        public function favoriteRemove($houseId, $userId)
        {
            Loves::where('house_id', $houseId)->where('user_id', $userId)->delete();
            session()->flash('successMessage', 'お気に入りを解除しました。');
            return redirect()->route('houses.show', ['id' => $houseId]);
        }

    }

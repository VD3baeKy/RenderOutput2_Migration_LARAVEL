<?
    namespace app\http\Controllers;

    use app\Models\House;
    use app\Models\Review;
    use app\Models\Favorite;
    use app\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class HouseController extends Controller{
        public function index(Request $request){
            // 検索条件を取得
            $keyword = $request->input('keyword');
            $area = $request->input('area');
            $price = $request->input('price');
            $order = $request->input('order');

            // クエリビルダで条件検索
            $query = House::query();
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%")
                       ->orWhere('address', 'like', "%$keyword%");
                });
            }
            if ($area) {
                $query->where('address', 'like', "%$area%");
            }
            if ($price) {
                $query->where('price', '<=', $price);
            }

            // 並び順切替
            if ($order === 'priceAsc') {
                $query->orderBy('price', 'asc');
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $houses = $query->paginate(5); // ページネーション

            return view('houses.index', compact('houses', 'keyword', 'area', 'price', 'order'));
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
                $likeThis = Favorite::where('user_id', $user->id)->where('house_id', $id)->exists();
                // レビュー済み判定
                $hasWrittenReview = Review::where('user_id', $user->id)->where('house_id', $id)->exists();
            }

            return view('houses.show', compact('house', 'reviews', 'userAll', 'user', 'likeThis', 'hasWrittenReview'));
        }
    }

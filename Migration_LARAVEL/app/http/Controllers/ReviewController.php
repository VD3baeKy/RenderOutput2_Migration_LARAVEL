<?php

  namespace app\http\Controllers;

  use app\Models\Review;
  use app\Models\House;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class ReviewController extends Controller{
    public function store(Request $request, $houseId){
        $request->validate([
            'review_text' => 'required',
            'rating' => 'required|integer|between:1,5'
        ]);

        // 新規レビュー
        Review::create([
            'user_id' => Auth::id(),
            'house_id' => $houseId,
            'review_text' => $request->review_text,
            'rating' => $request->rating
        ]);

        return redirect()->route('houses.show', $houseId)->with('success', 'レビューを登録しました。');
    }

    public function update(Request $request, $houseId, $reviewId){
        $review = Review::findOrFail($reviewId);

        if($review->user_id !== Auth::id()){
            abort(403, "You do not have permission to edit this review.");
        }

        $review->update([
            'review_text' => $request->input('fixContent'),
            'rating' => $request->input('fixRating'),
        ]);

        return redirect()->route('houses.show', $houseId)->with('success', 'レビューを修正しました。');
    }

    public function destroy(Request $request, $houseId, $reviewId){
        $review = Review::findOrFail($reviewId);

        // 管理者(例: user_id==2) or 本人のみ削除可
        if($review->user_id !== Auth::id() && Auth::id() !== 2){
            abort(403, "You do not have permission to delete this review.");
        }
        $review->delete();

        return redirect()->route('houses.show', $houseId)->with('success', 'レビューを削除しました。');
    }
}

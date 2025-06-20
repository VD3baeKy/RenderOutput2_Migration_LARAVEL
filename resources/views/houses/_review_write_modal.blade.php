<!-- レビュー投稿モーダル -->
<div class="modal fade" id="writeModal" tabindex="-1" aria-labelledby="writeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('review.store', ['house' => $house->id]) }}">
                @csrf
                <input type="hidden" name="reviewUserId" value="{{ $user_id }}">
                <input type="hidden" name="reviewhouseId" value="{{ $house->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="writeModalLabel">［{{ $house->name }}］のレビュー投稿</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label>内容:</label>
                        <textarea id="writeContent" name="reviewText" class="form-control" style="width: 90%;">{{ old('reviewText') }}</textarea>
                        @error('reviewText')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label>評価:</label>
                        <select id="writeRatingNumber" name="rating" class="form-select">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" @selected(old('rating') == $i)>{{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">レビュー書込</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                </div>
            </form>
        </div>
    </div>
</div>

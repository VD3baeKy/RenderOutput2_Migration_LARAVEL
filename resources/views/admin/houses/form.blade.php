<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="name" class="col-form-label fw-bold">民宿名</label>
    </div>
    <div class="col-md-8">
        @error('name')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $house->name ?? '') }}" autofocus>
    </div>
</div>

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="imageFile" class="col-form-label fw-bold">民宿画像</label>
    </div>
    <div class="col-md-8">
        @error('imageFile')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="file" name="imageFile" id="imageFile" class="form-control" accept="image/*">
    </div>
</div>

@if (!empty($house?->image_name))
<div class="row" id="imagePreview">
    <img src="{{ asset('storage/' . $house->image_name) }}" class="mb-3" style="max-width:100%;">
</div>
@endif

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="description" class="col-form-label fw-bold">説明</label>
    </div>
    <div class="col-md-8">
        @error('description')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <textarea name="description" id="description" class="form-control" cols="30" rows="5">{{ old('description', $house->description ?? '') }}</textarea>
    </div>
</div>

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="price" class="col-form-label fw-bold">宿泊料金（単位：円）</label>
    </div>
    <div class="col-md-8">
        @error('price')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $house->price ?? '') }}">
    </div>
</div>

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="capacity" class="col-form-label fw-bold">定員（単位：人）</label>
    </div>
    <div class="col-md-8">
        @error('capacity')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $house->capacity ?? '') }}">
    </div>
</div>

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="postal_code" class="col-form-label fw-bold">郵便番号</label>
    </div>
    <div class="col-md-8">
        @error('postal_code')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code', $house->postal_code ?? '') }}">
    </div>
</div>

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="address" class="col-form-label fw-bold">住所</label>
    </div>
    <div class="col-md-8">
        @error('address')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $house->address ?? '') }}">
    </div>
</div>

<div class="form-group row mb-3">
    <div class="col-md-4">
        <label for="phone_number" class="col-form-label fw-bold">電話番号</label>
    </div>
    <div class="col-md-8">
        @error('phone_number')
            <div class="text-danger small mb-2">{{ $message }}</div>
        @enderror
        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $house->phone_number ?? '') }}">
    </div>
</div>



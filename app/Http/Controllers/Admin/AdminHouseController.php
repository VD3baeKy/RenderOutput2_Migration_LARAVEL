<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\HouseRegisterRequest;
    use App\Http\Requests\HouseEditRequest;
    use App\Models\House;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class AdminHouseController extends Controller{
        
	public function index(Request $request){
           $keyword = $request->input('keyword');
           $houses = House::when($keyword, function ($query, $keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
               })
               ->orderBy('id', 'asc')
	       ->paginate(10);

            return view('admin.houses.index', compact('houses', 'keyword'));
	}

        public function show($id){
            $house = House::findOrFail($id);
            return view('admin.houses.show', compact('house'));
        }

        public function create(){
            return view('admin.houses.register');
        }

	/*
        public function store(HouseRegisterRequest $request){
            House::create($request->validated());
            return Redirect::route('admin.houses.index')->with('successMessage', '民宿を登録しました。');
	}
	 */

	public function store(HouseRegisterRequest $request){
            $validated = $request->validated();

            // 画像アップロード処理
            if ($request->hasFile('imageFile')) {
                $path = $request->file('imageFile')->store('houses', 'public');
                $validated['image_name'] = $path;
            }

            House::create($validated);

            return Redirect::route('admin.houses.index')->with('successMessage', '民宿を登録しました。');
        }


        public function edit($id){
            $house = House::findOrFail($id);
            return view('admin.houses.edit', compact('house'));
        }

	/*
        public function update(HouseEditRequest $request, $id){
            $house = House::findOrFail($id);
            $validated = $request->validated();

            $house->name = $validated['name'];
            $house->description = $validated['description'] ?? '';
            $house->price = $validated['price'];
            $house->capacity = $validated['capacity'];
            $house->postal_code = $request->input('postalCode');
            $house->address = $request->input('address');
            $house->phone_number = $request->input('phoneNumber');

            // 画像ファイル処理
            if ($request->hasFile('imageFile')) {
                $path = $request->file('imageFile')->store('houses', 'public');
                $house->image_name = $path;
            }

            $house->save();

            return Redirect::route('admin.houses.index')->with('successMessage', '民宿情報を編集しました。');
	}
        */

	public function update(HouseEditRequest $request, $id)
        { 
            $house = House::findOrFail($id);
            $validated = $request->validated();

            if ($request->hasFile('imageFile')) {
                $path = $request->file('imageFile')->store('houses', 'public');
                $validated['image_name'] = $path;
            }

            $house->update($validated);

            return redirect()->route('admin.houses.index')->with('successMessage', '民宿情報を編集しました。');
        }

        public function destroy($id){
            $house = House::findOrFail($id);
            $house->delete();
            return Redirect::route('admin.houses.index')->with('successMessage', '民宿を削除しました。');
        }
    }

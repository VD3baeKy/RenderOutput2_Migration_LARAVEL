<?php

  namespace app\http\Controllers;

  use app\Models\House;
  use app\Models\Reservation;
  use app\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Session;

  // Serviceクラスが必要
  use app\Services\ReservationService;
  use app\Services\StripeService;

  class ReservationController extends Controller{
    protected $reservationService;
    protected $stripeService;

    public function __construct(ReservationService $reservationService, StripeService $stripeService){
        $this->reservationService = $reservationService;
        $this->stripeService = $stripeService;
    }

    // 予約一覧
    public function index(Request $request){
        $user = Auth::user();
        // Eloquentのリレーションを使うか、↓のように明示的に
        $reservations = Reservation::where('user_id', $user->id)
                                ->orderByDesc('created_at')
                                ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    // 入力フォーム画面
    public function input($id, Request $request){
        $house = House::findOrFail($id);

        $data = $request->all();
        $numberOfPeople = isset($data['number_of_people']) ? (int)$data['number_of_people'] : null;
        $capacity = $house->capacity;

        $errors = [];
        if ($numberOfPeople !== null) {
            if (!$this->reservationService->isWithinCapacity($numberOfPeople, $capacity)) {
                $errors['number_of_people'] = '宿泊人数が定員を超えています。';
            }
        }

        if (!empty($errors)) {
            return redirect()
                ->route('houses.show', $id)
                ->withErrors($errors)
                ->withInput()
                ->with('errorMessage', '予約内容に不備があります。');
        }

        // 入力内容をSessionなどで持ち越す
        Session::flash('reservationInput', $data);
        return redirect()->route('reservations.confirm', $id);
    }

    // 確認画面
    public function confirm($id, Request $request){
        $house = House::findOrFail($id);
        $user = Auth::user();

        // 入力値の取得(Session or Flash or GET Parameter)
        $input = Session::get('reservationInput') ?? $request->all();

        // チェックイン・アウト日
        $checkinDate = $input['checkin_date'] ?? null;
        $checkoutDate = $input['checkout_date'] ?? null;
        $numberOfPeople = $input['number_of_people'] ?? null;

        if (!$checkinDate || !$checkoutDate || !$numberOfPeople) {
            // 値確認して足りなければ入力画面へ戻す
            return redirect()->route('houses.show', $id)->with('errorMessage', '予約に必要な情報が不足しています。');
        }

        $price = $house->price;
        $amount = $this->reservationService->calculateAmount($checkinDate, $checkoutDate, $price);

        // 独自のフォームオブジェクト的役割
        $reservationRegisterForm = [
            'house_id'   => $house->id,
            'user_id'    => $user->id,
            'checkin_date'  => $checkinDate,
            'checkout_date' => $checkoutDate,
            'number_of_people' => $numberOfPeople,
            'amount'     => $amount,
        ];

        // Stripe決済セッションID生成
        $sessionId = $this->stripeService->createStripeSession($house->name, $reservationRegisterForm, $request);

        return view('reservations.confirm', [
            'house' => $house,
            'reservationRegisterForm' => $reservationRegisterForm,
            'sessionId' => $sessionId,
        ]);
    }

    /*
    // 実際の予約作成処理
    public function create(Request $request, $id)
    {
        $this->reservationService->create($request->all());
        return redirect()->route('reservations.index')->with('success', '予約が完了しました。');
    }
    */
}

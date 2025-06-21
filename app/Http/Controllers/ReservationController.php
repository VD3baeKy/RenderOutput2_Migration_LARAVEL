<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// Serviceクラスが必要
use App\Services\ReservationService;
use App\Services\StripeService;

class ReservationController extends Controller
{
    protected $reservationService;
    protected $stripeService;

    public function __construct(ReservationService $reservationService, StripeService $stripeService)
    {
        $this->reservationService = $reservationService;
        $this->stripeService = $stripeService;
    }

    // 予約一覧
    public function index()
    {
        $user = Auth::user();
        $reservationPage = Reservation::with('house')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('reservations.index', [
            'reservationPage' => $reservationPage,
        ]);
    }

    // 入力フォーム画面 → 予約内容確認画面への遷移
    public function input($id, Request $request)
    {
        $house = House::findOrFail($id);

        // フォームからの値を受け取る
        $data = $request->all();

        // Flatpickrのrange対応
        // checkin_checkout_rangeが"YYYY-MM-DD to YYYY-MM-DD"形式で送られてくる場合を分解
        if (isset($data['checkin_checkout_range']) && strpos($data['checkin_checkout_range'], 'to') !== false) {
            [$checkin, $checkout] = array_map('trim', explode('to', $data['checkin_checkout_range']));
            $data['checkin_date'] = $checkin;
            $data['checkout_date'] = $checkout;
        }

        // 宿泊人数
        $numberOfPeople = isset($data['number_of_people']) ? (int)$data['number_of_people'] : null;
        $capacity = $house->capacity;

        $errors = [];
        if ($numberOfPeople !== null) {
            if (!$this->reservationService->isWithinCapacity($numberOfPeople, $capacity)) {
                $errors['number_of_people'] = '宿泊人数が定員を超えています。';
            }
        }

        // 必須項目のバリデーション
        if (empty($data['checkin_date']) || empty($data['checkout_date']) || empty($numberOfPeople)) {
            $errors['checkin_checkout_range'] = 'チェックイン・チェックアウト日と宿泊人数は必須です。';
        }

        if (!empty($errors)) {
            return redirect()
                ->route('houses.show', $id)
                ->withErrors($errors)
                ->withInput()
                ->with('errorMessage', '予約内容に不備があります。');
        }

        // 入力内容をSessionで持ち越す
        Session::flash('reservationInput', [
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date'],
            'number_of_people' => $numberOfPeople
        ]);

        return redirect()->route('reservations.confirm', $id);
    }

    // 確認画面
    public function confirm($id, Request $request)
    {
        $house = House::findOrFail($id);
        $user = Auth::user();

        $input = Session::get('reservationInput') ?? $request->all();
        $checkinDate = $input['checkin_date'] ?? null;
        $checkoutDate = $input['checkout_date'] ?? null;
        $numberOfPeople = $input['number_of_people'] ?? null;

        if (!$checkinDate || !$checkoutDate || !$numberOfPeople) {
            return redirect()->route('houses.show', $id)->with('errorMessage', '予約に必要な情報が不足しています。');
        }

        $price = $house->price;
        $amount = $this->reservationService->calculateAmount($checkinDate, $checkoutDate, $price);

        $reservationRegisterForm = [
            'house_id' => $house->id,
            'user_id' => $user->id,
            'checkin_date' => $checkinDate,
            'checkout_date' => $checkoutDate,
            'number_of_people' => $numberOfPeople,
            'amount' => $amount,
        ];

        return view('reservations.confirm', [
            'house' => $house,
            'reservationRegisterForm' => $reservationRegisterForm,
        ]);
    }

    public function pay($id, Request $request)
    {
        $house = House::findOrFail($id);
        $user = Auth::user();

        // 必要なデータを受け取る
        $checkinDate = $request->input('checkin_date');
        $checkoutDate = $request->input('checkout_date');
        $numberOfPeople = $request->input('number_of_people');
        $amount = $this->reservationService->calculateAmount($checkinDate, $checkoutDate, $house->price);

        $reservationRegisterForm = [
            'house_id' => $house->id,
            'user_id' => $user->id,
            'checkin_date' => $checkinDate,
            'checkout_date' => $checkoutDate,
            'number_of_people' => $numberOfPeople,
            'amount' => $amount,
        ];

        $sessionId = $this->stripeService->createStripeSession($house->name, $reservationRegisterForm, $request);

        // Stripe決済ページへリダイレクト
        return redirect()->away("https://checkout.stripe.com/pay/{$sessionId}");
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



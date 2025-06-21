<?php

    namespace app\http\Controllers;

    use app\Models\User;
    use app\Models\Loves;
    use app\Models\House;
    use app\Services\ReservationService;
    use app\http\DTO\FaboriteHouseDTO;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Pagination\LengthAwarePaginator;

    class FaboritesController extends Controller{
        protected $lovesRepository;
        protected $houseRepository;
        protected $reservationService;

        public function __construct(LovesRepository $lovesRepository, HouseRepository $houseRepository, ReservationService $reservationService){
            $this->lovesRepository = $lovesRepository;
            $this->houseRepository = $houseRepository;
            $this->reservationService = $reservationService;
        }

        public function index(Request $request){
            $user = Auth::user();
            $page = $request->input('page', 1);
            $perPage = 5;

            // ユーザーのお気に入りを取得
            $fabos = $this->lovesRepository->getFabos($user->id, $page, $perPage);
        
            // DTOの作成
            $faboriteHouseDTOs = [];
            foreach ($fabos as $loves) {
                $house = $this->houseRepository->find($loves->houseid);
                $faboriteHouseDTOs[] = new FaboriteHouseDTO($loves, $house);
            }

            // ページネーションの設定
            $fabosPage = new LengthAwarePaginator($faboriteHouseDTOs, $fabos->total(), $perPage, $page);

            return view('faborites.index', ['fabosPage' => $fabosPage]);
        }
    }

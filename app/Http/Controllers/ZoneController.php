<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ZoneRequest;
use App\Services\ZoneService;
use Illuminate\Http\JsonResponse;

class ZoneController extends Controller
{
    protected $zoneService;

    public function __construct(ZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
    }

    /**
     * Store a new zone registration.
     *
     * @param ZoneRequest $request
     * @return JsonResponse
     */
    public function store(ZoneRequest $request): JsonResponse
    {
        try {
            $registration = $this->zoneService->registerZone($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل منطقتك بنجاح! سنتواصل معك فور توفر التوصيل.',
                'data' => $registration
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التسجيل، يرجى المحاولة لاحقاً.'
            ], 500);
        }
    }
}

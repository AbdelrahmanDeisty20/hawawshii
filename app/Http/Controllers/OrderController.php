<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Store a newly created order.
     *
     * @param OrderRequest $request
     * @return JsonResponse
     */
    public function store(OrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());
            $this->orderService->notifyAdmin($order);

            return response()->json([
                'success' => true,
                'message' => 'تم استلام طلبك بنجاح! جاري تحويلك لواتساب...',
                'data' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة الطلب، يرجى المحاولة لاحقاً.'
            ], 500);
        }
    }
}

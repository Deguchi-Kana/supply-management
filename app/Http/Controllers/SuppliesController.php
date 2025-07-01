<?php

namespace App\Http\Controllers;

use App\Services\SupplyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuppliesController extends Controller
{
    protected SupplyService $supplyService;

    public function __construct(SupplyService $supplyService)
    {
        $this->supplyService = $supplyService;
    }

    public function index(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword', '');
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 20);
        $result = $this->supplyService->getSupplyByKeyword($keyword, $page, $perPage);
        return response()->json([
            'data' => $result['data'],
            'meta' => $result['meta'],
            'links' => $result['links'],
        ]);
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->supplyService->getSupplyById($id));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateSupply($request);

        $supply = $this->supplyService->createSupply($validated, $request);

        if ($request->has('status')) {
            $this->supplyService->storeBorrowData($request, $supply);
        }

        return response()->json(['message' => 'Supply created successfully'], 201);
    }
    /**
     * バリデーション
     */
    private function validateSupply(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'is_consumable' => 'required|boolean',
            'expiration_date' => 'nullable|date',
//            'categories' => 'required|exists:categories,id',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    /**
     * 備品データの更新
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $this->validateSupply($request);

        $this->supplyService->updateSupply($id, $validated, $request);

        return response()->json(['message' => 'Supply updated successfully'], 200);
    }

    /**
     * 備品削除
     */
    public function destroy($id)
    {
        $this->supplyService->destroySupply($id);

        return response()->json(['message' => '削除しました']);
    }
}

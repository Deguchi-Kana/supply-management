<?php

namespace App\Services;

use App\Models\Supply;
use App\Repositories\SupplyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyService
{
    protected SupplyRepository $supplyRepository;

    public function __construct(SupplyRepository $supplyRepository)
    {
        $this->supplyRepository = $supplyRepository;
    }

    public function getSupplyById($id): array
    {
        $supply = $this->supplyRepository->findById($id);

        return [
            'id' => $supply->id,
            'name' => $supply->name,
            'category_id' => $supply->categories->pluck('id')->toArray(),
            'category_name' => $supply->categories->pluck('name')->toArray(),
            'image_path' => $supply->images->first()?->file_path ?? null,
            'status' => $supply->bollows->first()?->status,
            'return_date' => Carbon::parse($supply->bollows->first()?->return_date)->format('Y/m/d'),
            'expiration_date' => $supply->expiration_date ? Carbon::parse($supply->expiration_date)->format('Y-m-d') : null,
            'stock' => $supply->stock,
            'is_consumable' => $supply->is_consumable,
        ];
    }

    public function getSupplyByKeyword($keyword = '', $page = 1, $perPage = 20)
    {
        if (empty($keyword)) {
            $paginator = $this->supplyRepository->paginateAll($perPage, $page);
        } else {
            $paginator = $this->supplyRepository->paginateByKeyword($keyword, $perPage, $page);
        }
        $mappedData = $paginator->getCollection()->map(function($supply) {
            return [
                'id' => $supply->id,
                'name' => $supply->name,
                'categories' => $supply->categories->pluck('name')->toArray(),
                'image_path' => $supply->images->first()?->file_path ?? null,
            ];
        });
        $paginator->setCollection($mappedData);
        return [
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ];
    }

    public function createSupply(array $validated, Request $request): Supply
    {
        $supply = $this->supplyRepository->create($validated);

        if ($request->hasFile('image')) {
            $this->supplyRepository->storeImage($request->file('image'), $supply);
        }

        if ($request->has('categories')) {
            $this->supplyRepository->syncCategories($supply, $request->input('categories'));
        }

        return $supply;
    }

    public function updateSupply(int $id, array $validated, Request $request): void
    {
        $supply = $this->supplyRepository->update($id, $validated);

        if ($request->has('categories')) {
            $this->supplyRepository->syncCategories($supply, $request->input('categories'));
        }

        if ($request->hasFile('image')) {
            $this->supplyRepository->deleteExistingImage($supply);
            $this->supplyRepository->storeImage($request->file('image'), $supply);
        }
    }
    public function destroySupply(int $id): void
    {
        $this->supplyRepository->delete($id);
    }
    public function storeBorrowData(Request $request, Supply $supply): void
    {
        $returnOptions = [
            Carbon::now()->copy()->addWeek(),
            Carbon::now()->copy()->addWeeks(2),
            Carbon::now()->copy()->addWeeks(3),
            Carbon::now()->copy()->addWeeks(4),
        ];

        $returnDate = $returnOptions[array_rand($returnOptions)];

        DB::table('bollow_logs')->insert([
            'supply_id' => $supply->id,
            'user_id' => 1,
            'borrow_date' => Carbon::now(),
            'return_date' => $returnDate,
            'status' => $request->input('status'),
        ]);
    }
}

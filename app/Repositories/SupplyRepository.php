<?php

namespace App\Repositories;

use App\Models\Supply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SupplyRepository
{
    public function paginateAll(int $perPage, int $page)
    {
        return Supply::with(['images', 'categories'])
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function paginateByKeyword(string $keyword, int $perPage, int $page)
    {
        return Supply::with(['images', 'categories'])
            ->where('name', 'like', "%$keyword%")
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function findById($id): Supply
    {
        return Supply::with(['categories', 'images', 'bollows'])->findOrFail($id);
    }

    public function create(array $data): Supply
    {
        return Supply::create($data);
    }

    public function update(int $id, array $validated): Supply
    {
        $supply = Supply::findOrFail($id);

        $supply->update([
            'name' => $validated['name'],
            'stock' => $validated['stock'],
//            'categories' => $validated['categories'],
            'is_consumable' => $validated['is_consumable'],
            'expiration_date' => $validated['expiration_date'] ?? null,
        ]);

        return $supply;
    }

    public function delete(int $id): void
    {
        $supply = $this->findById($id);

        // bollow_logsを削除
        DB::table('bollow_logs')->where('supply_id', $id)->delete();

        // 画像削除
        $this->deleteExistingImage($supply);

        // カテゴリーの紐づけ削除（detach）
        $supply->categories()->detach();

        // supply本体削除
        $supply->delete();
    }


    public function deleteExistingImage(Supply $supply): void
    {
        if ($supply->images->isNotEmpty()) {
            foreach ($supply->images as $image) {
                if (Storage::disk('public')->exists($image->file_path)) {
                    Storage::disk('public')->delete($image->file_path);
                }
                $image->delete();
            }
        }
    }

    public function storeImage($image, Supply $supply): void
    {
        $imagePath = $image->store('images', 'public');

        $supply->images()->create([
            'file_path' => $imagePath,
        ]);
    }

    public function syncCategories(Supply $supply, $categories): void
    {
        $categoriesArray = is_array($categories) ? $categories : [$categories];
        $supply->categories()->sync($categoriesArray);
    }
}

<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function paginateAll(int $perPage, int $page)
    {
        return User::paginate($perPage, ['*'], 'page', $page);
    }

    public function paginateByKeyword(string $keyword, int $perPage, int $page)
    {
        return User::where('name', 'like', "%$keyword%")
            ->orWhere('ruby', 'like', "%$keyword%")
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function findById($id): User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $validated): User
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $validated['name'],
            'ruby' => $validated['ruby'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return $user;
    }

    public function delete(int $id): void
    {
        $user = $this->findById($id);

        // bollow_logsを削除
        DB::table('bollow_logs')->where('user_id', $id)->delete();
        // user本体削除
        $user->delete();
    }
}

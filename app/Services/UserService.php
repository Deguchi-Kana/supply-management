<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById($id): array
    {
        $user = $this->userRepository->findById($id);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'ruby' => $user->ruby,
            'email' => $user->email,
            'password' => $user->password,
         'expiration_date' => $user->expiration_date ? Carbon::parse($user->expiration_date)->format('Y-m-d') : null,
        ];
    }
    public function getUserByKeyword($keyword = '', $page = 1, $perPage = 20)
    {
        if (empty($keyword)) {
            $paginator = $this->userRepository->paginateAll($perPage, $page);
        } else {
            $paginator = $this->userRepository->paginateByKeyword($keyword, $perPage, $page);
        }
        $mappedData = $paginator->getCollection()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'ruby' => $user->ruby,
                'email' => $user->email,
                'role' => $user->role
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

    public function createUser(array $validated, Request $request): User
    {
        $user = $this->userRepository->create($validated);
        return $user;
    }

    public function updateUser(int $id, array $validated, Request $request): void
    {
        $this->userRepository->update($id, $validated);
    }
    public function destroyUser(int $id): void
    {
        $this->userRepository->delete($id);
    }
}

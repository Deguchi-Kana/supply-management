<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword', '');
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 20);
        $result = $this->userService->getUserByKeyword($keyword, $page, $perPage);
        return response()->json([
            'data' => $result['data'],
            'meta' => $result['meta'],
            'links' => $result['links'],
        ]);
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->userService->getUserById($id));
    }
    public function store(Request $request): JsonResponse
    {
        $this->userService->createUser($this->validateUser($request), $request);
        return response()->json(['message' => 'User created successfully'], 201);
    }
    /**
     * バリデーション
     */
    private function validateUser(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'ruby' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
    }
    /**
     * ユーザーデータの更新
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->userService->updateUser($id, $this->validateUser($request), $request);
        return response()->json(['message' => 'User updated successfully'], 200);
    }
    /**
     * ユーザー削除
     */
    public function destroy($id)
    {
        $this->userService->destroyUser($id);

        return response()->json(['message' => '削除しました']);
    }
}

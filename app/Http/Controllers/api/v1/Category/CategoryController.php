<?php

namespace App\Http\Controllers\api\v1\Category;

use App\Contracts\Category\ICategoryService;
use App\DTO\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\DeleteCategoryRequest;
use App\Http\Requests\Category\GetCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use Dedoc\Scramble\Attributes\Endpoint;

class CategoryController extends Controller
{
    private const POLICY = 'categoryPolicy';
    protected ICategoryService $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    #[Endpoint('Create Category')]
    public function createCategory(CreateCategoryRequest $createCategoryRequest)
    {
        $this->authorize('create', self::POLICY);

        $modelResponseDTO = $this->categoryService->create($createCategoryRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, CategoryResource::class);
    }

    #[Endpoint('Get Category')]
    public function getCategory(GetCategoryRequest $getCategoryRequest)
    {
        $this->authorize('get', self::POLICY);

        $modelResponseDTO = $this->categoryService->get($getCategoryRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, CategoryResource::class);
    }

    #[Endpoint('Update Category')]
    public function updateCategory(UpdateCategoryRequest $updateCategoryRequest)
    {
        $this->authorize('update', self::POLICY);

        $request_data = $updateCategoryRequest->validated();
        $modelResponseDTO = $this->categoryService->update($request_data['id'], $request_data);

        return $this->respondWithModelDTO($modelResponseDTO, CategoryResource::class);
    }

    #[Endpoint('Delete Category')]
    public function deleteCategory(DeleteCategoryRequest $deleteCategoryRequest)
    {
        $this->authorize('delete', self::POLICY);

        $request_data = $deleteCategoryRequest->validated();
        $modelResponseDTO = $this->categoryService->delete($request_data['id']);

        return $this->respondWithModelDTO($modelResponseDTO, CategoryResource::class);
    }
}

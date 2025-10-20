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

        $categoryDTO = $this->categoryService->create($createCategoryRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            $is_created = (bool)$data = $categoryDTO->getData(),
            $categoryDTO->getMessage(),
            $this->toResource(CategoryResource::class, $data),
            $is_created ? 201 : 500
        ));
    }

    #[Endpoint('Get Category')]
    public function getCategory(GetCategoryRequest $getCategoryRequest)
    {
        $this->authorize('get', self::POLICY);

        $categoryDTO = $this->categoryService->get($getCategoryRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$data = $categoryDTO->getData(),
            $categoryDTO->getMessage(),
            $this->toResource(CategoryResource::class, $data),
            $data ? 200 : 404
        ));
    }

    #[Endpoint('Update Category')]
    public function updateCategory(UpdateCategoryRequest $updateCategoryRequest)
    {
        $this->authorize('update', self::POLICY);

        $request_data = $updateCategoryRequest->validated();
        $categoryDTO = $this->categoryService->update($request_data['id'], $request_data);

        return $this->getHttpResponse(new ResponseDTO(
            $is_created = (bool)$data = $categoryDTO->getData(),
            $categoryDTO->getMessage(),
            $this->toResource(CategoryResource::class, $data),
            $is_created ? 200 : 500
        ));
    }

    #[Endpoint('Delete Category')]
    public function deleteCategory(DeleteCategoryRequest $deleteCategoryRequest)
    {
        $this->authorize('delete', self::POLICY);

        $request_data = $deleteCategoryRequest->validated();
        $categoryDTO = $this->categoryService->delete($request_data['id']);

        return $this->getHttpResponse(new ResponseDTO(
            $is_deleted = (bool)$data = $categoryDTO->getData(),
            $categoryDTO->getMessage(),
            $this->toResource(CategoryResource::class, $data),
            $is_deleted ? 200 : 500
        ));
    }
}

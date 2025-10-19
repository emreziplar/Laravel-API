<?php

namespace App\Http\Controllers\api\v1\Category;

use App\Contracts\Category\ICategoryService;
use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\GetCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private const POLICY = 'categoryPolicy';
    protected ICategoryService $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

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

    public function updateCategory(UpdateCategoryRequest $updateCategoryRequest)
    {
        $this->authorize('update', self::POLICY);

    }
}

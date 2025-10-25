<?php

namespace App\Services\Category;

use App\Contracts\Category\ICategoryBusinessValidator;
use App\Contracts\Category\ICategoryDataValidator;
use App\Contracts\Category\ICategoryService;
use App\DTO\Request\Category\CreateCategoryDTO;
use App\DTO\Request\Category\UpdateCategoryDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Category\ICategoryRepository;

class CategoryService implements ICategoryService
{
    protected ICategoryRepository $categoryRepository;
    protected ICategoryDataValidator $dataValidator;
    protected ICategoryBusinessValidator $businessValidator;

    public function __construct(ICategoryRepository $categoryRepository, ICategoryDataValidator $dataValidator, ICategoryBusinessValidator $businessValidator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->dataValidator = $dataValidator;
        $this->businessValidator = $businessValidator;
    }

    public function create(array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateCreateData($data);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $businessValidation = $this->businessValidator->validateForCreate($data, $user);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        $createCategoryDTO = new CreateCategoryDTO(
            parentId: $dataValidation->get('parent_id'),
            status: $dataValidation->get('status'),
            translations: $dataValidation->get('translations')
        );

        $category = $this->categoryRepository->createWithTranslations($createCategoryDTO);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_created'), 500);

        return new ModelResponseDTO($category, __t('category.created'), 201);
    }

    public function get(array $fields): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateGetData($fields);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $categories = $this->categoryRepository->getWithConditions($dataValidation->getData());

        if ($categories->isEmpty())
            return new ModelResponseDTO(null, __t('category.not_found'), 404);

        return new ModelResponseDTO($categories, __t('category.found'));
    }

    public function update(int $id, array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateUpdateData($id, $data);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $businessValidation = $this->businessValidator->validateForUpdate($id, $data, $user);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        $updateCategoryDTO = new UpdateCategoryDTO(
            category: $businessValidation->get('category'),
            parentId: $businessValidation->get('parent')->getId(),
            status: $dataValidation->get('status'),
            translations: $dataValidation->get('translations')
        );

        $category = $this->categoryRepository->updateWithTranslations($updateCategoryDTO);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_updated'), 500);

        return new ModelResponseDTO($category, __t('category.updated'));
    }

    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateDeleteData($id);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $businessValidation = $this->businessValidator->validateForDelete($id, $user);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        $isCategoryDeleted = $this->categoryRepository->delete($businessValidation->get('category'));

        return new ModelResponseDTO(
            null,
            $isCategoryDeleted ? __t('category.deleted') : __t('category.not_deleted'),
            $isCategoryDeleted ? 200 : 500
        );
    }
}

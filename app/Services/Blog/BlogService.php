<?php

namespace App\Services\Blog;

use App\Contracts\Blog\IBlogBusinessValidator;
use App\Contracts\Blog\IBlogDataValidator;
use App\Contracts\Blog\IBlogService;
use App\DTO\Request\Blog\CreateBlogDTO;
use App\DTO\Request\Blog\UpdateBlogDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Blog\IBlogRepository;
use Illuminate\Support\Facades\Auth;

class BlogService implements IBlogService
{
    protected IBlogRepository $blogRepository;
    protected IBlogDataValidator $dataValidator;
    protected IBlogBusinessValidator $businessValidator;

    public function __construct(IBlogRepository $blogRepository, IBlogDataValidator $dataValidator, IBlogBusinessValidator $businessValidator)
    {
        $this->blogRepository = $blogRepository;
        $this->dataValidator = $dataValidator;
        $this->businessValidator = $businessValidator;
    }

    /**
     * @param array $data
     * @param IUserModel|null $user
     * @return ModelResponseDTO
     * @throws \Exception
     */
    public function create(array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateCreateData($data);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $user ??= Auth::user();

        $businessValidation = $this->businessValidator->validateForCreate($data, $user);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        $createBlogDTO = new CreateBlogDTO(
            categoryId: $businessValidation->get('category')->getId(),
            status: $dataValidation->get('status') ?? null,
            user: $businessValidation->get('user'),
            translations: $dataValidation->get('translations')
        );

        $blog = $this->blogRepository->createWithTranslations($createBlogDTO);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_created'), 500);

        return new ModelResponseDTO($blog, __t('blog.created'));
    }

    /**
     * @param array $fields
     * @return ModelResponseDTO
     * @throws \Exception
     */
    public function get(array $fields): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateGetData($fields);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $blog = $this->blogRepository->getWithConditions($dataValidation->getData());
        if ($blog->isEmpty())
            return new ModelResponseDTO(null, __t('blog.not_found'), 404);

        return new ModelResponseDTO($blog, __t('blog.found'));
    }

    /**
     * @param int $id
     * @param array $data
     * @param IUserModel|null $user
     * @return ModelResponseDTO
     * @throws \Exception
     */
    public function update(int $id, array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateUpdateData($id, $data);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();
        $user ??= Auth::user();

        $businessValidation = $this->businessValidator->validateForUpdate($id, $data, $user);
        if(!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        $updateBlogDTO = new UpdateBlogDTO(
            blog: $businessValidation->get('blog'),
            categoryId: $businessValidation->get('category')->getId(),
            status: $dataValidation->get('status'),
            user: $businessValidation->get('user'),
            translations: $dataValidation->get('translations')
        );
        $blog = $this->blogRepository->updateWithTranslations($updateBlogDTO);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_updated'), 500);

        return new ModelResponseDTO($blog, __t('blog.updated'));
    }

    /**
     * @param int $id
     * @param IUserModel|null $user
     * @return ModelResponseDTO
     * @throws \Exception
     */
    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO
    {
        $dataValidation = $this->dataValidator->validateDeleteData($id);
        if (!$dataValidation->isValid())
            return $dataValidation->toModelResponse();

        $businessValidation = $this->businessValidator->validateForDelete($id, $user);
        if (!$businessValidation->isValid())
            return $businessValidation->toModelResponse();

        $deleted = $this->blogRepository->delete($businessValidation->getData());

        return new ModelResponseDTO(
            null,
            $deleted ? __t('blog.deleted') : __t('blog.not_deleted'),
            $deleted ? 200 : 500
        );
    }
}

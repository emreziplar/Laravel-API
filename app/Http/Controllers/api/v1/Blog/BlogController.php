<?php

namespace App\Http\Controllers\api\v1\Blog;

use App\Contracts\Blog\IBlogService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Requests\Blog\DeleteBlogRequest;
use App\Http\Requests\Blog\GetBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\Blog\BlogResource;
use Dedoc\Scramble\Attributes\Endpoint;

class BlogController extends Controller
{
    protected const POLICY = 'blogPolicy';
    protected IBlogService $blogService;

    public function __construct(IBlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    #[Endpoint('Create Blog')]
    public function createBlog(CreateBlogRequest $createBlogRequest)
    {
        $this->authorize('create', self::POLICY);

        $modelResponseDTO = $this->blogService->create($createBlogRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, BlogResource::class);
    }

    #[Endpoint('Get Blog')]
    public function getBlog(GetBlogRequest $getCategoryRequest)
    {
        $this->authorize('get', self::POLICY);

        $modelResponseDTO = $this->blogService->get($getCategoryRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, BlogResource::class);
    }

    #[Endpoint('Update Blog')]
    public function updateBlog(UpdateBlogRequest $updateBlogRequest)
    {
        $this->authorize('update', self::POLICY);

        $req_data = $updateBlogRequest->validated();
        $modelResponseDTO = $this->blogService->update($req_data['id'], $updateBlogRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, BlogResource::class);
    }

    #[Endpoint('Delete Blog')]
    public function deleteBlog(DeleteBlogRequest $deleteCategoryRequest)
    {
        $this->authorize('delete', self::POLICY);

        $request_data = $deleteCategoryRequest->validated();
        $modelResponseDTO = $this->blogService->delete($request_data['id']);

        return $this->respondWithModelDTO($modelResponseDTO, BlogResource::class);
    }
}

<?php

namespace App\Http\Controllers\api\v1\Blog;

use App\Contracts\Blog\IBlogService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
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
}

<?php

namespace App\Http\Controllers\api\v1\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\CreateBlogRequest;
use Dedoc\Scramble\Attributes\Endpoint;

class BlogController extends Controller
{
    protected const POLICY = 'blogPolicy';



    #[Endpoint('Create Blog')]
    public function createBlog(CreateBlogRequest $createBlogRequest)
    {
        $this->authorize('create',self::POLICY);

    }
}

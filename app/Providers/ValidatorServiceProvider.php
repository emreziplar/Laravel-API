<?php

namespace App\Providers;

use App\Contracts\Blog\IBlogBusinessValidator;
use App\Contracts\Blog\IBlogDataValidator;
use App\Contracts\Category\ICategoryBusinessValidator;
use App\Contracts\Category\ICategoryDataValidator;
use App\Contracts\Media\IMediaBusinessValidator;
use App\Contracts\Media\IMediaDataValidator;
use App\Services\Blog\Validators\BlogBusinessValidator;
use App\Services\Blog\Validators\BlogDataValidator;
use App\Services\Category\Validators\CategoryBusinessValidator;
use App\Services\Category\Validators\CategoryDataValidator;
use App\Services\Media\Validators\MediaBusinessValidator;
use App\Services\Media\Validators\MediaDataValidator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $dataValidators = [
            IBlogDataValidator::class => BlogDataValidator::class,
            ICategoryDataValidator::class => CategoryDataValidator::class,
            IMediaDataValidator::class => MediaDataValidator::class,
        ];

        $businessValidators = [
            IBlogBusinessValidator::class => BlogBusinessValidator::class,
            ICategoryBusinessValidator::class => CategoryBusinessValidator::class,
            IMediaBusinessValidator::class => MediaBusinessValidator::class,
        ];

        foreach ($dataValidators as $contract => $class)
            $this->app->bind($contract, $class);

        foreach ($businessValidators as $contract => $class)
            $this->app->bind($contract, $class);
    }

    public function boot(): void
    {

    }
}

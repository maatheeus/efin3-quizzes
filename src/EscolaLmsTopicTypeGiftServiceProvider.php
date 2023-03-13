<?php

namespace EscolaLms\TopicTypeGift;

use EscolaLms\Courses\EscolaLmsCourseServiceProvider;
use EscolaLms\TopicTypeGift\Providers\AuthServiceProvider;
use EscolaLms\TopicTypes\EscolaLmsTopicTypesServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * SWAGGER_VERSION
 */
class EscolaLmsTopicTypeGiftServiceProvider extends ServiceProvider
{
    public const SERVICES = [];

    public const REPOSITORIES = [];

    public $singletons = self::SERVICES + self::REPOSITORIES;

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register(): void
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(EscolaLmsTopicTypesServiceProvider::class);
        $this->app->register(EscolaLmsCourseServiceProvider::class);
    }
}

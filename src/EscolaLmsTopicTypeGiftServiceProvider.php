<?php

namespace EscolaLms\TopicTypeGift;

use EscolaLms\Courses\EscolaLmsCourseServiceProvider;
use EscolaLms\Courses\Facades\Topic;
use EscolaLms\TopicTypeGift\Http\Resources\TopicType\Admin\GiftQuizResource as AdminGiftQuizResource;
use EscolaLms\TopicTypeGift\Http\Resources\TopicType\Client\GiftQuizResource as ClientGiftQuizResource;
use EscolaLms\TopicTypeGift\Http\Resources\TopicType\Export\GiftQuizResource as ExportGiftQuizResource;
use EscolaLms\TopicTypeGift\Models\GiftQuiz;
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

        Topic::registerContentClass(GiftQuiz::class);
        Topic::registerResourceClasses(GiftQuiz::class, [
            'client' => ClientGiftQuizResource::class,
            'admin' => AdminGiftQuizResource::class,
            'export' => ExportGiftQuizResource::class,
        ]);
    }

    public function register(): void
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(EscolaLmsTopicTypesServiceProvider::class);
        $this->app->register(EscolaLmsCourseServiceProvider::class);
    }
}

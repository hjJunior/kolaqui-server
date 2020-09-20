<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateQuestonsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Artisan::call('elastic:create-index', [
            'index-configurator' => 'App\ElasticSearchIndex\QuestionsIndexConfigurator'
        ]);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Artisan::call('elastic:drop-index', [
            'index-configurator' => 'App\ElasticSearchIndex\QuestionsIndexConfigurator'
        ]);
    }
}

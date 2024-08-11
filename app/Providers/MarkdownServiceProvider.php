<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Bind MarkdownConverter to the container
        $this->app->singleton(MarkdownConverter::class, function ($app) {
            // Create an environment instance with necessary extensions
            $environment = new Environment([]);
            $environment->addExtension(new CommonMarkCoreExtension());

            // Return a new MarkdownConverter instance
            return new MarkdownConverter($environment);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

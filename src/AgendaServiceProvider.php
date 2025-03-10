<?php

namespace Darvis\ModuleAgenda;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Darvis\ModuleAgenda\Livewire\AgendaList;
use Darvis\ModuleAgenda\Livewire\AgendaCreate;
use Darvis\ModuleAgenda\Livewire\AgendaUpdate;
use Darvis\ModuleAgenda\Livewire\AgendaRead;
use Darvis\ModuleAgenda\Livewire\AgendaUpload;
use Darvis\ModuleAgenda\Livewire\AgendaMaps;
use Darvis\ModuleAgenda\Livewire\AgendaListRow;

class AgendaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registreer de configuratie
        $this->mergeConfigFrom(
            __DIR__ . '/config/module_agenda.php', 'module_agenda'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registreer Livewire componenten
        $this->registerLivewireComponents();

        // Publiceer de configuratie
        $this->publishes([
            __DIR__ . '/config/module_agenda.php' => config_path('module_agenda.php'),
        ], 'module-agenda-config');

        // Laad de routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Laad de views
        if (is_dir(__DIR__ . '/resources/views')) {
            $this->loadViewsFrom(__DIR__ . '/resources/views', 'module-agenda');
            
            // Publiceer de views
            $this->publishes([
                __DIR__ . '/resources/views' => resource_path('views/vendor/module-agenda'),
            ], 'module-agenda-views');
        }

        // Laad de migraties
        if (is_dir(__DIR__ . '/database/migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
            
            // Publiceer de migraties
            $this->publishes([
                __DIR__ . '/database/migrations' => database_path('migrations'),
            ], 'module-agenda-migrations');
        }

        // Publiceer assets
        if (is_dir(__DIR__ . '/resources/assets')) {
            $this->publishes([
                __DIR__ . '/resources/assets' => public_path('vendor/module-agenda'),
            ], 'module-agenda-assets');
        }

        // Laad de vertalingen
        if (is_dir(__DIR__ . '/resources/lang')) {
            $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'module-agenda');
            
            // Publiceer de vertalingen
            $this->publishes([
                __DIR__ . '/resources/lang' => resource_path('lang/vendor/module-agenda'),
            ], 'module-agenda-translations');
        }
    }

    /**
     * Registreer Livewire componenten
     */
    private function registerLivewireComponents(): void
    {
        // In Livewire v3 worden componenten automatisch ontdekt op basis van namespace
        // We hoeven ze niet handmatig te registreren, maar we kunnen wel aliassen definiëren indien nodig
        
        // Definieer aliassen voor onze componenten
        Livewire::component('agenda-list', AgendaList::class);
        Livewire::component('agenda-create', AgendaCreate::class);
        Livewire::component('agenda-update', AgendaUpdate::class);
        Livewire::component('agenda-read', AgendaRead::class);
        Livewire::component('agenda-upload', AgendaUpload::class);
        Livewire::component('agenda-maps', AgendaMaps::class);
        Livewire::component('agenda-list-row', AgendaListRow::class);
    }
}

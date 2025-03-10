<?php


use Illuminate\Support\Facades\Route;


// Route::middleware('auth:staff')->prefix('laravel-filemanager')->as('lfm.')->group(function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });
// php artisan vb:ai:translate

Route::group(['prefix' => 'cms', 'middleware' => ['auth:staff', 'web']], function () {

    $modules = collect(cms_config('manta')['modules']);

    $agendaModule = $modules->firstWhere("name", 'agenda');
    $name = isset($agendaModule['routename']) ? $agendaModule['routename'] : 'agenda';

    Route::get("/{$name}", Darvis\ModuleAgenda\Livewire\AgendaList::class)->name('agenda.list');
    Route::get("/{$name}/toevoegen", Darvis\ModuleAgenda\Livewire\AgendaCreate::class)->name('agenda.create');
    Route::get("/{$name}/aanpassen/{agenda}", Darvis\ModuleAgenda\Livewire\AgendaUpdate::class)->name('agenda.update');
    Route::get("/{$name}/lezen/{agenda}", Darvis\ModuleAgenda\Livewire\AgendaRead::class)->name('agenda.read');
    Route::get("/{$name}/bestanden/{agenda}", Darvis\ModuleAgenda\Livewire\AgendaUpload::class)->name('agenda.upload');
    Route::get("/{$name}/maps/{agenda}", Darvis\ModuleAgenda\Livewire\AgendaMaps::class)->name('agenda.maps');
});

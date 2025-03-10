# Module Agenda voor Laravel

Een uitbreiding voor het Manta CMS pakket waarmee je agenda-items kunt beheren in je Laravel applicatie. Deze module maakt deel uit van het Darvis Manta CMS ecosysteem.

## Vereisten

- PHP 8.3 of hoger
- Laravel 11 of hoger
- Manta CMS pakket
- Laravel Jetstream
- Livewire 3.0
- FluxUI (indien beschikbaar in composer.json)

## Installatie

Je kunt deze package installeren via Composer:

```bash
composer require darvis/module-agenda
```

De ServiceProvider wordt automatisch geregistreerd via Laravel's package auto-discovery.

## Configuratie

Na installatie kun je de configuratiebestanden publiceren met het volgende commando:

```bash
php artisan vendor:publish --tag=module-agenda-config
```

## Views aanpassen

Als je de views wilt aanpassen, kun je deze publiceren met:

```bash
php artisan vendor:publish --tag=module-agenda-views
```

## Assets publiceren

Om de assets (CSS, JavaScript, afbeeldingen) te publiceren:

```bash
php artisan vendor:publish --tag=module-agenda-assets
```

## Gebruik

De module voegt routes toe onder `/cms/agenda` voor het beheren van agenda-items.

### Beschikbare routes

- `/cms/agenda` - Overzicht van alle agenda-items
- `/cms/agenda/toevoegen` - Nieuw agenda-item toevoegen
- `/cms/agenda/aanpassen/{agenda}` - Agenda-item bewerken
- `/cms/agenda/lezen/{agenda}` - Agenda-item bekijken
- `/cms/agenda/bestanden/{agenda}` - Bestanden uploaden voor een agenda-item
- `/cms/agenda/maps/{agenda}` - Kaartweergave voor een agenda-item

### Livewire Componenten

De volgende Livewire componenten zijn beschikbaar:

- `agenda-list` - Lijst van agenda-items
- `agenda-create` - Formulier voor het aanmaken van agenda-items
- `agenda-update` - Formulier voor het bijwerken van agenda-items
- `agenda-read` - Weergave van een agenda-item
- `agenda-upload` - Bestandsupload voor agenda-items
- `agenda-maps` - Kaartweergave voor agenda-items

### Functionaliteiten

De module biedt de volgende functionaliteiten:

- Beheer van agenda-items (toevoegen, wijzigen, verwijderen)
- Ondersteuning voor meertaligheid
- Bestandsuploads voor agenda-items
- Locatie-integratie met kaartweergave
- Datumbereik voor agenda-items (van/tot)
- Zichtbaarheidsbereik voor agenda-items (tonen van/tot)
- Contactgegevens voor agenda-items
- Prijsinformatie voor agenda-items
- Organisatorinformatie voor agenda-items
- Integratie met het Manta CMS voor een consistente gebruikerservaring

## Integratie met Flux UI

Deze module maakt gebruik van [Flux UI](https://fluxui.dev) voor de interface-elementen en is volledig geïntegreerd met het Manta CMS pakket. De componenten zijn ontworpen om naadloos samen te werken met de Flux UI bibliotheek.

## Aanpassen van de module

De module is ontworpen om eenvoudig uitbreidbaar te zijn. Je kunt:

- De configuratie aanpassen om velden toe te voegen of te verwijderen
- De views aanpassen voor een aangepaste weergave
- De controllers uitbreiden met extra functionaliteit
- Eigen Livewire componenten toevoegen die integreren met de module

## Licentie

Deze module is eigendom van Darvis en mag alleen worden gebruikt met toestemming van Darvis.

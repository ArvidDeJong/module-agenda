<?php

namespace Darvis\ModuleAgenda\Livewire;

use Darvis\ModuleAgenda\Models\Agenda;
use Darvis\Manta\Services\Openai;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Locked;
use Illuminate\Support\Str;

trait AgendaTrait
{

    public function __construct()
    {
        $this->route_name = 'agenda';
        $this->route_list = route($this->route_name . '.list');
        $this->config = module_config('Agenda');
        $this->fields = $this->config['fields'];
        $this->moduleClass = 'Manta\Models\Agenda';
    }

    public ?Agenda $item = null;
    public ?Agenda $itemOrg = null;





    public ?string $company_id = '1';
    public ?string $locale = null;
    public ?string $pid = null;
    public ?string $from = null;
    public ?string $till = null;
    public ?string $show_from = null;
    public ?string $show_till = null;
    public ?string $title = null;
    public ?string $title_2 = null;

    public ?string $seo_title = null;
    public ?string $seo_description = null;
    public ?string $tags = null;
    public ?string $summary = null;
    public ?string $excerpt = null;
    public ?string $content = null;
    public ?string $contact = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $zipcode = null;
    public ?string $city = null;
    public ?string $country = 'nl';
    public ?int $price = 0;
    public ?string $currency = 'EUR';
    public ?string $organizer_name = null;
    public ?string $organizer_url = null;
    public ?string $longitude = null;
    public ?string $latitude = null;

    protected function applySearch($query)
    {
        return $this->search === ''
            ? $query
            : $query->where(function (Builder $querysub) {
                $querysub->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('content', 'LIKE', "%{$this->search}%");
            });
    }

    public function rules()
    {
        $return = [];



        // Gebruik isset() om te controleren of de velden daadwerkelijk bestaan voordat je er toegang toe probeert te krijgen
        if (isset($this->fields['from']) && $this->fields['from']['active'] == true) {
            $return['from'] = $this->fields['from']['required'] == true ? 'required' : 'nullable';
        }

        if (isset($this->fields['till']) && $this->fields['till']['active'] == true) {
            $return['till'] = $this->fields['till']['required'] == true ? 'required|after:from' : 'nullable|after:from';
        }

        if (isset($this->fields['show_from']) && $this->fields['show_from']['active'] == true) {
            $return['show_from'] = $this->fields['show_from']['required'] == true ? 'required' : 'nullable';
        }

        if (isset($this->fields['show_till']) && $this->fields['show_till']['active'] == true) {
            $return['show_till'] = $this->fields['show_till']['required'] == true ? 'required|after:show_from' : 'nullable|after:show_from';
        }

        if (isset($this->fields['title']) && $this->fields['title']['active'] == true) {
            $return['title'] = $this->fields['title']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['title_2']) && $this->fields['title_2']['active'] == true) {
            $return['title_2'] = $this->fields['title_2']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['slug']) && $this->fields['slug']['active'] == true) {
            if ($this->item) {
                $return['slug'] = $this->fields['slug']['required'] == true ? 'required|string|max:255|unique:agendas,slug,' . $this->item->id : 'nullable|string|max:255|unique:agendas,slug';
            } else {
                $return['slug'] = $this->fields['slug']['required'] == true ? 'required|string|max:255|unique:agendas,slug' : 'nullable|string|max:255|unique:agendas,slug';
            }
        }

        if (isset($this->fields['seo_title']) && $this->fields['seo_title']['active'] == true) {
            $return['seo_title'] = $this->fields['seo_title']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['seo_description']) && $this->fields['seo_description']['active'] == true) {
            $return['seo_description'] = $this->fields['seo_description']['required'] == true ? 'required|string|max:160' : 'nullable|string|max:160';
        }

        if (isset($this->fields['tags']) && $this->fields['tags']['active'] == true) {
            $return['tags'] = $this->fields['tags']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['summary']) && $this->fields['summary']['active'] == true) {
            $return['summary'] = $this->fields['summary']['required'] == true ? 'required|string|max:500' : 'nullable|string|max:500';
        }

        if (isset($this->fields['excerpt']) && $this->fields['excerpt']['active'] == true) {
            $return['excerpt'] = $this->fields['excerpt']['required'] == true ? 'required|string|max:500' : 'nullable|string|max:500';
        }

        if (isset($this->fields['content']) && $this->fields['content']['active'] == true) {
            $return['content'] = $this->fields['content']['required'] == true ? 'required|string' : 'nullable|string';
        }

        if (isset($this->fields['price']) && $this->fields['price']['active'] == true) {
            $return['price'] = $this->fields['price']['required'] == true ? 'required|numeric|min:0' : 'nullable|numeric|min:0';
        }

        if (isset($this->fields['currency']) && $this->fields['currency']['active'] == true) {
            $return['currency'] = $this->fields['currency']['required'] == true ? 'required|string|in:EUR,USD,GBP' : 'nullable|string|in:EUR,USD,GBP';
        }

        if (isset($this->fields['organizer_name']) && $this->fields['organizer_name']['active'] == true) {
            $return['organizer_name'] = $this->fields['organizer_name']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['organizer_url']) && $this->fields['organizer_url']['active'] == true) {
            $return['organizer_url'] = $this->fields['organizer_url']['required'] == true ? 'required|url|max:255' : 'nullable|url|max:255';
        }

        if (isset($this->fields['contact']) && $this->fields['contact']['active'] == true) {
            $return['contact'] = $this->fields['contact']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['email']) && $this->fields['email']['active'] == true) {
            $return['email'] = $this->fields['email']['required'] == true ? 'required|email|max:255' : 'nullable|email|max:255';
        }

        if (isset($this->fields['phone']) && $this->fields['phone']['active'] == true) {
            $return['phone'] = $this->fields['phone']['required'] == true ? 'required|string|max:20' : 'nullable|string|max:20';
        }

        if (isset($this->fields['address']) && $this->fields['address']['active'] == true) {
            $return['address'] = $this->fields['address']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['zipcode']) && $this->fields['zipcode']['active'] == true) {
            $return['zipcode'] = $this->fields['zipcode']['required'] == true ? 'required|string|max:10' : 'nullable|string|max:10';
        }

        if (isset($this->fields['city']) && $this->fields['city']['active'] == true) {
            $return['city'] = $this->fields['city']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['country']) && $this->fields['country']['active'] == true) {
            $return['country'] = $this->fields['country']['required'] == true ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        if (isset($this->fields['longitude']) && $this->fields['longitude']['active'] == true) {
            $return['longitude'] = $this->fields['longitude']['required'] == true ? 'required|numeric|between:-180,180' : 'nullable|numeric|between:-180,180';
        }

        if (isset($this->fields['latitude']) && $this->fields['latitude']['active'] == true) {
            $return['latitude'] = $this->fields['latitude']['required'] == true ? 'required|numeric|between:-90,90' : 'nullable|numeric|between:-90,90';
        }

        return $return;
    }

    public function messages()
    {
        $return = [];

        $return['from.date_format'] = 'Het veld "van" moet een geldige datum en tijd bevatten (Y-m-d H:i).';
        $return['till.date_format'] = 'Het veld "tot" moet een geldige datum en tijd bevatten (Y-m-d H:i).';
        $return['till.after'] = 'De einddatum moet na de begindatum liggen.';
        $return['show_from.date_format'] = 'De zichtbaarheid "van" moet een geldige datum en tijd bevatten (Y-m-d H:i).';
        $return['show_till.date_format'] = 'De zichtbaarheid "tot" moet een geldige datum en tijd bevatten (Y-m-d H:i).';
        $return['show_till.after'] = 'De zichtbaarheid "tot" moet na de zichtbaarheid "van" liggen.';
        $return['title.required'] = 'De titel is verplicht.';
        $return['title.max'] = 'De titel mag niet langer zijn dan 255 tekens.';
        $return['slug.required'] = 'De slug is verplicht.';
        $return['slug.unique'] = 'De slug moet uniek zijn.';
        $return['seo_title.max'] = 'De SEO-titel mag niet langer zijn dan 255 tekens.';
        $return['seo_description.max'] = 'De SEO-beschrijving mag niet langer zijn dan 160 tekens.';
        $return['tags.max'] = 'De tags mogen niet langer zijn dan 255 tekens.';
        $return['summary.max'] = 'De samenvatting mag niet langer zijn dan 500 tekens.';
        $return['excerpt.max'] = 'Het uittreksel mag niet langer zijn dan 500 tekens.';
        $return['email.email'] = 'Voer een geldig e-mailadres in.';
        $return['email.max'] = 'Het e-mailadres mag niet langer zijn dan 255 tekens.';
        $return['phone.max'] = 'Het telefoonnummer mag niet langer zijn dan 20 tekens.';
        $return['address.max'] = 'Het adres mag niet langer zijn dan 255 tekens.';
        $return['zipcode.max'] = 'De postcode mag niet langer zijn dan 10 tekens.';
        $return['city.max'] = 'De stad mag niet langer zijn dan 255 tekens.';
        $return['country.max'] = 'Het land mag niet langer zijn dan 255 tekens.';
        $return['price.numeric'] = 'De prijs moet een geldig getal zijn.';
        $return['price.min'] = 'De prijs moet ten minste 0 zijn.';
        $return['currency.in'] = 'De valuta moet een van de volgende zijn: EUR, USD, GBP.';
        $return['organizer_url.url'] = 'Voer een geldige URL in voor de organisator.';
        $return['longitude.numeric'] = 'De lengtegraad moet een geldig getal zijn tussen -180 en 180.';
        $return['latitude.numeric'] = 'De breedtegraad moet een geldig getal zijn tussen -90 en 90.';

        return $return;
    }
}

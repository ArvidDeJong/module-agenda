<?php

namespace Darvis\ModuleAgenda\Livewire;

use Darvis\ModuleAgenda\Models\Agenda;
use Darvis\Manta\Traits\MantaTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class AgendaCreate extends Component
{
    use MantaTrait;
    use AgendaTrait;

    public function mount(Request $request)
    {
        $this->locale = getLocaleManta();
        if ($request->input('locale') && $request->input('pid')) {
            $agenda = Agenda::find($request->input('pid'));
            $this->pid = $agenda->id;
            $this->locale = $request->input('locale');
            $this->itemOrg = $agenda;
        }

        $this->organizer_name = env('APP_NAME');
        $this->organizer_url = env('APP_URL');
        $this->email = env('DEFAULT_EMAIL');
        $this->phone = env('DEFAULT_PHONE');

        $this->address = env('DEFAULT_ADDRESS');
        $this->zipcode = env('DEFAULT_ZIPCODE');
        $this->city = env('DEFAULT_CITY');
        $this->country = env('DEFAULT_COUNTRY');

        $this->show_from = Carbon::now()->format('Y-m-d H:i');
        $this->show_till = Carbon::now()->addYears(10)->format('Y-m-d H:i');

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('create');

        if (class_exists(Faker::class) && config('app.env') === 'local') {
            $locale = 'nl_NL';  // Zet de locale in een variabele voor herbruikbaarheid
            $faker = Faker::create($locale);
            $dateFormat = 'Y-m-d H:i';  // Het gewenste string formaat voor datums

            // Toegevoegde velden
            $this->from = $faker->dateTimeBetween('-1 year', 'now')->format($dateFormat);  // Datum in string-formaat
            $this->till = $faker->dateTimeBetween('now', '+1 year')->format($dateFormat);  // Datum in de toekomst als string
            $this->show_from = $faker->dateTimeBetween('-1 month', 'now')->format($dateFormat);  // Datum binnen een maand vanaf nu
            $this->show_till = $faker->dateTimeBetween('now', '+1 month')->format($dateFormat);  // Datum binnen een maand na nu
            $this->title = $faker->sentence(4);
            $this->title_2 = $faker->sentence(4);
            $this->slug = Str::slug($this->title);
            $this->seo_title = $this->title;
            $this->seo_description = $faker->text(160);  // SEO beschrijving beperkt tot 160 karakters
            $this->tags = implode(', ', $faker->words(5));  // Tags als string van 5 woorden
            $this->summary = $faker->text(200);  // Samenvatting van 200 karakters
            $this->excerpt = $faker->text(500);  // Uittreksel van 500 karakters
            $this->content = $faker->paragraphs(5, true);  // Meerdere paragrafen
            $this->contact = $faker->name;
            $this->email = $faker->unique()->safeEmail;
            $this->phone = $faker->phoneNumber;
            $this->address = $faker->streetAddress;
            $this->zipcode = $faker->postcode;
            $this->city = $faker->city;
            $this->country = $faker->country;
            $this->price = $faker->randomFloat(2, 5, 500);  // Willekeurige prijs tussen 5 en 500
            $this->currency = 'EUR';  // Statische waarde voor de munteenheid
            $this->organizer_name = $faker->company;
            $this->organizer_url = $faker->url;
            $this->longitude = $faker->longitude;
            $this->latitude = $faker->latitude;
        }
    }

    public function render()
    {
        return view('manta::default.manta-default-create')->title($this->config['module_name']['single'] . ' toevoegen');
    }

    public function save()
    {

        $this->validate();

        $row = $this->only(
            'from',
            'till',
            'show_from',
            'show_till',
            'title',
            'title_2',
            'slug',
            'seo_title',
            'seo_description',
            'tags',
            'summary',
            'excerpt',
            'content',
            'contact',
            'contact_wysiwyg',
            'email',
            'phone',
            'address',
            'zipcode',
            'city',
            'country',
            'price',
            'currency',
            'organizer_name',
            'organizer_url',
        );
        $row['created_by'] = auth('staff')->user()->name;
        $row['host'] = request()->host();
        $row['slug'] = $this->slug ? $this->slug : Str::of($this->title)->slug('-');
        Agenda::create($row);
        // $this->toastr('success', 'Pagina toegevoegd');

        return $this->redirect(AgendaList::class);
    }
}

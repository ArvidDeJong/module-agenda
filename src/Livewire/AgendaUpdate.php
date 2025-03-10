<?php

namespace Darvis\ModuleAgenda\Livewire;

use Flux\Flux;
use Livewire\Component;
use Darvis\ModuleAgenda\Models\Agenda;
use Darvis\Manta\Traits\MantaTrait;
use Illuminate\Http\Request;

class AgendaUpdate extends Component
{
    use MantaTrait;
    use AgendaTrait;

    public function mount(Agenda $agenda)
    {
        $this->item = $agenda;
        $this->itemOrg = translate($agenda, 'nl')['org'];
        $this->id = $agenda->id;
        $this->locale = $agenda->locale;

        $this->fill(
            $agenda->only(
                'company_id',
                'pid',
                'locale',
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
            ),
        );
        $this->getLocaleInfo();
        $this->getBreadcrumb('update');
        $this->getTablist();
    }

    public function render()
    {
        return view('manta::default.manta-default-update')->title($this->config['module_name']['single'] . ' aanpassen');
    }

    public function save()
    {
        $this->validate();

        $row = $this->only(
            'company_id',
            'pid',
            'locale',
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
        $row['updated_by'] = auth('staff')->user()->name;
        Agenda::where('id', $this->id)->update($row);

        // return redirect()->to(route($this->route_name . '.list'));
        Flux::toast('Opgeslagen', duration: 1000, variant: 'success');
    }
}

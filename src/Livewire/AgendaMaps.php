<?php

namespace Darvis\ModuleAgenda\Livewire;

use Darvis\Manta\Traits\MantaMapsTrait;
use Darvis\ModuleAgenda\Models\Agenda;
use Darvis\Manta\Models\Option;
use Darvis\Manta\Traits\MantaTrait;
use Livewire\Component;

class AgendaMaps extends Component
{
    use MantaTrait;
    use AgendaTrait;
    use MantaMapsTrait;

    public function mount(Agenda $agenda)
    {
        $this->locale = getLocaleManta();
        $this->item = $agenda;
        $this->itemOrg = $agenda;
        $this->id = $agenda->id;

        $this->fill(
            $agenda->only(
                'latitude',
                'longitude',
                'address',
                'address_nr',
                'city',
                'country',
            ),
        );
        if (!empty($this->address_nr)) $this->address .= ' ' . $this->address_nr;
        if (!empty($this->city)) $this->address .= ', ' . $this->city;
        if (!empty($this->country)) $this->address .= ', ' . $this->country;

        $this->DEFAULT_LATITUDE = $this->latitude ? $this->latitude : Option::get('DEFAULT_LATITUDE', null, app()->getLocale());
        $this->DEFAULT_LONGITUDE = $this->longitude ? $this->longitude : Option::get('DEFAULT_LONGITUDE', null, app()->getLocale());
        $this->GOOGLE_MAPS_ZOOM = Option::get('GOOGLE_MAPS_ZOOM', null, app()->getLocale());

        $this->getLocaleInfo();
        $this->getBreadcrumb('maps');
        $this->getTablist();
    }

    public function render()
    {
        $this->markers[] = ['id' => $this->id, 'latitude' => (float)$this->DEFAULT_LATITUDE, 'longitude' => (float)$this->DEFAULT_LONGITUDE, 'title' => $this->title, 'draggable' => true];
        return view('module-agenda::livewire.agenda-maps')->title($this->config['module_name']['single'] . ' maps');
    }


    public function save()
    {
        $this->validate([
            'DEFAULT_LATITUDE' => 'required',
            'DEFAULT_LONGITUDE' => 'required'
        ], [
            'DEFAULT_LATITUDE.required' => 'De latitude is verplicht',
            'DEFAULT_LONGITUDE.required' => 'De longitude is verplicht'
        ]);

        $row = [];
        $row['latitude'] = $this->DEFAULT_LATITUDE;
        $row['longitude'] = $this->DEFAULT_LONGITUDE;
        $row['updated_by'] = auth('staff')->user()->name;
        Agenda::where('id', $this->id)->update($row);


        return redirect()->to(route('agenda.read', ['agenda' => $this->id]));
    }
}

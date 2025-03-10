<?php

namespace Darvis\ModuleAgenda\Livewire;

use Livewire\Component;
use Darvis\ModuleAgenda\Models\Agenda;
use Darvis\Manta\Traits\MantaTrait;
use Illuminate\Http\Request;

class AgendaUpload extends Component
{
    use MantaTrait;
    use AgendaTrait;

    public function mount(Request $request, Agenda $agenda)
    {
        $this->item = $agenda;
        $this->itemOrg = $agenda;
        $this->locale = $agenda->locale;
        if ($request->input('locale') && $request->input('locale') != getLocaleManta()) {
            $this->pid = $agenda->id;
            $this->locale = $request->input('locale');
            $item_translate = Agenda::where(['pid' => $agenda->id, 'locale' => $request->input('locale')])->first();
            $this->item = $item_translate;
        }

        if ($agenda) {
            $this->id = $agenda->id;
        }

        $this->getLocaleInfo();
        $this->getBreadcrumb('upload');
        $this->getTablist();
    }

    public function render()
    {
        return view('manta::default.manta-default-upload')->title($this->config['module_name']['single'] . ' bestanden');
    }
}

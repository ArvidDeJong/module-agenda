<?php

namespace Darvis\ModuleAgenda\Livewire;

use Livewire\Component;
use Darvis\Manta\Traits\TableRowTrait;

class AgendaListRow extends Component
{
    use AgendaTrait;
    use TableRowTrait;

    public function render()
    {
        return view('module-agenda::livewire.agenda-list-row');
    }
}

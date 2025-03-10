<?php

namespace Darvis\ModuleAgenda\Livewire;

use Livewire\Component;

use Darvis\Manta\Traits\SortableTrait;
use Darvis\Manta\Traits\MantaTrait;
use Darvis\Manta\Traits\WithSortingTrait;
use Darvis\ModuleAgenda\Models\Agenda;
use Livewire\WithPagination;

class AgendaList extends Component
{
    use AgendaTrait;
    use WithPagination;
    use SortableTrait;
    use MantaTrait;
    use WithSortingTrait;

    public function mount()
    {
        $this->sortBy = 'from';
        $this->sortDirection = 'DESC';
    }

    public function render()
    {
        $this->trashed = count(Agenda::whereNull('pid')->onlyTrashed()->get());

        $obj = Agenda::whereNull('pid');
        if ($this->tablistShow == 'trashed') {
            $obj->onlyTrashed();
        }
        $obj = $this->applySorting($obj);
        $obj = $this->applySearch($obj);
        $items = $obj->paginate(50);
        return view('module-agenda::livewire.agenda-list', ['items' => $items])->title($this->config['module_name']['multiple']);
    }
}

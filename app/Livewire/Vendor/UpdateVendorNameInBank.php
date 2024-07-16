<?php

namespace App\Livewire\Vendor;

use Livewire\Component;

class UpdateVendorNameInBank extends Component
{
    public $modalOpen = true;
    public $name_in_bank = '';

    public function store()
    {
        $this->validate(['name_in_bank' => 'required'], [], ['name_in_bank' => trans('admin.name_in_bank')]);

        auth()->user()->vendor()->update(['name_in_bank' => $this->name_in_bank]);


        session()->flash('success', 'تم الحفظ بنجاح');
        $this->modalOpen = false;
    }
    public function render()
    {
        return view('livewire.vendor.update-vendor-name-in-bank');
    }
}

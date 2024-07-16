<?php

namespace App\Livewire\Admin;

use App\Models\Client;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use App\Services\Admin\GlobalSearchService;

class GlobalSearch extends Component
{

    public $openModal = false;
    public $search = '';
    public $globalSearchResults = [];

    public function updatedSearch(GlobalSearchService $globalSearchService)
    {
        $searchValue = trim($this->search);
        if (!empty($searchValue)) {
            $this->globalSearchResults['العملاء'] = $globalSearchService->filterByClient($searchValue);
            $this->globalSearchResults['المتاجر'] = $globalSearchService->filterByVendors($searchValue);
            $this->globalSearchResults['مستخدمين المتاجر'] = $globalSearchService->filterByVendorsUsers($searchValue);
            $this->globalSearchResults['الطلبات'] = $globalSearchService->filterByOrders($searchValue);
            $this->globalSearchResults['المنتجات'] = $globalSearchService->filterByProducts($searchValue);
            $this->globalSearchResults['المستودعات'] = $globalSearchService->filterByWarehouse($searchValue);
            $this->globalSearchResults['محافظ المتاجر'] = $globalSearchService->filterByVendorsWallet($searchValue);
        } else {
            $this->reset('globalSearchResults');
        }

        $this->globalSearchResults = array_filter($this->globalSearchResults, fn ($item) => !empty($item));
    }

    public function render()
    {
        return view('livewire.admin.global-search');
    }
}

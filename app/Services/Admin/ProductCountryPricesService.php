<?php
    namespace App\Services\Admin;

    use App\Models\ProductPrice;
    use App\Repositories\Admin\ProductCountryPricesRepository;
    use Exception;
    use App\Models\Country;
    use App\Models\Product;
    use Illuminate\Http\Request;
    use App\Repositories\Admin\CountryRepository;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    class ProductCountryPricesService
    {
        public $repository;

        /**
         * Country Service Constructor.
         *
         * @param CountryRepository $repository
         */
        public function __construct(ProductCountryPricesRepository $repository)
        {
            $this->repository = $repository;
        }

        /**
         * Get Countries.
         *
         * @return Collection
         */
        public function getAllCountriesPrices(): Collection
        {
            return $this->repository->all()->get();
        }

        /**
         * Get Countries with pagination.
         *
         * @param Request $request
         * @param integer $perPage
         * @param string $orderBy
         * @return LengthAwarePaginator
         */
        public function getAllCountriesPricesWithPagination($request, $productId, int $perPage = 10, string $orderBy = "DESC"): LengthAwarePaginator
        {
            $countriesPrices = $this->repository->all()->newQuery();
            return $countriesPrices->
            whereHas('country',function($q){
                $q->where('is_national',0);
            })->
            with('country')->where('product_id', $productId)->orderBy("updated_at", $orderBy)->paginate($perPage);
        }

        /**
         * Get Country using ID.
         *
         * @param integer $id
         * @return Country
         */
        public function getCountryPriceUsingID(int $id): ProductPrice
        {
            return $this->repository->all()->where('id', $id)->first();
        }

        /**
         * Create New Country.
         *
         * @param Request $request
         * @return array
         */
        public function createCountryPrice(array $request): array
        {
            $data = self::CountryPriceAddEditData($request);
            $this->repository->updateOrCreate([
                "product_id" => $data['product_id'],
                "country_id" => $data['country_id'],
            ]
                ,$data);
            if(!empty($data['country_id']))
            {
                return [
                    "product_id" => $data['product_id'],
                    "success" => TRUE,
                    "title" => trans("admin.countries_prices.messages.created_successfully_title"),
                    "body" => trans("admin.countries_prices.messages.created_successfully_body"),
                    "id" => $data['country_id']
                ];
            }
            return [
                "product_id" => $data['product_id'],
                "success" => FALSE,
                "title" => trans("admin.countries_prices.messages.created_error_title"),
                "body" => trans("admin.countries_prices.messages.created_error_body"),
            ];
        }

        /**
         * Update Country Using ID.
         *
         * @param integer $country_id
         * @param Request $request
         * @return array
         */
        public function updateCountryPrice(int $countryPrice_id,array $request): array
        {
            $countryPrice = $this->getCountryPriceUsingID($countryPrice_id);
            $data = self::CountryPriceAddEditData($request);

            if($countryPrice->country->is_national != 1)
            {
                $countryPrice->update($data);
            }

            return [
                "product_id" => $data['product_id'],
                "success" => TRUE,
                "title" => trans("admin.countries_prices.messages.updated_successfully_title"),
                "body" => trans("admin.countries_prices.messages.updated_successfully_body"),
            ];
        }

        /**
         * Delete Country Using.
         *
         * @param int $country_id
         * @return array
         */
        public function deleteCountryPrice(int $country_id): array
        {
            $countryPrice = $this->getCountryPriceUsingID($country_id);
            $productId = $countryPrice->product_id;
            if($countryPrice->country->is_national != 1)
            {
                $isDeleted = $this->repository->delete($countryPrice);
                return [
                    "product_id" => $productId,
                    "success" => TRUE,
                    "title" => trans("admin.countries_prices.messages.deleted_successfully_title"),
                    "body" => trans("admin.countries_prices.messages.deleted_successfully_message"),
                ];
            }
            else
            {
                return [
                    "product_id" => $productId,
                    "success" => FALSE,
                    "title" => trans("admin.countries_prices.messages.deleted_error_title"),
                    "body" => trans("admin.countries_prices.messages.deleted_error_message"),
                ];
            }
        }

        public function CountryPriceAddEditData($request): array
        {
            $product = Product::findOrfail($request['product_id']);
            $country = Country::where('id', $request['country_id'])->first();
            $vatPercentage = $country ? $country->vat_percentage : (Setting::where('key', SettingEnum::vat)->first()->value??0);
            $priceWithVat = isset($request['price_with_vat']) ? $request['price_with_vat'] * 100 : $product->price;
            $priceWithoutVat = $priceWithVat * 1 / (1 + $vatPercentage / 100);
            $priceBefore = isset($request['price_before_offer_in_halala']) ? $request['price_before_offer_in_halala'] * 100 : $product->price_before_offer;
            return [
                "product_id" => $product->id,
                "country_id" => $country->id??NULL,
                "vat_percentage" => $vatPercentage,
                "vat_rate_in_halala" => $priceWithVat - $priceWithoutVat,
                "price_without_vat_in_halala" => $priceWithoutVat,
                "price_with_vat_in_halala" => $priceWithVat,
                'price_before_offer_in_halala' => $priceBefore
            ];
        }
    }

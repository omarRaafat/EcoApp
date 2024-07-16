<?php

namespace Database\Seeders;

use App\Models\Rule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubAdminRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_truncateOldUsersRules();
        $rules = $this->_createAndGetRules();
        $subAdmins = $this->_getAdmins();
        $this->_assignUserRules($rules, $subAdmins);        
    }

    /**
     * Truncate Old User Rules.
     * 
     * @return void
     */
    private function _truncateOldUsersRules() : void
    {
        DB::table('rule_users')->truncate();
    }

    /**
     * Create Rules and return the rules with sub-admin scope.
     * 
     * @return array
     */
    private function _createAndGetRules() : array
    {
        Rule::create([
            "name" => [
                "ar" => "إدارة المستودعات",
                "en" => "Manage Warehouses",
            ],
            "scope" => "sub-admin",
            "created_at" => now(),
            "updated_at" => now()
        ]);

        Rule::create([
            "name" => [
                "ar" => "إدارى ماليات العملاء",
                "en" => "Manage Customers Financis",
            ],
            "scope" => "sub-admin",
            "created_at" => now(),
            "updated_at" => now()
        ]);

        Rule::create([
            "name" => [
                "ar" => "إدارى المتاجر",
                "en" => "Manage Vendors",
            ],
            "scope" => "sub-admin",
            "created_at" => now(),
            "updated_at" => now()
        ]);

        return Rule::where("scope", "sub-admin")->pluck("id")->toArray();
    }

    /**
     * Get SubAdmins from users table using type [sub-admin].
     * 
     * @return Collection
     */
    private function _getAdmins() : Collection
    {
        return User::where("type", "sub-admin")->get();
    }

    /**
     * Assign Rules To Users.
     * 
     * @param array $rules_ids
     * @param Collection $subAdmins
     * @return void
     */
    private function  _assignUserRules(array $rules_ids, Collection $subAdmins) : void
    {
        foreach ($subAdmins as $key => $subAdmin) {
            $subAdmin->rules()->attach($rules_ids);
        }
    }
}

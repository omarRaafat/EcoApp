<?php

namespace App\Services\Admin;

use App\Enums\RuleEnum;
use App\Models\Rule;
use Illuminate\Http\Request;
use App\Repositories\Admin\RuleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RuleService
{
    /**
     * Rule Service Constructor.
     *
     * @param RuleRepository $repository
     */
    public function __construct(public RuleRepository $repository) {}

    /**
     * Get Rules.
     *
     * @return Collection
     */
    public function getAllRules() : Collection
    {
        return $this->repository->all()->get();
    }

    /**
     * Get Rules with pagination.
     *
     * @param Request $request
     * @param integer $perPage
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function getAllRulesWithPagination(Request $request, int $perPage = 10, string $orderBy = "DESC") : LengthAwarePaginator
    {
        $rules = $this->repository
                    ->all()
                    ->newQuery();

        if($request->has("search")) {
            if($request->has("trans") && $request->trans != "all") {
                $rules->where('name->' . $request->trans, 'LIKE', "%{$request->search}%");
            }
        }

        return $rules->orderBy("created_at", $orderBy)->paginate($perPage);
    }

    /**
     * Get Rule using ID.
     *
     * @param integer $id
     * @return Rule
     */
    public function getRuleUsingID(int $id) : Rule
    {
        return $this->repository
                    ->all()
                    ->where('id',$id)
                    ->first();
    }

    /**
     * Create New Rule.
     *
     * @param Request $request
     * @return array
     */
    public function createRule(Request $request) : array
    {       
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ],
            "scope" => RuleEnum::SUB_ADMIN
        ]);

        $rule = $this->repository->store(
            $request->except('_method', '_token')
        );
        
        $rule->permissions()->attach($request->permissions);

        if(!empty($rule)) {
            return [
                "success" => true,
                "title" => trans("admin.rules.messages.created_successfully_title"),
                "body" => trans("admin.rules.messages.created_successfully_body"),
                "id" => $rule->id
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.rules.messages.created_error_title"),
            "body" => trans("admin.rules.messages.created_error_body"),
        ];
    }

    /**
     * Update Rule Using ID.
     *
     * @param integer $rule_id
     * @param Request $request
     * @return array
     */
    public function updateRule(int $rule_id, Request $request) : array
    {
        $request->merge([
            "name" => [
                "ar" => $request->name_ar,
                "en" => $request->name_en
            ]
        ]);

        $rule = $this->getRuleUsingID($rule_id);

        $this->repository->update($request->except('_method', '_token'), $rule);

        $rule->permissions()->sync($request->permissions);

        return [
            "success" => true,
            "title" => trans("admin.rules.messages.updated_successfully_title"),
            "body" => trans("admin.rules.messages.updated_successfully_body"),
        ];
    }

    /**
     * Delete Rule Using.
     *
     * @param int $rule_id
     * @return array
     */
    public function deleteRule(int $rule_id) : array
    {
        $rule = $this->getRuleUsingID($rule_id);
        $isDeleted = $this->repository->delete($rule);
        
        if($isDeleted == true) {
            return [
                "success" => true,
                "title" => trans("admin.rules.messages.deleted_successfully_title"),
                "body" => trans("admin.rules.messages.deleted_successfully_message"),
            ];
        }

        return [
            "success" => false,
            "title" => trans("admin.rules.messages.deleted_error_title"),
            "body" => trans("admin.rules.messages.deleted_error_message"),
        ];
    }
}

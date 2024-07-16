<?php

namespace App\Traits;

use App\Enums\UserTypes;
use App\Models\Rule;
use App\Models\RuleUser;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait AdminHasRole {
    /**
     * Get All Rules assossiated to this user using custom pivot Model|Table.
     *
     * @return BelongsToMany
     */
    public function rules() : BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'rule_users', 'user_id', 'rule_id')
                    ->withPivot(["user_id", "rule_id"]);
    }

    /**
     * Qeury Scope to get only users with sub-admin type.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSubadmins(Builder $query) : Builder
    {
        return $query->where("type", "sub-admin");
    }

    /**
     * Return array of subAdmin Permitted Permissions.
     *
     * @return Collection
     */
    public function subAdminPermittedPermissions() : Collection
    {
        $routes = collect([]);
        $this->rules->each(
            fn($rule) => $rule->permissions->each(
                fn($permission) => $routes->push(...$permission->route)
            )
        );
        return $routes;
    }

    /**
     * @param string $route
     * @return bool
     */
    public function isAdminPermittedTo(string $route) : bool
    {
        return auth()->check() &&
            (
                auth()->user()->subAdminPermittedPermissions()->contains($route) ||
                auth()->user()->type == "admin"
            );
    }

      /**
     * @param string $route
     * @return bool
     */
    public function isAdminPermittedToList(array $routes) : bool
    {
        return auth()->check() &&
            (
                !empty(array_intersect($routes,  auth()->user()->subAdminPermittedPermissions()->toArray()))||
                auth()->user()->type == "admin"
            );
    }

    /**
     * @param string $route
     * @return bool
     */
    public function isAdminNotPermittedTo(string $route) : bool
    {
        return !$this->isAdminPermittedTo($route);
    }

    public function permittedRoutes() : Collection {
        $routes = collect([]);
        $this->rules->each(fn($rule) =>
            $rule->permissions->each(
                fn($p) => $routes->push(...$p->route)
            )
        );
        return $routes;
    }

    /**
     * @param string $groupName
     * @return bool
     */
    public function isAdminPermittedToGroup(string $groupName) : bool
    {
        if ($this->type == UserTypes::ADMIN) return true;

        return self::where('id', auth()->user()->id)
            ->whereHas(
                'rules',
                fn($rule) => $rule->whereHas(
                    'permissions', fn($q) => $q->where('group', $groupName)
                )
            )->exists();
    }
}

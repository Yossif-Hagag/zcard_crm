<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Search paginated items ordering by ID descending
     */
    public function scopeSearchLatestPaginated(
        Builder $query,
        string $search,
        int $paginationQuantity = 10
    ): Builder {
        return $query
            ->search($search)
            ->orderBy('updated_at', 'desc')
            ->paginate($paginationQuantity);
    }

    /**
     * Adds a scope to search the table based on the
     * $searchableFields array inside the model
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        $query->where(function ($query) use ($search) {
            foreach ($this->getSearchableFields() as $field) {
                $query->orWhere($field, 'like', "%{$search}%");
            }
        });

        return $query;
    }
    // public function scopeSearchSelected(Builder $query, string $item_name, object $user, array $statusFilters, string $search, string $search_select): Builder
    // {
    //     return $query->where(function (Builder $query) use ($item_name, $user, $statusFilters, $search, $search_select) {
    //         if (in_array($search_select, $this->getSearchableFields())) {
    //             if ($user->hasRole("Delivery Boy")  || $user->hasRole("Shipping Company")) {
    //                 if ($item_name == 'all') {
    //                     if (array_key_exists($item_name, $statusFilters)) {
    //                         $query->whereIn('shipping_status', ['waiting-for-follow-up', 'completed'])
    //                             ->where($search_select, 'like', "%{$search}%")
    //                             ->whereHas('users', function ($query) {
    //                                 $query->where('users.id', auth()->user()->id);
    //                             });
    //                     }
    //                 } else {
    //                     if (array_key_exists($item_name, $statusFilters)) {
    //                         $query->where('shipping_status', $statusFilters[$item_name])
    //                             ->where($search_select, 'like', "%{$search}%")
    //                             ->whereHas('users', function ($query) {
    //                                 $query->where('users.id', auth()->user()->id);
    //                             });
    //                     }
    //                 }
    //             } elseif ($user->hasRole("Shipping Operation")) {
    //                 if ($item_name == 'all') {
    //                     $query->whereIn('shipping_status', ['new', 'in-progress', 'on-the-way', 'completed', 'unsuccessful', 'returns-rejected'])
    //                         ->where($search_select, 'like', "%{$search}%");
    //                 } else {
    //                     if (array_key_exists($item_name, $statusFilters)) {
    //                         $query->where('shipping_status', $statusFilters[$item_name])
    //                             ->where($search_select, 'like', "%{$search}%");
    //                     }
    //                 }
    //             } elseif ($user->hasRole("Super Admin")) {
    //                 if ($item_name == 'all') {
    //                     $query->whereIn('shipping_status', ['new', 'in-progress', 'on-the-way', 'waiting-for-follow-up', 'completed', 'unsuccessful', 'returns-rejected'])
    //                         ->where($search_select, 'like', "%{$search}%");
    //                 } else {
    //                     if (array_key_exists($item_name, $statusFilters)) {
    //                         $query->where('shipping_status', $statusFilters[$item_name])
    //                             ->where($search_select, 'like', "%{$search}%");
    //                     }
    //                 }
    //             }
    //         }
    //     });
    // }
    public function scopeSearchSelected(Builder $query, string $item_name, object $user, array $statusFilters, string $search, string $search_select): Builder
    {
        return $query->where(function (Builder $query) use ($item_name, $user, $statusFilters, $search, $search_select) {
            if (in_array($search_select, $this->getSearchableFields())) {
                if ($user->hasRole("Delivery Boy")  || $user->hasRole("Shipping Company")) {
                    if ($item_name == 'all') {
                        if (array_key_exists($item_name, $statusFilters)) {
                            $query->whereIn('shipping_status', ['waiting-for-follow-up', 'completed'])
                                ->where($search_select, 'like', "%{$search}%")
                                ->whereHas('users', function ($query) {
                                    $query->where('users.id', auth()->user()->id);
                                });
                        }
                    } else {
                        if (array_key_exists($item_name, $statusFilters)) {
                            $query->where('shipping_status', $statusFilters[$item_name])
                                ->where($search_select, 'like', "%{$search}%")
                                ->whereHas('users', function ($query) {
                                    $query->where('users.id', auth()->user()->id);
                                });
                        }
                    }
                } else if ($user->hasRole("Super Admin") || $user->hasRole("Team Leader") || $user->hasRole("Shipping Operation")) {
                    if ($item_name == 'all') {
                        $query->whereIn('shipping_status', ['new', 'in-progress', 'on-the-way', 'waiting-for-follow-up', 'completed', 'unsuccessful', 'returns-rejected'])
                            ->where($search_select, 'like', "%{$search}%");
                    } else {
                        if (array_key_exists($item_name, $statusFilters)) {
                            $query->where('shipping_status', $statusFilters[$item_name])
                                ->where($search_select, 'like', "%{$search}%");
                        }
                    }
                }
            }
        });
    }

    /**
     * Returns the searchable fields. If $searchableFields is undefined,
     * or is an empty array, or its first element is '*', it will search
     * in all table fields
     */
    protected function getSearchableFields(): array
    {
        if (isset($this->searchableFields) && count($this->searchableFields)) {
            return $this->searchableFields[0] === '*'
                ? $this->getAllModelTableFields()
                : $this->searchableFields;
        }

        return $this->getAllModelTableFields();
    }

    /**
     * Gets all fields from Model's table
     */
    protected function getAllModelTableFields(): array
    {
        $tableName = $this->getTable();

        return $this->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($tableName);
    }
}

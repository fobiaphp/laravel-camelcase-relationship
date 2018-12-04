<?php

namespace Fobia\Relationship;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class CamelCaseBuilder
 */
class CamelCaseBuilder extends Builder
{

    /**
     * @inheritdoc
     */
    public function with($relations)
    {
        $relations = array_map(function ($key) {
            if (is_string($key) && strpos($key, '_') !== false) {
                $key = Str::camel($key);
            }
            return $key;
        }, is_string($relations) ? func_get_args() : $relations);

        return parent::with($relations);
    }

    /**
     * @inheritdoc
     */
    public function without($relations)
    {
        $relations = array_map(function ($key) {
            if (is_string($key) && strpos($key, '_') !== false) {
                $key = Str::camel($key);
            }
            return $key;
        }, is_string($relations) ? func_get_args() : $relations);

        return parent::without($relations);
    }
}

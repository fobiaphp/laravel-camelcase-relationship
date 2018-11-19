<?php

namespace Fobia\Relationship;

use Illuminate\Database\Eloquent\Builder;

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
            if (strpos($key, '_') !== false) {
                $key = camel_case($key);
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
            if (strpos($key, '_') !== false) {
                $key = camel_case($key);
            }
            return $key;
        }, is_string($relations) ? func_get_args() : $relations);

        return parent::without($relations);
    }
}

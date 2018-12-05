<?php

namespace Fobia\Relationship;

/**
 * Trait CamelCaseRelationship
 *
 * Позволяет обращаться к отношением модели и загружать их лениво по snake_case синтаксису
 *
 * В оригинале, к отношениям можно оброщаться так же ка определен метод отношений. Медоты, как правило, именованы стилем camel_case.
 * Однако при конвертации в масив, все поля преобразуются в snake_case
 *
 * $c = App\Models\Company::first();
 * $c->legalForm;           // App\Models\LegalForms\LegalForm {#}
 * $c->legal_form;          // null
 * $c->load('legal_form');  // Error: RelationNotFoundException
 * $c->toArray();           //
 * {
 *   "id": 1,
 *   "name": "first name",
 *   "legal_form": {
 *       "id": 1,
 *        "name": "relation name"
 *    }
 * }
 *
 * Этот трейд позволяет обращать к отношениям синтаксисом snake_case
 *
 * $c = App\Models\Company::first();
 * $c->legal_form;         // App\Models\LegalForms\LegalForm {#}
 * $c->load('legal_form'); // App\Models\Company {#}
 */
trait CamelCaseRelationship
{

    /**
     * @inheritdoc
     */
    public static function with($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;
        $relations = static::camelCaseAttribute($relations);

        // $relations = array_map(function ($key) {
        //     if (strpos($key, '_') !== false) {
        //         $key = camel_case($key);
        //     }
        //     return $key;
        // }, $relations);

        return (new static)->newQuery()->with($relations);
    }

    /**
     * @inheritdoc
     */
    public function getRelationValue($key)
    {
        if (strpos($key, '_') !== false && !method_exists($this, $key)) {
            $key = camel_case($key);
        }
        return parent::getRelationValue($key);
    }

    /**
     * @inheritdoc
     */
    public function load($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;
        $relations = $this->camelCaseAttribute($relations);

        return parent::load($relations);
    }

    /**
     * @inheritdoc
     */
    public function loadMissing($relations)
    {
        $relations = is_string($relations) ? func_get_args() : $relations;
        $relations = $this->camelCaseAttribute($relations);

        return parent::loadMissing($relations);
    }

    /**
     * @inheritdoc
     */
    public function fresh($with = [])
    {
        $with = is_string($with) ? func_get_args() : $with;
        $with = $this->camelCaseAttribute($with);

        return parent::fresh($with);
    }

    /**
     * @inheritdoc
     */
    public function newEloquentBuilderWithCamelCaseRelationship($query)
    {
        return new CamelCaseBuilder($query);
    }

    /**
     * Преобразовывает имена атрибутов в camelCase формат
     *
     * @param array $relations
     * @return array
     */
    protected static function camelCaseAttribute(array $relations)
    {
        $results = [];

        foreach ($relations as $key => $value) {
            if (is_numeric($key)) {
                if (is_string($value)) {
                    $value = static::camelCaseAttributeString($value);
                }
            } else {
                if (is_string($key)) {
                    $key = static::camelCaseAttributeString($key);
                }
            }

            $results[$key] = $value;
        }

        return $results;
        /*
        return array_map(function ($key) {
            if (strpos($key, '_') !== false) {
                $key = camel_case($key);
            }
            return $key;
        }, $relations);
        /* */
    }

    /**
     * @param string $relation
     * @return string
     */
    protected static function camelCaseAttributeString(string $relation) : string
    {
        if (strpos($relation, ' ') !== false || strpos($relation, '_') === false) {
            return $relation;
        }

        if (strpos($relation, ':') !== false) {
            $str = explode(':', $relation);
            if (strpos($str[0], '_') !== false) {
                $str[0] = camel_case($str[0]);
            }
            $relation = implode(':', $str);
        } else {
            if (strpos($relation, '_') !== false) {
                $relation = camel_case($relation);
            }
        }

        return $relation;
    }
}

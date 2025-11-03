<?php

namespace Fobia\Relationship\Tests\Fixtures;

use Mockery as m;
use Illuminate\Database\Eloquent\Model;
use Fobia\Relationship\CamelCaseRelationship;

class ModelStub extends Model
{
     use CamelCaseRelationship;

    /**
     * @return BelongsTo
     */
    public function legalForm() : BelongsTo
    {
        return $this->belongsTo(LegalForm::class);
    }
}
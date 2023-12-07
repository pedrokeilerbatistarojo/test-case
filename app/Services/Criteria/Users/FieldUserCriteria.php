<?php

namespace App\Services\Criteria\Users;

use App\Services\Criteria\CriteriaInterface;
use CodeIgniter\Database\BaseBuilder;

class FieldUserCriteria implements CriteriaInterface
{
    protected $field;
    protected $value;

    public function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }

    public function apply($builder): BaseBuilder
    {
        return $builder->where($this->field, $this->value);
    }
}
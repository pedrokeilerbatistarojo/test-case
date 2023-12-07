<?php

namespace App\Services\Criteria;

use CodeIgniter\Database\BaseBuilder;

interface CriteriaInterface {
    public function apply(BaseBuilder $builder);
}
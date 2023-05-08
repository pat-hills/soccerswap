<?php

namespace App\Rules;

use Symfony\Component\Validator\Constraint;

class UniqueEntry extends Constraint
{
    public $message = 'This name is already taken.';
    public $entityClass;
    public $field;
    public $validatedBy = 'unique_entry_validator';
}


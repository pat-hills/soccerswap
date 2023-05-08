<?php

namespace App\Rules;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class UniqueEntryValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        $repository = $this->entityManager->getRepository($constraint->entityClass);
        $existingEntity = $repository->findOneBy([$constraint->field => $value]);

        if ($existingEntity !== null) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}



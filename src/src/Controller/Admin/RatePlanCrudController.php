<?php

namespace App\Controller\Admin;

use App\Entity\RatePlan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RatePlanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RatePlan::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

<?php

namespace App\Controller\Admin;

use App\Entity\PropertyType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PropertyTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PropertyType::class;
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

<?php

namespace App\Controller\Admin;

use App\Entity\Travaux;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TravauxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Travaux::class;
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

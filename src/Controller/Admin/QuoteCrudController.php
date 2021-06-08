<?php

namespace App\Controller\Admin;

use App\Entity\Quote;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quote::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('content')->onlyOnForms(),
            TextEditorField::new('meta')->onlyOnForms(),
            TextField::new('content')->hideOnForm(),
            TextField::new('meta')->hideOnForm(),
            AssociationField::new('category')
                ->formatValue(function ($value, $entity) {
                    return $entity->getCategory();
                }),
        ];
    }
}

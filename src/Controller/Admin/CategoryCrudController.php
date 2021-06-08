<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('imageName', 'Image')
                ->setBasePath('/images/categories')
                ->setUploadDir('public/images/categories')
                ->hideOnForm(),

            Field::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setTranslationParameters(['form.label.delete' => 'Supprimer'])
                ->onlyOnForms(),
        ];
    }
}

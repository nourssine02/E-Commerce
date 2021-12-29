<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Taille;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('categorie'),
            NumberField::new('prix'),
            IntegerField::new('qteStock'),
            TextareaField::new('imageFile', 'Article image')
                ->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/images/products')->onlyOnIndex(),
          

            TextField::new('description'),


        ];
    }
}

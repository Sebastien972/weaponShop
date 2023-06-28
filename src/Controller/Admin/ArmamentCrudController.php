<?php

namespace App\Controller\Admin;

use App\Entity\Armament;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArmamentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Armament::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            IntegerField::new('quantity'),
            BooleanField::new('mostPopular', 'popular'),
            TextEditorField::new('description'),
            TextEditorField::new('moreInformation'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('categorie'),
            AssociationField::new('calibre'),
            DateField::new('createdAt')->hideOnForm(),
            ImageField::new('image')->setBasePath('/assets/img/armament/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setUploadDir('/public/assets/img/armament/'),
            ImageField::new('image2')->setBasePath('/assets/img/armament/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setUploadDir('/public/assets/img/armament/')


        ];
    }
    
}

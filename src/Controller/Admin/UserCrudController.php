<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('lastname')->setLabel('Nom'),
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('email')->setLabel('Email')->onlyOnIndex(),
            ArrayField::new('roles')->setLabel('Role'),
        ];
    }
    
}

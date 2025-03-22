<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('createAt')
                ->setFormTypeOptions([
                    'widget' => 'single_text',
                    'html5' => true,
                    'required' => false,
                ])
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->setFormTypeOption('input', 'datetime_immutable')
                ->setLabel('Date'),
                
            TextField::new('message')->setLabel('Commentaire')
            ->setFormTypeOptions([
                'attr' => ['rows' => 10],
            ])
            ->setTemplatePath('admin/fields/textarea.html.twig'), // Optional: Custom template for better display,
                
            TextField::new('verified')->setLabel('Accepté')
        ];
    }
}

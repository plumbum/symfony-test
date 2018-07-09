<?php
/**
 * This file is part of the symfony-test project.
 * @project symfony-test
 * @file AuthorType.php
 * @license private
 * @author Ivan A-R <aia@bileter.ru> (ivan)
 * @date 09.07.18 11:25
 */


namespace App\Form;


use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('last_name', TextType::class, ['label' => 'Фамилия'])
            ->add('first_name', TextType::class, ['label' => 'Имя'])
            ->add('middle_name', TextType::class, ['label' => 'Отчество'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }

}
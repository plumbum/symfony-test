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


use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Название'])
            ->add('year', IntegerType::class, ['label' => 'Год издания'])
            ->add('ISBN', IntegerType::class, ['label' => 'ISBN'])
            ->add('pages', IntegerType::class, ['label' => 'Кол-во страниц'])
            // ->add('cover', FileType::class, ['label' => 'Обложка', 'required' => false])
            ->add('authors', EntityType::class, [
                'class' => 'App:Author',
                'choice_label' => 'short_name',
                'label' => 'Авторы',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }

}
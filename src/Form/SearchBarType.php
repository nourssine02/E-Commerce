<?php

namespace App\Form;

use App\Entity\SearchBar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Cor\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchBarType extends AbstractType
{
    //const PRICE = [10,20,30,40,50,60,70,80,90,100,200,300,400,500,600,700,800,900,1000];
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    
        $builder
            ->add('a', TextType::class,[
                'label' =>false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('maxPrice', NumberType::class, [
                'required' => false,
                'label' => 'High Price',
                'attr' => [
                    'placeholder' => ' max'
                ]
            ])
           
            ->add('minPrice', NumberType::class, [
                'required' => false,

                'label' => 'Low Price',
                'attr' => [
                    'placeholder' => 'min '
                ]
            ])
            
        
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchBar::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}

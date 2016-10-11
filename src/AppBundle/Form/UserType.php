<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class UserType extends AbstractType
{
    private $authChecker;

    public function __construct(AuthorizationChecker $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'required' => !$options['edit']
            )
        );

        if ($this->authChecker->isGranted('ROLE_GOD')) {
            $builder->add('roles', ChoiceType::class, array(
                'label' => 'Rôle',
                'expanded' => true,
                'multiple' => true,
                'choices' => array('user' => 'ROLE_USER', 'admin' => 'ROLE_ADMIN', 'god' => 'ROLE_GOD')
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'edit' => false,
            'validation_groups' => array('new')
        ));
    }
}
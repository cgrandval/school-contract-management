<?php

declare(strict_types=1);

namespace App\Form;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Session;
use App\Entity\Intervener;
use App\Entity\CourseLabel;
use App\Entity\Course;
use App\Listener\FormCreateOnTheFlyListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseWithContractType extends CourseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('contract', null, [
                'attr' => [
                    'data-use-select2' => 'true',
                ],
            ])
        ;
    }
}

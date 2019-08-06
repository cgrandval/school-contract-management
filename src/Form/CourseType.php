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

class CourseType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('courseLabel', null, [
                'attr' => [
                    'data-use-select2' => 'true',
                    'data-tags' => 'true',
                ],
            ])
            ->add('session', null, [
                'attr' => [
                    'data-use-select2' => 'true',
                    'data-tags' => 'true',
                ],
            ])
            ->add('intervener', null, [
                'attr' => [
                    'data-use-select2' => 'true',
                    'data-tags' => 'true',
                ],
            ])
            ->add('hours')
            ->add('dateStart', null, [
                'data' => new \DateTime(),
            ])
            ->add('dateEnd', null, [
                'data' => new \DateTime(),
            ])
            ->addEventSubscriber(new FormCreateOnTheFlyListener('intervener', Intervener::class, $this->objectManager))
            ->addEventSubscriber(new FormCreateOnTheFlyListener('courseLabel', CourseLabel::class, $this->objectManager))
            ->addEventSubscriber(new FormCreateOnTheFlyListener('session', Session::class, $this->objectManager))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}

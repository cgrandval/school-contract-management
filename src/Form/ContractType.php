<?php

declare(strict_types=1);

namespace App\Form;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Society;
use App\Entity\Contract;
use App\Listener\FormCreateOnTheFlyListener;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
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
            ->add('number', null, ['attr' => ['class' => 'form-control-lg']])
            ->add('society', null, [
                'attr' => [
                    'data-use-select2' => 'true',
                    'data-tags' => 'true',
                ],
            ])
            ->add('hourlyRate')
            ->add('signed')
            ->add('onServer')
            ->add('inIntranet')
            ->add('courses', CollectionType::class, [
                'entry_type' => CourseType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->addEventSubscriber(new FormCreateOnTheFlyListener('society', Society::class, $this->objectManager))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}

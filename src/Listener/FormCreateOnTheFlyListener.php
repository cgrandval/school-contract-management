<?php

declare(strict_types=1);

namespace App\Listener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FormCreateOnTheFlyListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(string $field, string $entityClass, ObjectManager $objectManager)
    {
        $this->field = $field;
        $this->entityClass = $entityClass;
        $this->objectManager = $objectManager;

        $this->checkEntityClass();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        ];
    }

    private function checkEntityClass(): void
    {
        if (!is_subclass_of($this->entityClass, CreatableOnTheFlyEntityInterface::class)) {
            throw new \LogicException(sprintf(
                'Class "%s" must implement interface "%s" in order to be used with %s.',
                $this->entityClass,
                CreatableOnTheFlyEntityInterface::class,
                self::class
            ));
        }
    }

    public function onPreSubmit(FormEvent $event): void
    {
        $formData = $event->getData();
        $fieldData = $formData[$this->field];

        if (empty($fieldData)) {
            return;
        }

        $entityClass = $this->entityClass;
        $repository = $this->objectManager->getRepository($entityClass);
        $entity = $repository->find($fieldData);

        if (null === $entity) {
            $entity = new $entityClass();
            $entity->setName($fieldData);
            $this->objectManager->persist($entity);
            $this->objectManager->flush();
            $formData[$this->field] = $entity->getId();
            $event->setData($formData);
        }
    }
}

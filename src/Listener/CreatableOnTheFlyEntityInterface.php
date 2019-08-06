<?php

declare(strict_types=1);

namespace App\Listener;

interface CreatableOnTheFlyEntityInterface
{
    /**
     * $name contains the string the user has filled in
     * to create this entity on the fly.
     */
    public function setName(string $name): CreatableOnTheFlyEntityInterface;
}

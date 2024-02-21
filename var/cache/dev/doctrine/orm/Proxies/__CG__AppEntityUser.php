<?php

namespace Proxies\__CG__\App\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class User extends \App\Entity\User implements \Doctrine\ORM\Proxy\InternalProxy
{
     use \Symfony\Component\VarExporter\LazyGhostTrait {
        initializeLazyObject as __load;
        setLazyObjectAsInitialized as public __setInitialized;
        isLazyObjectInitialized as private;
        createLazyGhost as private;
        resetLazyObject as private;
    }

    private const LAZY_OBJECT_PROPERTY_SCOPES = [
        "\0".parent::class."\0".'confirmationToken' => [parent::class, 'confirmationToken', null],
        "\0".parent::class."\0".'confirmed' => [parent::class, 'confirmed', null],
        "\0".parent::class."\0".'firstName' => [parent::class, 'firstName', null],
        "\0".parent::class."\0".'id' => [parent::class, 'id', null],
        "\0".parent::class."\0".'jobPosts' => [parent::class, 'jobPosts', null],
        "\0".parent::class."\0".'lastName' => [parent::class, 'lastName', null],
        "\0".parent::class."\0".'password' => [parent::class, 'password', null],
        "\0".parent::class."\0".'roles' => [parent::class, 'roles', null],
        "\0".parent::class."\0".'savedJobs' => [parent::class, 'savedJobs', null],
        "\0".parent::class."\0".'userProfile' => [parent::class, 'userProfile', null],
        "\0".parent::class."\0".'username' => [parent::class, 'username', null],
        'confirmationToken' => [parent::class, 'confirmationToken', null],
        'confirmed' => [parent::class, 'confirmed', null],
        'firstName' => [parent::class, 'firstName', null],
        'id' => [parent::class, 'id', null],
        'jobPosts' => [parent::class, 'jobPosts', null],
        'lastName' => [parent::class, 'lastName', null],
        'password' => [parent::class, 'password', null],
        'roles' => [parent::class, 'roles', null],
        'savedJobs' => [parent::class, 'savedJobs', null],
        'userProfile' => [parent::class, 'userProfile', null],
        'username' => [parent::class, 'username', null],
    ];

    public function __isInitialized(): bool
    {
        return isset($this->lazyObjectState) && $this->isLazyObjectInitialized();
    }

    public function __serialize(): array
    {
        $properties = (array) $this;
        unset($properties["\0" . self::class . "\0lazyObjectState"]);

        return $properties;
    }
}

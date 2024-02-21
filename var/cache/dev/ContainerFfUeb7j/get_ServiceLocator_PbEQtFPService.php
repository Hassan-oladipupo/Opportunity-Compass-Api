<?php

namespace ContainerFfUeb7j;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_PbEQtFPService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.PbEQtFP' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.PbEQtFP'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
            'repo' => ['privates', 'App\\Repository\\UserRepository', 'getUserRepositoryService', true],
            'security' => ['privates', 'security.helper', 'getSecurity_HelperService', true],
            'serializer' => ['privates', 'debug.serializer', 'getDebug_SerializerService', true],
            'slugger' => ['privates', 'slugger', 'getSluggerService', true],
            'validator' => ['privates', 'debug.validator', 'getDebug_ValidatorService', false],
        ], [
            'doctrine' => '?',
            'repo' => 'App\\Repository\\UserRepository',
            'security' => '?',
            'serializer' => '?',
            'slugger' => '?',
            'validator' => '?',
        ]);
    }
}

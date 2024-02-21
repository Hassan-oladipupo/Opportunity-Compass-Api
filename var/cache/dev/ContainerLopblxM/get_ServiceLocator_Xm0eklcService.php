<?php

namespace ContainerLopblxM;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Xm0eklcService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Xm0eklc' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Xm0eklc'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'job' => ['privates', '.errored..service_locator.Xm0eklc.App\\Entity\\JobPost', NULL, 'Cannot autowire service ".service_locator.Xm0eklc": it needs an instance of "App\\Entity\\JobPost" but this type has been excluded in "config/services.yaml".'],
            'repo' => ['privates', 'App\\Repository\\ApplicationFormRepository', 'getApplicationFormRepositoryService', true],
            'security' => ['privates', 'security.helper', 'getSecurity_HelperService', true],
            'serializer' => ['privates', 'debug.serializer', 'getDebug_SerializerService', true],
            'slugger' => ['privates', 'slugger', 'getSluggerService', true],
            'validator' => ['privates', 'debug.validator', 'getDebug_ValidatorService', false],
        ], [
            'job' => 'App\\Entity\\JobPost',
            'repo' => 'App\\Repository\\ApplicationFormRepository',
            'security' => '?',
            'serializer' => '?',
            'slugger' => '?',
            'validator' => '?',
        ]);
    }
}

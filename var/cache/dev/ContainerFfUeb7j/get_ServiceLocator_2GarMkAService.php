<?php

namespace ContainerFfUeb7j;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_2GarMkAService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.2GarMkA' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.2GarMkA'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'job' => ['privates', '.errored..service_locator.2GarMkA.App\\Entity\\JobPost', NULL, 'Cannot autowire service ".service_locator.2GarMkA": it needs an instance of "App\\Entity\\JobPost" but this type has been excluded in "config/services.yaml".'],
            'logger' => ['privates', 'monolog.logger', 'getMonolog_LoggerService', false],
            'repo' => ['privates', 'App\\Repository\\JobPostRepository', 'getJobPostRepositoryService', true],
            'security' => ['privates', 'security.helper', 'getSecurity_HelperService', true],
            'serializer' => ['privates', 'debug.serializer', 'getDebug_SerializerService', true],
            'validator' => ['privates', 'debug.validator', 'getDebug_ValidatorService', false],
        ], [
            'job' => 'App\\Entity\\JobPost',
            'logger' => '?',
            'repo' => 'App\\Repository\\JobPostRepository',
            'security' => '?',
            'serializer' => '?',
            'validator' => '?',
        ]);
    }
}

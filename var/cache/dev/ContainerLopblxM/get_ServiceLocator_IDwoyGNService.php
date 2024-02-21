<?php

namespace ContainerLopblxM;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_IDwoyGNService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.IDwoyGN' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.IDwoyGN'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'jobPostRepository' => ['privates', 'App\\Repository\\JobPostRepository', 'getJobPostRepositoryService', true],
            'serializer' => ['privates', 'debug.serializer', 'getDebug_SerializerService', true],
        ], [
            'jobPostRepository' => 'App\\Repository\\JobPostRepository',
            'serializer' => '?',
        ]);
    }
}
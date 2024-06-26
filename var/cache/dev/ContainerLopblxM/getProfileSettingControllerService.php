<?php

namespace ContainerLopblxM;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getProfileSettingControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\ProfileSettingController' shared autowired service.
     *
     * @return \App\Controller\ProfileSettingController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'framework-bundle'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'AbstractController.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'ProfileSettingController.php';

        $container->services['App\\Controller\\ProfileSettingController'] = $instance = new \App\Controller\ProfileSettingController(($container->privates['monolog.logger'] ?? $container->getMonolog_LoggerService()));

        $instance->setContainer(($container->privates['.service_locator.CshazM0'] ?? $container->load('get_ServiceLocator_CshazM0Service'))->withContext('App\\Controller\\ProfileSettingController', $container));

        return $instance;
    }
}

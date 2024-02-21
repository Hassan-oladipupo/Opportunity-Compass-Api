<?php

namespace ContainerLopblxM;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_ZG_FADYService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.ZG.FADY' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ZG.FADY'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'App\\Controller\\ApplicationFormController::submit' => ['privates', '.service_locator.Xm0eklc', 'get_ServiceLocator_Xm0eklcService', true],
            'App\\Controller\\ForgetPasswordController::forgotPassword' => ['privates', '.service_locator.NtmTMDf', 'get_ServiceLocator_NtmTMDfService', true],
            'App\\Controller\\ForgetPasswordController::resetPasswordConfirm' => ['privates', '.service_locator.GCUPvRb', 'get_ServiceLocator_GCUPvRbService', true],
            'App\\Controller\\JobPostController::addJob' => ['privates', '.service_locator.RiD9.Rd', 'get_ServiceLocator_RiD9_RdService', true],
            'App\\Controller\\JobPostController::deleteJob' => ['privates', '.service_locator.IQ9P7ON', 'get_ServiceLocator_IQ9P7ONService', true],
            'App\\Controller\\JobPostController::editJob' => ['privates', '.service_locator.2GarMkA', 'get_ServiceLocator_2GarMkAService', true],
            'App\\Controller\\JobPostController::getJobs' => ['privates', '.service_locator.IDwoyGN', 'get_ServiceLocator_IDwoyGNService', true],
            'App\\Controller\\JobPostController::searchJobs' => ['privates', '.service_locator.9SkhL0X', 'get_ServiceLocator_9SkhL0XService', true],
            'App\\Controller\\LoginController::login' => ['privates', '.service_locator.OIBAU7I', 'get_ServiceLocator_OIBAU7IService', true],
            'App\\Controller\\ProfileSettingController::getProfile' => ['privates', '.service_locator.rjWUkXW', 'get_ServiceLocator_RjWUkXWService', true],
            'App\\Controller\\ProfileSettingController::profile' => ['privates', '.service_locator.PbEQtFP', 'get_ServiceLocator_PbEQtFPService', true],
            'App\\Controller\\ProfileSettingController::profileImage' => ['privates', '.service_locator.pyE0C.I', 'get_ServiceLocator_PyE0C_IService', true],
            'App\\Controller\\RegistrationController::confirmEmail' => ['privates', '.service_locator.Jr0jWB9', 'get_ServiceLocator_Jr0jWB9Service', true],
            'App\\Controller\\RegistrationController::register' => ['privates', '.service_locator.hEUWOlY', 'get_ServiceLocator_HEUWOlYService', true],
            'App\\Controller\\SavedJobController::getSavedJobs' => ['privates', '.service_locator..6ULR9V', 'get_ServiceLocator__6ULR9VService', true],
            'App\\Controller\\SavedJobController::saveJobPost' => ['privates', '.service_locator.5H6T8FS', 'get_ServiceLocator_5H6T8FSService', true],
            'App\\Kernel::loadRoutes' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'App\\Kernel::registerContainerConfiguration' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'kernel::loadRoutes' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'kernel::registerContainerConfiguration' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'App\\Controller\\ApplicationFormController:submit' => ['privates', '.service_locator.Xm0eklc', 'get_ServiceLocator_Xm0eklcService', true],
            'App\\Controller\\ForgetPasswordController:forgotPassword' => ['privates', '.service_locator.NtmTMDf', 'get_ServiceLocator_NtmTMDfService', true],
            'App\\Controller\\ForgetPasswordController:resetPasswordConfirm' => ['privates', '.service_locator.GCUPvRb', 'get_ServiceLocator_GCUPvRbService', true],
            'App\\Controller\\JobPostController:addJob' => ['privates', '.service_locator.RiD9.Rd', 'get_ServiceLocator_RiD9_RdService', true],
            'App\\Controller\\JobPostController:deleteJob' => ['privates', '.service_locator.IQ9P7ON', 'get_ServiceLocator_IQ9P7ONService', true],
            'App\\Controller\\JobPostController:editJob' => ['privates', '.service_locator.2GarMkA', 'get_ServiceLocator_2GarMkAService', true],
            'App\\Controller\\JobPostController:getJobs' => ['privates', '.service_locator.IDwoyGN', 'get_ServiceLocator_IDwoyGNService', true],
            'App\\Controller\\JobPostController:searchJobs' => ['privates', '.service_locator.9SkhL0X', 'get_ServiceLocator_9SkhL0XService', true],
            'App\\Controller\\LoginController:login' => ['privates', '.service_locator.OIBAU7I', 'get_ServiceLocator_OIBAU7IService', true],
            'App\\Controller\\ProfileSettingController:getProfile' => ['privates', '.service_locator.rjWUkXW', 'get_ServiceLocator_RjWUkXWService', true],
            'App\\Controller\\ProfileSettingController:profile' => ['privates', '.service_locator.PbEQtFP', 'get_ServiceLocator_PbEQtFPService', true],
            'App\\Controller\\ProfileSettingController:profileImage' => ['privates', '.service_locator.pyE0C.I', 'get_ServiceLocator_PyE0C_IService', true],
            'App\\Controller\\RegistrationController:confirmEmail' => ['privates', '.service_locator.Jr0jWB9', 'get_ServiceLocator_Jr0jWB9Service', true],
            'App\\Controller\\RegistrationController:register' => ['privates', '.service_locator.hEUWOlY', 'get_ServiceLocator_HEUWOlYService', true],
            'App\\Controller\\SavedJobController:getSavedJobs' => ['privates', '.service_locator..6ULR9V', 'get_ServiceLocator__6ULR9VService', true],
            'App\\Controller\\SavedJobController:saveJobPost' => ['privates', '.service_locator.5H6T8FS', 'get_ServiceLocator_5H6T8FSService', true],
            'kernel:loadRoutes' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
            'kernel:registerContainerConfiguration' => ['privates', '.service_locator.y4_Zrx.', 'get_ServiceLocator_Y4Zrx_Service', true],
        ], [
            'App\\Controller\\ApplicationFormController::submit' => '?',
            'App\\Controller\\ForgetPasswordController::forgotPassword' => '?',
            'App\\Controller\\ForgetPasswordController::resetPasswordConfirm' => '?',
            'App\\Controller\\JobPostController::addJob' => '?',
            'App\\Controller\\JobPostController::deleteJob' => '?',
            'App\\Controller\\JobPostController::editJob' => '?',
            'App\\Controller\\JobPostController::getJobs' => '?',
            'App\\Controller\\JobPostController::searchJobs' => '?',
            'App\\Controller\\LoginController::login' => '?',
            'App\\Controller\\ProfileSettingController::getProfile' => '?',
            'App\\Controller\\ProfileSettingController::profile' => '?',
            'App\\Controller\\ProfileSettingController::profileImage' => '?',
            'App\\Controller\\RegistrationController::confirmEmail' => '?',
            'App\\Controller\\RegistrationController::register' => '?',
            'App\\Controller\\SavedJobController::getSavedJobs' => '?',
            'App\\Controller\\SavedJobController::saveJobPost' => '?',
            'App\\Kernel::loadRoutes' => '?',
            'App\\Kernel::registerContainerConfiguration' => '?',
            'kernel::loadRoutes' => '?',
            'kernel::registerContainerConfiguration' => '?',
            'App\\Controller\\ApplicationFormController:submit' => '?',
            'App\\Controller\\ForgetPasswordController:forgotPassword' => '?',
            'App\\Controller\\ForgetPasswordController:resetPasswordConfirm' => '?',
            'App\\Controller\\JobPostController:addJob' => '?',
            'App\\Controller\\JobPostController:deleteJob' => '?',
            'App\\Controller\\JobPostController:editJob' => '?',
            'App\\Controller\\JobPostController:getJobs' => '?',
            'App\\Controller\\JobPostController:searchJobs' => '?',
            'App\\Controller\\LoginController:login' => '?',
            'App\\Controller\\ProfileSettingController:getProfile' => '?',
            'App\\Controller\\ProfileSettingController:profile' => '?',
            'App\\Controller\\ProfileSettingController:profileImage' => '?',
            'App\\Controller\\RegistrationController:confirmEmail' => '?',
            'App\\Controller\\RegistrationController:register' => '?',
            'App\\Controller\\SavedJobController:getSavedJobs' => '?',
            'App\\Controller\\SavedJobController:saveJobPost' => '?',
            'kernel:loadRoutes' => '?',
            'kernel:registerContainerConfiguration' => '?',
        ]);
    }
}

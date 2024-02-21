<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/create' => [[['_route' => 'app_add_job', '_controller' => 'App\\Controller\\JobPostController::addJob'], null, ['POST' => 0], null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/forgot-password' => [[['_route' => 'app_forgot_password', '_controller' => 'App\\Controller\\ForgetPasswordController::forgotPassword'], null, ['POST' => 0], null, false, false, null]],
        '/reset-password-confirm' => [[['_route' => 'app_reset_password_confirm', '_controller' => 'App\\Controller\\ForgetPasswordController::resetPasswordConfirm'], null, ['POST' => 0], null, false, false, null]],
        '/getall' => [[['_route' => 'app_get_jobs', '_controller' => 'App\\Controller\\JobPostController::getJobs'], null, ['GET' => 0], null, false, false, null]],
        '/search' => [[['_route' => 'app_job_search', '_controller' => 'App\\Controller\\JobPostController::searchJobs'], null, ['GET' => 0], null, false, false, null]],
        '/login' => [[['_route' => 'app_auth_login', '_controller' => 'App\\Controller\\LoginController::login'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/logout' => [[['_route' => 'app_auth_logout', '_controller' => 'App\\Controller\\LoginController::logout'], null, ['POST' => 0], null, false, false, null]],
        '/settings/profile' => [
            [['_route' => 'app_settings_profile', '_controller' => 'App\\Controller\\ProfileSettingController::profile'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'app_settings_retrieve_profile', '_controller' => 'App\\Controller\\ProfileSettingController::getProfile'], null, ['GET' => 0], null, false, false, null],
        ],
        '/settings/profile-image' => [[['_route' => 'app_settings_profile_image', '_controller' => 'App\\Controller\\ProfileSettingController::profileImage'], null, ['POST' => 0], null, false, false, null]],
        '/register' => [[['_route' => 'api_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, ['POST' => 0], null, false, false, null]],
        '/confirm-email' => [[['_route' => 'api_confirm_email', '_controller' => 'App\\Controller\\RegistrationController::confirmEmail'], null, ['GET' => 0], null, false, false, null]],
        '/jobs/saved' => [[['_route' => 'get_saved_jobs', '_controller' => 'App\\Controller\\SavedJobController::getSavedJobs'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/submit/([^/]++)(*:185)'
                .'|/edit/([^/]++)(*:207)'
                .'|/delete/([^/]++)(*:231)'
                .'|/jobs/save/([^/]++)(*:258)'
                .'|/reset\\-password/([^/]++)(*:291)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        185 => [[['_route' => 'app_application_form_controller', '_controller' => 'App\\Controller\\ApplicationFormController::submit'], ['job'], ['POST' => 0], null, false, true, null]],
        207 => [[['_route' => 'app_edit_job_edit', '_controller' => 'App\\Controller\\JobPostController::editJob'], ['job'], ['PUT' => 0], null, false, true, null]],
        231 => [[['_route' => 'app_delete_job', '_controller' => 'App\\Controller\\JobPostController::deleteJob'], ['id'], ['DELETE' => 0], null, false, true, null]],
        258 => [[['_route' => 'save_job_post', '_controller' => 'App\\Controller\\SavedJobController::saveJobPost'], ['jobId'], ['POST' => 0], null, false, true, null]],
        291 => [
            [['_route' => 'reset_password', '_controller' => 'App\\Controller\\ForgetPasswordController:forgotPassword'], ['token'], ['GET' => 0, 'POST' => 1], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

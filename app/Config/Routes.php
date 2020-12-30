<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->add('/', 'Login::index', ['namespace' => '\App\Controllers\User']);
$routes->add('logout', 'Login::logout', ['namespace' => '\App\Controllers\User']);
$routes->add('user/dashboard/index', 'Dashboard::index', ['namespace' => 'App\Controllers\User']);
$routes->add('user/profile/index', 'Profile::index', ['namespace' => 'App\Controllers\User']);
$routes->add('user/billinghistory/index', 'Billinghistory::index', ['namespace' => 'App\Controllers\User']);
$routes->add('user/changeemail/index', 'Changeemail::index', ['namespace' => 'App\Controllers\User']);
$routes->add('user/changeemailconfirm/(:any)', 'Changeemail::confirmemail/$1', ['namespace' => 'App\Controllers\User']);
$routes->add('user/changepassword/index', 'Changepassword::index', ['namespace' => 'App\Controllers\User']);

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->group('accounts', ['namespace' => 'App\Controllers\Admin\Accounts'], function ($routes) {
        $routes->add('manage', 'Manage::index');
    });
    $routes->group('users', ['namespace' => 'App\Controllers\Admin\Users'], function ($routes) {
        $routes->add('manage', 'Manage::index');
    });
    $routes->group('plans', ['namespace' => 'App\Controllers\Admin\Plans'], function ($routes) {
        $routes->add('manage', 'Manage::index');
    });
    $routes->group('orders', ['namespace' => 'App\Controllers\Admin\Orders'], function ($routes) {
        $routes->add('manage', 'Manage::index');
    });
    $routes->group('discounts', ['namespace' => 'App\Controllers\Admin\Discounts'], function ($routes) {
        $routes->add('manage', 'Manage::index');
    });
    $routes->group('logs', ['namespace' => 'App\Controllers\Admin\Logs'], function ($routes) {
        $routes->add('manage', 'Manage::index');
    });
});

$routes->group('rest', ['namespace' => 'App\Controllers\Rest'], function ($routes) {
    $routes->add('login/login', 'Login::login', ['namespace' => 'App\Controllers\Rest\Common']);
    $routes->add('login/signup', 'Login::signup', ['namespace' => 'App\Controllers\Rest\Common']);

    $routes->group('user', ['namespace' => 'App\Controllers\Rest\User'], function ($routes) {
        $routes->group('task', ['namespace' => 'App\Controllers\Rest\User\Tasks'], function ($routes) {
            $routes->add('create', 'Task::create');
            $routes->add('get', 'Task::get');
            $routes->add('details', 'Task::details');
            $routes->add('delete', 'Task::delete');
            $routes->add('stop', 'Task::stop');
            $routes->add('export', 'Task::export');
            $routes->add('autocomplete', 'Helpers::autocomplete');
        });
        $routes->group('orders', ['namespace' => 'App\Controllers\Rest\User\Orders'], function ($routes) {
            $routes->add('create', 'Order::create');
            $routes->add('discount', 'Order::discount');
            $routes->add('prepare', 'Order::prepare');
        });
    });

    $routes->group('admin', ['namespace' => 'App\Controllers\Rest\Admin'], function ($routes) {
        $routes->group('accounts', ['namespace' => 'App\Controllers\Rest\Admin\Accounts'], function ($routes) {
            $routes->add('get', 'Account::get');
            $routes->add('upload', 'Account::upload');
            $routes->add('delete', 'Account::delete');
            $routes->add('verify', 'Account::verify');
        });
        $routes->group('users', ['namespace' => 'App\Controllers\Rest\Admin\Users'], function ($routes) {
            $routes->add('get', 'User::get');
            $routes->add('create', 'User::create');
            $routes->add('edit', 'User::edit');
            $routes->add('delete', 'User::delete');
        });
        $routes->group('plans', ['namespace' => 'App\Controllers\Rest\Admin\Plans'], function ($routes) {
            $routes->add('get', 'Plan::get');
            $routes->add('create', 'Plan::create');
            $routes->add('edit', 'Plan::edit');
            $routes->add('delete', 'Plan::delete');
        });
        $routes->group('orders', ['namespace' => 'App\Controllers\Rest\Admin\Orders'], function ($routes) {
            $routes->add('get', 'Order::get');
            $routes->add('statistics', 'Order::statistics');
            $routes->add('extra', 'Order::extra');
        });
        $routes->group('discounts', ['namespace' => 'App\Controllers\Rest\Admin\Discounts'], function ($routes) {
            $routes->add('get', 'Discount::get');
            $routes->add('create', 'Discount::create');
            $routes->add('edit', 'Discount::edit');
            $routes->add('delete', 'Discount::delete');
        });
        $routes->group('logs', ['namespace' => 'App\Controllers\Rest\Admin\Logs'], function ($routes) {
            $routes->add('get', 'Log::get');
        });
    });

    $routes->group('tasks', ['namespace' => 'App\Controllers\Rest\Tasks'], function ($routes) {
        $routes->group('task', function ($routes) {
            // Scrap Username Routes
            $routes->add('username_followers', 'Task::username_followers');
            $routes->add('username_followings', 'Task::username_followings');
            $routes->add('username_posts', 'Task::username_posts');
            $routes->add('username_likes', 'Task::username_likes');
            $routes->add('username_comments', 'Task::username_comments');

            // Scrap Hashtag routes
            $routes->add('hashtag_posts', 'Task::hashtag_posts');
            $routes->add('hashtag_comments', 'Task::hashtag_comments');
            $routes->add('hashtag_likes', 'Task::hashtag_likes');

            // Scrap Location routes
            $routes->add('location_posts', 'Task::location_posts');
            $routes->add('location_comments', 'Task::location_comments');
            $routes->add('location_likes', 'Task::location_likes');

            // Scrap Post routes
            $routes->add('post_comments', 'Task::post_comments');
            $routes->add('post_likes', 'Task::post_likes');
        });

        $routes->add('profiles', 'Profiles::execute');
    });
});

$routes->group('webhook', ['namespace' => 'App\Controllers\Webhook'], function ($routes) {
    $routes->group('coins', ['namespace' => 'App\Controllers\Webhook\Coinpayments'], function ($routes) {
        $routes->add('trigger', 'Event::trigger');
    });
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

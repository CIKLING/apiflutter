<?php
use App\Http\Controllers\MasterController;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Login Auth
$router->group(['prefix' => 'autentikasi'], function () use ($router) {
    $router->post('/login', ['uses' => 'LoginController@sign_in']);
    $router->post('/register', ['uses' => 'LoginController@signUp']);
});

// MASTER
$router->group(['prefix' => 'master'], function () use ($router) {
    $router->get('/', ['uses' => 'MasterController@index']);
    $router->get('kecamatan', ['uses' => 'MasterController@kecamatan']);
    $router->post('kelurahan', ['uses' => 'MasterController@kelurahan']);
    // $router->get('/users', ['uses' => 'MasterController@getUsers']);
});

// PERMOHONAN
$router->group(['prefix' => 'permohonan'], function () use ($router) {
    $router->get('list/{email}', ['uses' => 'PermohonanController@list']);
});


// AKUN
$router->group(['prefix' => 'akun'], function () use ($router) {
    $router->get('/', ['uses' => 'AkunController@index']);
    $router->get('getUser', ['uses' => 'AkunController@getUser']);
    $router->post('sync', ['uses' => 'AkunController@sync']);
    $router->post('verifikasi', ['uses' => 'AkunController@verifikasi']);
});

// KTP
$router->group(['prefix' => 'ktp'], function () use ($router) {
    $router->get('/', ['uses' => 'KtpController@index']);
    $router->get('layanan', ['uses' => 'KtpController@layanan']);
    $router->post('create', ['uses' => 'KtpController@create']);
});

// KIA
$router->group(['prefix' => 'kia'], function () use ($router) {
    $router->get('/', ['uses' => 'KiaController@index']);
    $router->get('layanan', ['uses' => 'KiaController@layanan']);
    $router->post('create', ['uses' => 'KiaController@create']);
});

// Akta Kelahiran
$router->group(['prefix' => 'akta_kelahiran'], function () use ($router) {
    $router->get('/', ['uses' => 'AktaKelahiranController@index']);
    $router->get('layanan', ['uses' => 'AktaKelahiranController@layanan']);
    $router->post('create', ['uses' => 'AktaKelahiranController@create']);
});

// DISABILITAS
$router->group(['prefix' => 'disabilitas'], function () use ($router) {
    $router->get('/', ['uses' => 'DisabilitasController@index']);
    $router->get('layanan', ['uses' => 'DisabilitasController@layanan']);
    $router->post('create', ['uses' => 'DisabilitasController@create']);
});
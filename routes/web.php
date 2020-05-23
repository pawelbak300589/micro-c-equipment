<?php

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

$router->get('/', function () use ($router)
{
    return $router->app->version();
});

//$router->group(['middleware' => 'auth'], function () use ($router)
//{
    $router->group(['prefix' => 'api'], function () use ($router)
    {
        $router->get('brands/test', ['uses' => 'BrandController@test']);

        $router->get('brands', ['uses' => 'BrandController@showAllBrands']);
        $router->get('brands/{id}', ['uses' => 'BrandController@showOneBrand']);
        $router->post('brands', ['uses' => 'BrandController@create']);
        $router->delete('brands/{id}', ['uses' => 'BrandController@delete']);
        $router->patch('brands/{id}', ['uses' => 'BrandController@update']);
        $router->post('brands/{id}/blacklist', ['uses' => 'BrandController@blacklist']);
        $router->post('brands/{id}/convert/{$type}/{$parentId}', ['uses' => 'BrandController@convert']);

        $router->get('gears', ['uses' => 'GearController@showAllGears']);
        $router->get('gears/{id}', ['uses' => 'GearController@showOneGear']);
        $router->post('gears', ['uses' => 'GearController@create']);
        $router->delete('gears/{id}', ['uses' => 'GearController@delete']);
        $router->patch('gears/{id}', ['uses' => 'GearController@update']);

        $router->get('categories', ['uses' => 'CategoryController@showAllCategories']);
        $router->get('categories/{id}', ['uses' => 'CategoryController@showOneCategory']);
        $router->post('categories', ['uses' => 'CategoryController@create']);
        $router->delete('categories/{id}', ['uses' => 'CategoryController@delete']);
        $router->patch('categories/{id}', ['uses' => 'CategoryController@update']);
    });
//});

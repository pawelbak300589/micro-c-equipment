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

    $router->get('brands', ['uses' => 'BrandController@index']);
    $router->get('brands/{id}', ['uses' => 'BrandController@show']);
    $router->post('brands', ['uses' => 'BrandController@store']);
    $router->patch('brands/{id}', ['uses' => 'BrandController@update']);
    $router->delete('brands/{id}', ['uses' => 'BrandController@delete']);
    $router->post('brands/{id}/blacklist', ['uses' => 'BrandController@blacklist']);
    $router->post('brands/{id}/convert/{type}/{parentId}', ['uses' => 'BrandController@convert']);

    $router->get('brands/{brandId}/mappings', ['uses' => 'BrandMappingsController@index']);
    $router->post('brands/{brandId}/mappings', ['uses' => 'BrandMappingsController@store']);
    $router->get('brands/{brandId}/mappings/{mappingId}', ['uses' => 'BrandMappingsController@show']);
    $router->patch('brands/{brandId}/mappings/{mappingId}', ['uses' => 'BrandMappingsController@update']);
    $router->delete('brands/{brandId}/mappings/{mappingId}', ['uses' => 'BrandMappingsController@delete']);

    $router->get('brands/{brandId}/images', ['uses' => 'BrandImagesController@index']);
    $router->post('brands/{brandId}/images', ['uses' => 'BrandImagesController@store']);
    $router->get('brands/{brandId}/images/{imageId}', ['uses' => 'BrandImagesController@show']);
    $router->patch('brands/{brandId}/images/{imageId}', ['uses' => 'BrandImagesController@update']);
    $router->delete('brands/{brandId}/images/{imageId}', ['uses' => 'BrandImagesController@delete']);

    $router->get('gears', ['uses' => 'GearController@showAllGears']);
    $router->get('gears/{id}', ['uses' => 'GearController@showOneGear']);
    $router->post('gears', ['uses' => 'GearController@store']);
    $router->patch('gears/{id}', ['uses' => 'GearController@update']);
    $router->delete('gears/{id}', ['uses' => 'GearController@delete']);

    $router->get('categories', ['uses' => 'CategoryController@showAllCategories']);
    $router->get('categories/{id}', ['uses' => 'CategoryController@showOneCategory']);
    $router->post('categories', ['uses' => 'CategoryController@store']);
    $router->patch('categories/{id}', ['uses' => 'CategoryController@update']);
    $router->delete('categories/{id}', ['uses' => 'CategoryController@delete']);
});
//});

<?php

namespace Gwaps4nlp\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Config;

class CoreServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'gwaps4nlp-core');
        
        $migrationPath = __DIR__.'/../database/migrations';
        $this->loadMigrationsFrom($migrationPath);
        
        $config =  [
            'middleware' => ['web','auth','admin'],
        ];
        $config['namespace'] = 'Gwaps4nlp';
        $config['prefix'] = 'constant-game';

        $router->group($config, function($router)
        {
            $router->get('/index', 'ConstantGameController@getIndex');
            $router->get('/edit/{constant}', 'ConstantGameController@getEdit');
            $router->post('/edit/{constant}', 'ConstantGameController@postEdit');
        });

        $config['prefix'] = 'trophy';

        $router->group($config, function($router)
        {
            $router->get('/index', 'TrophyController@getIndex');
            $router->get('/edit', 'TrophyController@getEdit');
            $router->post('/edit', 'TrophyController@postEdit');
            $router->get('/create', 'TrophyController@getCreate');
            $router->post('/create', 'TrophyController@postCreate');         
        });

        $config['prefix'] = 'game';
        $config['middleware'] = ['web','auth'];

        $router->group($config, function($router)
        {
            $router->get('/{mode}/jsonContent', 'GameController@jsonContent');
            $router->get('/{mode}/begin/{id}', 'GameController@begin');
            $router->post('/{mode}/answer', 'GameController@answer');
        });
    }    

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
 
}

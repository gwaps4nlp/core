<?php

namespace Gwaps4nlp\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Config;

class GameServiceProvider extends ServiceProvider
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

        $config =  [
            'middleware' => ['web'],
        ];
        $config['namespace'] = 'Gwaps4nlp\Core';
        $config['prefix'] = 'constant-game';

        $router->group($config, function($router)
        {
            $router->get('/index', 'ConstantGameController@getIndex');
            // $router->get('/edit/{constant}', 'ConstantGameController@getEdit');
            // $router->post('/edit/{constant}', 'ConstantGameController@postEdit');
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
    }    

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $game_mode = $this->app['request']->segment(2);
        $game_modes = Config::get('game.modes');
        $className = (array_key_exists($game_mode,$game_modes))?Config::get("game.modes.".$game_mode.".class_name"):'Game';
        $serviceName = 'App\Services\\'.$className.'Gestion';
        $this->app->bind('Gwaps4nlp\Core\GameGestionInterface', $serviceName);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Gwaps4nlp\Core\GameGestionInterface'];
    }
 
}

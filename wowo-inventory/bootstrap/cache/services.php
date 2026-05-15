<?php return array (
  'providers' => 
  array (
    0 => 'Laravel\\Breeze\\BreezeServiceProvider',
    1 => 'Laravel\\Sail\\SailServiceProvider',
    2 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    3 => 'Laravel\\Tinker\\TinkerServiceProvider',
    4 => 'Carbon\\Laravel\\ServiceProvider',
    5 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    6 => 'Termwind\\Laravel\\TermwindServiceProvider',
    7 => 'App\\Providers\\AppServiceProvider',
    8 => 'App\\Providers\\AuthServiceProvider',
    9 => 'App\\Providers\\EventServiceProvider',
    10 => 'App\\Providers\\RouteServiceProvider',
  ),
  'eager' => 
  array (
    0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    1 => 'Carbon\\Laravel\\ServiceProvider',
    2 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    3 => 'Termwind\\Laravel\\TermwindServiceProvider',
    4 => 'App\\Providers\\AppServiceProvider',
    5 => 'App\\Providers\\AuthServiceProvider',
    6 => 'App\\Providers\\EventServiceProvider',
    7 => 'App\\Providers\\RouteServiceProvider',
  ),
  'deferred' => 
  array (
    'Laravel\\Breeze\\Console\\InstallCommand' => 'Laravel\\Breeze\\BreezeServiceProvider',
    'Laravel\\Sail\\Console\\InstallCommand' => 'Laravel\\Sail\\SailServiceProvider',
    'Laravel\\Sail\\Console\\PublishCommand' => 'Laravel\\Sail\\SailServiceProvider',
    'command.tinker' => 'Laravel\\Tinker\\TinkerServiceProvider',
  ),
  'when' => 
  array (
    'Laravel\\Breeze\\BreezeServiceProvider' => 
    array (
    ),
    'Laravel\\Sail\\SailServiceProvider' => 
    array (
    ),
    'Laravel\\Tinker\\TinkerServiceProvider' => 
    array (
    ),
  ),
);
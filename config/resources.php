<?php

return [
    'users' => [
        'entityType'    => '\App\Resources\Entities\User',
        'viewNamespace' => 'app.resources.users',
        'routePath'     => '/users',
        'requestClass'  => '\App\Resources\Requests\UsersRequest'
    ],

];

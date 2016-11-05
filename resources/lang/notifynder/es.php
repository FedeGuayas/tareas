<?php

return [

   
    'user' => [
        'follow' => 'Hello {to.name}, {from.name} is now following you and want to let you know "{extra.message}".',
        'like' => '{from.name} has liked your {extra.post_type}.',
    ],
    'admin' => [
        'new_user' => 'A new user has registered in your application - {from.name}<{from.email}>.',
    ],

];

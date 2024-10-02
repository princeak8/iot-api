<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('channel1.{id}', function($user, $id) {
//     return $id === 1;
// });


// Broadcast::channel('eerc_disco_street-transformer_{location}_{group}', function ($user, $location, $group) {
//     // You can access location and group as variables, and use them in determining authorization
//     return true; // Or implement your authorization logic here
// });

Broadcast::channel('{any}', function ($user, $any) {
    return true; // Accept all channels
});

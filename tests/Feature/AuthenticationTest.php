<?php

use App\Models\User;

use function Pest\Laravel\{post};

it('create a new user', function () {
    $user = [
        "name" => "PHP test",
        "email" => "phpteste@test.com",
        "password" => "123456789",
        "password_confirmation" => "123456789"
    ];
    post(route("user.register", $user))->assertStatus(201);
});

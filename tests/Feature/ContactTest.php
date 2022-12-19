<?php

use App\Models\User;
use App\Models\UserContact;

test('show user contacts', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route("contact.index"));

    $response->assertSuccessful();
    
    expect($response)->assertStatus(200);
});

it("it shoud be create a contact", function(){
    $user = User::factory()->create();

    $contactPost = [
        "user_id" => $user->id,
        "name" => fake()->name, 
        "document_number" => fake("pt_BR")->unique()->cpf(false),
        "phone_number" => fake("pt_BR")->cellphoneNumber,
        "street" => fake()->streetName(),
        "street_number" => fake()->numberBetween(0,100),
        "neighborhood" => 'teste',
        "city" => fake()->city(),
        "state" => fake()->state(),
        "latitude" => fake()->latitude(),
        "longitude" => fake()->longitude(),
    ];

    $response = $this->actingAs($user)
        ->post(route("contact.store"), $contactPost);

        expect($response)->assertStatus(201);
});

it("shoud be delete a contact", function(){
    $user = User::factory()->create();

    $contact = UserContact::factory()->create(["user_id" => $user->id]);

    $response = $this->actingAs($user)->delete(route("contact.delete", $contact));

    expect($response)->assertStatus(200);

});

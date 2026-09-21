<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers an owner', function () {
    $response = $this->postJson('/api/v1/register', [
        'name'=>'Test Owner',
        'email'=>'test@example.com',
        'password'=>'password',
        'password_confirmation'=>'password',
    ]);

    $response->assertCreated()->assertJsonStructure(['user','token']);
    expect(User::where('email','test@example.com')->exists())->toBeTrue();
});

<?php

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('prevents one owner from reading another owner pet', function () {
    $a = User::factory()->create(['role'=>'owner']);
    $b = User::factory()->create(['role'=>'owner']);
    $pet = Pet::create(['user_id'=>$a->id,'name'=>'Milo','species'=>'Dog']);

    $this->actingAs($b)->getJson("/api/v1/pets/{$pet->id}")->assertForbidden();
});

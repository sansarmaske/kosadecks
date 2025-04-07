<?php

use Tests\TestCase;

use App\Models\Expense;
use App\Models\User;
use App\Models\Category;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\GroupInvite;

uses(TestCase::class, RefreshDatabase::class);


test('user can create group', function () {
    $user = User::factory()->create();
    $group = Group::factory()->create([
        'user_id' => $user->id
    ]);
    expect($group->user_id)->toBe($user->id);
});


test('user can invite other user to group', function () {
    $from_user = User::factory()->create();
    $to_user = User::factory()->create();
    $group = Group::factory()->create([
        'user_id' => $from_user->id
    ]);
    GroupInvite::factory()->create([
        'group_id' => $group->id,
        'from_user_id' => $from_user->id,
        'to_user_id' => $to_user->id,

    ]);

    $this->assertDatabaseHas('group_invites', [
        'group_id' => $group->id,
        'from_user_id' => $from_user->id,
        'to_user_id' => $to_user->id,
        'status' => 'pending'
    ]);

});

test('user cannot invite other user to group they dont belong to', function () {
    $nonMember = User::factory()->create();
    $to_user = User::factory()->create();
    $group = Group::factory()->create();

    $this->actingAs($nonMember);

    $response = $this->post('groups/' . $group->id . '/invite', [
        'user_id' => $to_user->id
    ]);

    $response->assertStatus(403);

    $this->assertDatabaseMissing('group_invites', [
        'group_id' => $group->id,
        'to_user_id' => $to_user->id
    ]);
});

 //todo: exception is thrown when invite sent to the user who is already invited

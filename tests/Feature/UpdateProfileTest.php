<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProfileTest extends TestCase
{
     use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Fake the storage disk for image uploads
        Storage::fake('public');
    }

    /** @test */
    public function user_can_update_basic_profile_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('user.update.profile'), [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'phone'      => '0712345678',
            'gender'     => 'Male',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Profile updated successfully!');

        $this->assertDatabaseHas('users', [
            'id'         => $user->id,
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'phone'      => '0712345678',
            'gender'     => 'Male',
        ]);
    }

    /** @test */
    public function user_cannot_update_password_with_wrong_old_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct_password'),
        ]);

        $response = $this->actingAs($user)->post(route('user.update.profile'), [
            'first_name'    => 'Jane',
            'last_name'     => 'Smith',
            'phone'         => '0711222333',
            'old_password'  => 'wrong_password',
            'new_password'  => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors(['old_password']);
    }

    /** @test */
    public function user_can_update_password_with_correct_old_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user)->post(route('user.update.profile'), [
            'first_name'    => 'Jane',
            'last_name'     => 'Smith',
            'phone'         => '0711222333',
            'old_password'  => 'oldpassword123',
            'new_password'  => 'newpassword456',
            'new_password_confirmation' => 'newpassword456',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Profile updated successfully!');

        $this->assertTrue(Hash::check('newpassword456', $user->fresh()->password));
    }

    /** @test */
    // public function user_can_update_profile_picture()
    // {
    //     $user = User::factory()->create();

    //     // Simulate a base64 image
    //     $image = base64_encode(file_get_contents(
    //         UploadedFile::fake()->image('avatar.png')->path()
    //     ));
    //     $base64String = 'data:image/png;base64,' . $image;

    //     $response = $this->actingAs($user)->post(route('user.update.profile'), [
    //         'first_name'    => 'John',
    //         'last_name'     => 'Doe',
    //         'phone'         => '0712345678',
    //         'profile_image' => $base64String,
    //     ]);

    //     $response->assertRedirect();
    //     $response->assertSessionHas('success', 'Profile updated successfully!');

    //     $this->assertNotNull($user->fresh()->profile_image);

    //     // Ensure file was stored in correct directory (if you set one)
    //     // Storage::disk('public')->assertExists('images/userImage/' . $user->fresh()->profile_image);
    // }
}

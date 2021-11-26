<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vulnerability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_app()
    {
        $user = User
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response
            ->assertOk();
    }

    /**
     * @return void
     */
    public function test_index_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->get('/vulnerabilities');

        $response
            ->assertOk()
            ->assertSeeText('Index');
    }

    /**
     * @return void
     */
    public function test_create_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->get('/vulnerabilities/create');

        $response
            ->assertOk()
            ->assertSeeText('Create')
            ->assertSeeText('Title')
            ->assertSeeText('Description')
            ->assertSeeText('Store');
    }

    /**
     * @return void
     */
    public function test_store_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->post('/vulnerabilities', [
                'title' => 'CVE-10 Critical Patching',
                'description' => 'You should update your Wordpress base code to the version 7.4.3',
            ]);

        $response
            ->assertRedirect();

        $this
            ->assertDatabaseHas('vulnerabilities', [
                'title' => 'CVE-10 Critical Patching',
                'description' => 'You should update your Wordpress base code to the version 7.4.3',
            ]);
    }

    /**
     * @return void
     */
    public function test_cant_store_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->post('/vulnerabilities', [
                'title' => 'CVE-11 Uploading Directory',
            ]);

        $response
            ->assertSessionHasErrors('description');
    }

    /**
     * @return void
     */
    public function test_show_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $vulnerability = Vulnerability
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->get('/vulnerabilities/' . $vulnerability->id);

        $response
            ->assertOk()
            ->assertSeeText('Show');
    }

    /**
     * @return void
     */
    public function test_edit_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $vulnerability = Vulnerability
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->get('/vulnerabilities/' . $vulnerability->id . '/edit');

        $response
            ->assertOk()
            ->assertSeeText('Edit')
            ->assertSeeText('Title')
            ->assertSeeText('Description')
            ->assertSeeText('Update');
    }

    /**
     * @return void
     */
    public function test_update_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $vulnerability = Vulnerability
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->put('/vulnerabilities/' . $vulnerability->id, [
                'title' => 'CVE-12 Linux Kernel Patch',
            ]);

        $response
            ->assertRedirect();

        $this
            ->assertDatabaseHas('vulnerabilities', [
                'id' => $vulnerability->id,
                'title' => 'CVE-12 Linux Kernel Patch',
            ]);
    }

    /**
     * @return void
     */
    public function test_destroy_vulnerabilities()
    {
        $user = User
            ::factory()
            ->create();

        $vulnerability = Vulnerability
            ::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->delete('/vulnerabilities/' . $vulnerability->id);

        $response
            ->assertRedirect();

        $this
            ->assertDatabaseMissing('vulnerabilities', [
                'id' => $vulnerability->id,
            ]);
    }
}

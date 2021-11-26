<?php

namespace Tests\Feature;

use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExtractTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_command()
    {
        $this
            ->artisan('owasp:extract')
            ->assertExitCode(Command::SUCCESS);

        $this
            ->assertDatabaseCount('vulnerabilities', 10);
    }
}

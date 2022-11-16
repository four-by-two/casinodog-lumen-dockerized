<?php

namespace App\Domain\Users\Tests\Feature;

use App\Domain\Users\Entities\User;
use App\Domain\Users\Listeners\PasswordResetListener;
use Illuminate\Auth\Events\PasswordReset;
use Tests\TestCase;

class PasswordResetListenerTest extends TestCase
{
    private PasswordResetListener $passwordResetListener;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->passwordResetListener = $this->app->make(PasswordResetListener::class);
        $this->user = User::factory()->create();
    }

    public function testHandle()
    {
        $oldToken = $this->user->email_token_confirmation;
        $this->passwordResetListener->handle(new PasswordReset($this->user));
        $this->user->refresh();
        $this->assertNotEquals($oldToken, $this->user->email_token_confirmation);
    }
}

<?php


namespace Bambamboole\LaravelCms\Tests\Feature\Api\Profile;


use Bambamboole\LaravelCms\Tests\ApiTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProfileAvatarTest extends ApiTestCase
{
    /** @test */
    public function the_avatar_can_be_updated()
    {
        Storage::fake();
        $user = $this->login();
        $this->assertNull($user->getRawOriginal('avatar'));

        $response = $this->post('/api/cms/profile/avatar',[
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        $response->assertOk();
        $this->assertNotNull($user->fresh()->getRawOriginal('avatar'));
    }

}

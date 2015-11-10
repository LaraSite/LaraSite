<?php

namespace Test\Unit\Http;

use Illuminate\Auth\GenericUser;
use Mockery as m;

class RoutesControllerTest extends \TestCase
{
    public function testRoot()
    {
        $this->get('/');

        $this->assertResponseOk();
    }

    public function testCatchAllSuccess()
    {
        $this->get('contact');

        $this->assertResponseOk();
        $this->see('LaraSite');
    }

    public function testCatchAllFalse()
    {
        $response = $this->call('GET', 'foo');

        $this->assertEquals(404, $response->status());
    }

    public function testBasicAuthSuccess()
    {
        \Config::set('auth_user.users', [
            'admin' => 'admin123',
        ]);
        $user = factory(GenericUser::class)->make();
        $this->actingAs($user);

        $this->get('admin');

        $this->assertRedirectedTo('/admin/articles');
    }

    public function testBasicAuthFails()
    {
        $this->get('admin');

        $this->assertEquals(401, $this->response->getStatusCode());
    }
}

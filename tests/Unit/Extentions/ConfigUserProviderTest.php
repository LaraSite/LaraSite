<?php

namespace Test\Unit\Extentions;

use Mockery as m;
use App\Extentions\ConfigUserProvider;

class ConfigUserProviderTest extends \TestCase
{
    /** @var  ConfigUserProvider */
    protected $provider;

    public function setUp()
    {
        parent::setUp();

        \Config::set('auth_user.users', [
            'foo' => 'foo123',
            'bar' => 'bar123',
        ]);

        $this->provider = new ConfigUserProvider();
    }

    public function testRetrieveById()
    {
        $user = $this->provider->retrieveById('foo');

        $this->assertEquals('foo', $user->id);
        $this->assertEquals('foo', $user->username);
        $this->assertEquals('foo123', $user->password);
    }

    public function testRetrieveByIdWithInvalidId()
    {
        $user = $this->provider->retrieveById('baz');

        $this->assertEquals(null, $user);
    }

    /**
     * @expectedException Exception
     */
    public function testRetrieveByToken()
    {
        $this->provider->retrieveByToken('foo', 'some_token');
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateRememberToken()
    {

        $user = $this->provider->retrieveById('foo');

        $this->provider->updateRememberToken($user, 'some_token');
    }

    public function testRetrieveByCredentials()
    {
        $user = $this->provider->retrieveByCredentials(['email' => 'bar']);

        $this->assertEquals('bar', $user->username);
    }

    public function testRetrieveByCredentialsWithInvalidCredentials()
    {
        $user = $this->provider->retrieveByCredentials(['email' => 'baz']);
        $this->assertEquals(null, $user);

        $user = $this->provider->retrieveByCredentials(['username' => 'baz']);
        $this->assertEquals(null, $user);
    }

    public function testValidateCredentials()
    {
        $user = $this->provider->retrieveByCredentials(['email' => 'bar']);

        $result = $this->provider->validateCredentials($user, ['password' => 'bar123']);
        $this->assertEquals(true, $result);

        $result = $this->provider->validateCredentials($user, ['password' => 'bar456']);
        $this->assertEquals(false, $result);

        $result = $this->provider->validateCredentials($user, ['invalid_key' => 'bar123']);
        $this->assertEquals(false, $result);
    }
}

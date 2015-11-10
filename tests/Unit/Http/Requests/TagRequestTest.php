<?php

namespace Test\Unit\Http\Request;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Tag;
use Mockery as m;

class TagRequestTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testValidationWithValidData()
    {
        $input = ['name' => 'foo'];

        $this->mock(Tag::class);
        $this->mock->shouldReceive('create')->once()->with($input);

        $response = $this->call('POST', route('admin.tags.store'), $input);

        $this->assertRedirectedToRoute('admin.tags.index');
    }

    public function testValidationWithoutName()
    {
        $input = ['name' => ''];

        $response = $this->call('POST', route('admin.tags.store'), $input);

        $this->assertSessionHasErrors('name');
        $this->assertTrue($response->isRedirect());
    }
}

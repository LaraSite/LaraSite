<?php

namespace Test\Unit\Http\Request;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Category;
use Mockery as m;

class CategoryRequestTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testValidationWithValidData()
    {
        $input = ['name' => 'foo'];
        $this->mock(Category::class);
        $this->mock->shouldReceive('create')->once()->with($input);

        $response = $this->call('POST', route('admin.categories.store'), $input);

        $this->assertRedirectedToRoute('admin.categories.index');
    }

    public function testValidationWithoutName()
    {
        $input = ['name' => ''];

        $response = $this->call('POST', route('admin.categories.store'), $input);

        $this->assertSessionHasErrors('name');
        $this->assertTrue($response->isRedirect());
    }
}

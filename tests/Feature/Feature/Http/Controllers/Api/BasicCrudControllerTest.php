<?php

namespace Tests\Feature\Feature\Http\Controllers\Api;

use Tests\Stubs\Controllers\CategoryControllerStubs;
use Tests\Stubs\Models\CategoryStubs;
use Tests\TestCase;

class BasicCrudControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        CategoryStubs::dropTable();
        CategoryStubs::createTable();

    }

    protected function tearDown(): void
    {
        CategoryStubs::dropTable();
        parent::tearDown();
    }

    public function testBasicControllerIndex() {
        $category = CategoryStubs::create(['name' => 'test_name', 'description' => 'testDescription']);
        $controller = new CategoryControllerStubs();
        $this->assertEquals([$category->toarray()]

            , $controller->index()->toArray());
    }
}

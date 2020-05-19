<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillable()
    {
        $fillable = [
            'name',
            'description',
            'is_active'
        ];
        $category = new Category();
        $this->assertEquals($fillable, $category->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testCasts()
    {
        $casts = [
            'id' => 'string',
            'is_active' => 'boolean'
        ];
        $category = new Category();
        $this->assertEquals($casts, $category->getCasts());
    }

    public function testDates()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $category = new Category();
        foreach ($dates as $date) {
            $this->assertContains($date, $category->getDates());
        }

        $this->assertCount(count($dates), $category->getDates());
    }

    public function testIncrementing()
    {
        $category = new Category();
        $this->assertFalse($category->incrementing);
    }
}

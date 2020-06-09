<?php

namespace Tests\Feature\Feature\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidation;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidation, TestSaves;

    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('categories.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->category->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('categories.show', ['category' => $this->category->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->category->toArray());
    }

    public function testInvalidationData()
    {

        $this->assertInvalidationInStoreAction(['name' => ''], 'required');
        $this->assertInvalidationInUpdateAction(['name' => ''], 'required');

        $this->assertInvalidationInStoreAction(['name' => str_repeat('a',256)], 'max.string', ['max' => 255]);
        $this->assertInvalidationInUpdateAction(['name' => str_repeat('a',256)], 'max.string', ['max' => 255]);

        $this->assertInvalidationInStoreAction(['is_active' => 'a'], 'boolean');
        $this->assertInvalidationInUpdateAction(['is_active' => 'a'], 'boolean');
    }

    public function testStore()
    {
        $data = ['name' => 'test'];
        $this->assertStore($data,$data + ['description' => null, 'is_active' => true, 'deleted_at' => null]);

    }

    public function testUpdate()
    {
        $this->category = factory(Category::class)->create([
            'is_active' => false,
            'description' => 'description'
        ]);

        $data = [
            'name' => 'test',
            'description' => 'test',
            'is_active' => true,
        ];

        $this->assertUpdate($data, $data + ['deleted_at' => null]);

        /*$id = $response->json('id');
        $category = Category::find($id);

        $response->assertStatus(200)
            ->assertJson($category->toArray())
            ->assertJsonFragment([
                'is_active' => true,
                'description' => 'test'
            ]);*/
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE', route('categories.destroy', ['category' => $this->category->id]));
        $response->assertStatus(204);
        $this->assertNull(Category::find($this->category->id));
        $this->assertNotNull(Category::withTrashed()->find($this->category->id));
    }

    protected function routeStore(){
        return route('categories.store');
    }

    protected function routeUpdate(){
        return route('categories.update', ['category' => $this->category->id]);
    }

    protected function model(){
        return Category::class;
    }
}

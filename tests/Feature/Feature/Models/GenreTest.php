<?php

namespace Tests\Feature\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testList()
    {
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $genreKeys = array_keys($genres->first()->getAttributes());
        $this->assertCount(1, $genres);
        $this->assertEqualsCanonicalizing([
            'id',
            'name',
            'is_active',
            'created_at',
            'updated_at',
            'deleted_at'
        ],
            $genreKeys);

    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test'
        ]);
        $genre->refresh();
        $this->assertEqualsCanonicalizing('test', $genre->name);
        $this->assertNull($genre->description);
        $this->assertTrue((bool) $genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ]);
        $data = [
            'name' => 'test_name_updated',
            'is_active' => true
        ];
        $genre->update($data);

        foreach ($data as $key => $value){
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();
        $genre->delete();
        $this->assertNull(Genre::find($genre->id));

        $genre->restore();
        $this->assertNotNull(Genre::find($genre->id));
    }
}

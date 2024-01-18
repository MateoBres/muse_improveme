<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClassesStore extends TestCase
{
    use WithFaker;

    /** @test */
    public function itShowsValidationError()
    {
        $response = $this->post(route('admin.classes.store'), []);
        $response->assertStatus(302);

        $view = $this->withViewErrors([
            'title' => ['The title field is required.'],
            'description' => ['The description field is required.'],
        ])->view('admin.classes.create');

        $view->assertSee('The title field is required.');
        $view->assertSee('The description field is required.');
    }

    /**
     * @test
     * @param $input
     * @param $value
     *
     * @dataProvider storeData
     *
     * @return void
     */
    public function itShowsErrorsWithWrongData($input, $value) {
        $response = $this->post(route('admin.classes.store'), [
            $input => $value
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function itCreatesANewClass()
    {
        $response = $this->post(route('admin.classes.store'), $data = [
            'title' => 'foo',
            'description' => 'Lorem ipsum dolor sit amet',
            'active' => true
        ]);

        $response->assertStatus(200);
        $response->assertSee($data['title']);
        $response->assertSee($data['description']);
        $response->assertSee($data['active'] ? 'SI' : 'NO');
    }

    public function storeData() {
        return [
            ['title', 1],
            ['title', false],
            ['title', 'f'],
            ['title', 'fo'],
            ['title', 'kHnKEMPhqqeoMdh7OAd1w0I8ld0ndJkbSDG8z0zsgSozpm6wsVbxtrJHLaXvf73OBLCBlar3eQJEGhWs0qSjBOvkYZLCopNLZ7e13mTQ7ytxpGzQwYTMtJiJSGWD04TRvwtcWTnIGLJCknAurslnbGOpV6UZwvUlULkNehNJe81tx3ZBEwyJBNUvruOgsrsDdjVsDvwS80xFzvpejmjUfqQCahbs380s0PLoa2BYpltvo0gVgeN7f0YGRDXh1sOD'],
        ];
    }
}

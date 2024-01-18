<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class ClassesIndex extends TestCase
{
    /** @test */
    public function itListsNoClasses()
    {
        $response = $this->get(route('admin.classes.index'));

        $response->assertOk();
        $response->assertSee('Spiacenti! Nessun corso');
    }

    /** @test */
    public function itListsClasses()
    {
        collect([
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'active' => true,
                'created_at' => now()
            ],
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'active' => true,
                'created_at' => now()
            ],
        ]);

        // TODO: Questo test deve dimostrare che un controller che trova corsi ritorna un array di 10 elementi.
    }

    /** @test */
    public function itListsPaginatedClasses()
    {
        // TODO: Questo test deve dimostrare che un controller che trova corsi ritorna un array di 10 elementi paginati.
    }
}

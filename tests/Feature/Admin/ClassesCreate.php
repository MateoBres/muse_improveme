<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class ClassesCreate extends TestCase
{
    /** @test */
    public function itShowsClassCreationFields()
    {
        $response = $this->get(route('admin.classes.create'));

        $response->assertOk();
        $response->assertSee('Titolo');
        $response->assertSee('Descrizione');
        $response->assertSee('Attivo');
    }
}

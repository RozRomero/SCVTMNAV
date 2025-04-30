<?php

namespace Tests\Feature;

use App\Models\CatalogoDepartamentos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartamentoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_un_departamento()
    {
        $response = $this->post('/departamentos', [
            'nombre' => 'Departamento de Prueba',
            'descripcion' => 'Descripción de prueba'
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, CatalogoDepartamentos::all());
    }

    /** @test */
    public function nombre_es_obligatorio()
    {
        $response = $this->post('/departamentos', [
            'nombre' => '',
            'descripcion' => 'Descripción de prueba'
        ]);

        $response->assertSessionHasErrors('nombre');
    }

    /** @test */
    public function puede_actualizar_un_departamento()
    {
        $departamento = CatalogoDepartamentos::factory()->create();

        $response = $this->put("/departamentos/{$departamento->id}", [
            'nombre' => 'Nombre Actualizado',
            'descripcion' => 'Descripción actualizada'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('Nombre Actualizado', $departamento->fresh()->nombre);
    }

    /** @test */
    public function puede_eliminar_un_departamento()
    {
        $departamento = CatalogoDepartamentos::factory()->create();

        $response = $this->delete("/departamentos/{$departamento->id}");

        $response->assertStatus(204);
        $this->assertCount(0, CatalogoDepartamentos::all());
    }

    /** @test */
    public function muestra_lista_de_departamentos()
    {
        CatalogoDepartamentos::factory()->count(5)->create();

        $response = $this->get('/departamentos');

        $response->assertStatus(200);
        $response->assertViewHas('departamentos');
    }
}
<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    // la racine du site redirige vers la page de connexion
    public function test_home_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    // la page de connexion s'affiche
    public function test_login_page_is_displayed(): void
    {
        $this->get('/login')->assertStatus(200)->assertSee('Select Your Session');
    }

    // un visiteur non connecté ne peut pas accéder à l'espace manager
    public function test_manager_space_requires_login(): void
    {
        $this->get('/manager')->assertRedirect('/login');
    }
}

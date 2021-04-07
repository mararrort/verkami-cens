<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Models\TODO;
use App\Models\User;

use Faker;

class TodoTest extends DuskTestCase
{
    use DatabaseMigrations;
    public function testGuestCannotCreate(Type $var = null)
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/info');
            $browser->assertDontSeeLink("Añadir TODO");
        });
    }

    public function testGuestCannotEdit(Type $var = null)
    {
        TODO::factory()->public()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/info');
            $browser->assertNotPresent("@editTodo");
        });
    }

    public function testGuestCannotDelete(Type $var = null)
    {
        TODO::factory()->public()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/info');
            $browser->assertNotPresent("@deleteTodo");
        });
    }

    public function testGuestCannotSeePrivate(Type $var = null)
    {
        TODO::factory()->private()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/info');
            $browser->assertNotPresent("@privateTodo");
        });
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $faker = Faker\Factory::create();
        $todoText = substr($faker->sentence,0,64);
        $this->browse(function (Browser $browser) use ($user, $todoText) {
            $browser->loginAs($user);
            $browser->visit('/info');
            $browser->clickLink('Añadir TODO');
            $browser->assertRouteIs('TODO.create');
            $browser->value('@text', $todoText);
            $browser->select('type');
            $browser->press('Crear');
            $browser->pause(5000);
            $browser->assertRouteIs('info');
            $browser->assertSee($todoText);
        });
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $todo = TODO::factory()->create();
        $faker = Faker\Factory::create();
        $todoText = substr($faker->sentence,0,64);
        $this->browse(function (Browser $browser) use ($user, $todo, $todoText) {
            $browser->loginAs($user);
            $browser->visit('/info');
            $browser->click('@editTodo');
            $browser->assertRouteIs('TODO.edit', $todo);
            $browser->value('@text', $todoText);
            $browser->select('type');
            $browser->press('Actualizar');
            $browser->pause(5000);
            $browser->assertRouteIs('info');
            $browser->assertSee($todoText);
        });
    }

    public function testDelete()
    {
        $user = User::factory()->create();
        $todo = TODO::factory()->create();
        $this->browse(function (Browser $browser) use ($user, $todo) {
            $browser->loginAs($user);
            $browser->visit('/info');
            $browser->click('@deleteTodo');
            $browser->assertRouteIs('info');
            $browser->assertDontSee($todo->text);
        });
    }
}

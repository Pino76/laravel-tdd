<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    private $list;


    public function setUp(): void
    {
        parent::setUp();
        $this->list = TodoList::factory()->create();
    }


    public function test_fetch_all_todo_list(): void
    {
        #disabilita la gestione delle eccezioni
        $this->withoutExceptionHandling();

        # preparation / prepare
        ##TodoList::create(["name" => "my list"]);
        ##$list = TodoList::factory()->create();
        ## PS:. the factory is generate in setUp function

        # action / perform
        $response = $this->getJson(route('todo-list.index'));

        # assertion / predict
        $this->assertEquals(1, count($response->json()));

        $response->assertJsonCount(1);

        $response->assertStatus(200);

    }


    public function test_fetch_single_todo_list(){

        # disabilita la gestione delle eccezioni
        $this->withoutExceptionHandling();

        #preparation
        ## $list = TodoList::factory()->create();
        ## PS:. the factory is generate in setUp function

        #action
        $response = $this->getJson(route('todo-list.show' , $this->list->id))
            ->assertOk()
            ->json();


        #assertion
        $this->assertEquals($response["name"], $this->list->name);
    }


    public function test_store_new_todo_list(){

        #disabilita la gestione delle eccezioni
        $this->withoutExceptionHandling();

        # preparation
        #$list = TodoList::factory()->create();
        ## PS:. the factory is generate in setUp function

        # action
        $response = $this->postJson(route('todo-list.store', ["name" => $this->list->name]))
            ->assertCreated()
            ->json();

        $this->assertEquals($this->list->name , $response["name"]);

        # assertion
        $this->assertDatabaseHas('todo_lists', ["name" => $this->list->name]);

    }


    public function test_update_todo_list(){
        /*disabilita la gestione delle eccezioni*/
        $this->withoutExceptionHandling();

        # prepare

        # action
        $response = $this->patchJson(route('todo-list.update', $this->list->id), ['name' => 'updated name list'])
            ->assertOk();

        # assertion

        $this->assertDatabaseHas('todo_lists', ['id' => $this->list->id, 'name' => "updated name list"] );

    }


    public function test_delete_todo_list(){

        /*disabilita la gestione delle eccezioni*/
        $this->withoutExceptionHandling();

        #preparation
        # $list = TodoList::factory()->create();
        ## PS:. the factory is generate in setUp function

        #action
        $response = $this->deleteJson(route('todo-list.destroy', $this->list->id))
            ->assertNoContent();

        #assertion
        $this->assertDatabaseMissing('todo_lists', ['name' => $this->list->name]);

    }

}

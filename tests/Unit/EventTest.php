<?php

namespace Tests\Unit;

use App\Http\Controllers\taskController;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use App\Http\Requests\TaskRequest;
use App\Jobs\organizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventTest extends TestCase
{
    protected $userData;
    protected $taskData;
    protected $userController;
    protected $taskController;
    protected $userId;

    public function setUp(): void
    {
        parent::setUp();

        $this->userId = (string) Str::uuid();

        $this->userData = [
            'name' => 'Lud Teste',
            'email' => 'ludmilafroman@gmail.com',
            'phone' => '123456789',
            'hours' => 4,
            'days' => 'week',
            '_id' => $this->userId,
        ];

        $this->taskData = [
            'user' => $this->userId,
            'name' => 'Tarefa teste',
            'duration' => 30,
            'priority' => '5',
            'status' => 'open',
            'description' => 'descrição fake',
            '_id' => (string) Str::uuid(),
        ];

        $this->userController = new UserController();
        $this->taskController = new taskController();

        DB::table('users')->insert($this->userData);
        DB::table('tasks')->insert($this->taskData);
    }



    public function test_create_user_success()
    {
        $data = $this->userData;
        $data['_id'] = (string) Str::uuid();
        $data['minutes'] = $data['hours'] * 60;
        $request = userRequest::create('/fake', 'POST', $data);
        $response = $this->userController->create($request);
        $this->assertEquals(201, $response->getStatusCode());
        DB::table('users')->where('_id', $data['_id'])->delete(); // Limpa esse registro criado
    }

    public function test_create_task_success()
    {
        $data = $this->taskData;
        $data['_id'] = (string) Str::uuid();
        $request = taskRequest::create('/fake', 'POST', $data);
        $response = $this->taskController->create($request, $this->userId);
        $this->assertEquals(201, $response->getStatusCode());
        DB::table('tasks')->where('_id', $data['_id'])->delete();
    }

    public function test_update_task_success()
    {
        $data = $this->taskData;
        $data['name'] = 'Tarefa Atualizada';
        $request = taskRequest::create('/fake', 'POST', $data);
        $response = $this->taskController->edit($request, $this->taskData['_id']);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertDatabaseHas('tasks', ['name' => 'Tarefa Atualizada']);
    }

    public function test_delete_task_success()
    {
        $taskId = (string) Str::uuid();
        $data = array_merge($this->taskData, ['_id' => $taskId]);
        DB::table('tasks')->insert($data);
        $response = $this->taskController->delete($taskId, $this->userId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_generate_pdf_job_dispatched()
    {
        $response = $this->taskController->pdf($this->userId);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_delete_user_and_tasks()
    {
        $response = $this->userController->delete($this->userId);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertDatabaseMissing('tasks', ['user' => $this->userId]);
    }
    public function tearDown(): void
    {
        DB::table('tasks')->where('name', 'Tarefa teste')
            ->orWhere('name', 'Tarefa Atualizada')->delete();
        DB::table('users')->where('name', 'Lud Teste')->delete();
        parent::tearDown();
    }
}
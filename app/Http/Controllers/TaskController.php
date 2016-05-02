<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

use App\Acme\Transformers\TaskTransformer;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\DocBlock\Tag;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    protected $taskTransformer;
    /**
     * TaskController constructor.
     */
    public function __construct(TaskTransformer $taskTransformer)
    {
        $this->taskTransformer = $taskTransformer;
        $this->middleware('auth.basic', ['only' => 'store']);
        $this->middleware("auth.api");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //problema 1, no retorna: paginació
        $task = Task::all();
        return $this->respond([
            'data' => $this->taskTransformer->transformCollection($task->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Input::get('name') or ! Input::get('done') or ! Input::get('priority'))
        {
            return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError('Parameters failed validation for a task.');
        }
        Task::create(Input::all());
        return $this->respondCreated('Task successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->respondNotFound('La tasca no existeix!');
        }
        return $this->respond([
            'data' => $this->taskTransformer->transform($task)
        ]);

        //return $task = Task::findOrFail($id);

        //Es el mateix
        //$task = Tag::where('id', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $this->saveTask($request, $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
    }

    /**
     * @param Request $request
     * @param $task
     */
    public function saveTask(Request $request, $task)
    {
        $task->name = $request->name;
        $task->done = $request->done;
        $task->priority = $request->priority;
        $task->save();
    }

    public function transform ($tasks){
        return arry_map(function ($task){
            return [
            'name' => $task['name'],
            'text' => $task['text'],
            'done' => $task['done'],
                ];
        }, $tasks->toArray());
    }
}

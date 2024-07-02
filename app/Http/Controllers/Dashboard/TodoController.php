<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\FilterTodoRequest;
use App\Http\Requests\Todo\StoreSubTodoRequest;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateSubTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Models\Todo;
use App\Services\CategoryService;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct(
        private TodoService $todoService,
        private CategoryService $categoryService
    ) {}

    
    /**
     * Display a listing of the resource.
     */
    public function index(FilterTodoRequest $request)
    {
        $groupTodo = $this->todoService->getAll($request->all());
        $categories = $this->categoryService->getAll();
        $filters = $this->todoService->getFilter($request->all());
        return view('pages.todo.index', compact('groupTodo', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $this->todoService->create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo = $this->todoService->find($id);
        $categories = $this->categoryService->getAll();
        
        return view('pages.todo.edit', compact('todo', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        $this->todoService->update($request->all(), $id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $this->todoService->delete($id);
        if ($request->get('is_subtask')) {
            return redirect()->back();
        }
        return redirect()->route('todo.index');
    }

    public function storeSubtask(StoreSubTodoRequest $request, Todo $todo)
    {
        $this->todoService->createSubtask($request->all()['subtask'], $todo);
        return redirect()->back();
    }

    public function updateSubtask(UpdateSubTodoRequest $request, string $id)
    {
        $this->todoService->update($request->all()['subtaskUpdate'], $id);
        return redirect()->back();
    }
}

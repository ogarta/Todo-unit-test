<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Todo list
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold">To Do List</h1>
                    <div class="mt-4 flex">
                        <form action="{{ route('todo.index') }}" method="GET">
                            @csrf
                            <select name="category_id" id="category" class="border-gray-300 border p-2 rounded-lg" style="color: black;">
                                <option value="" @selected($filters['category_id'] == '')>All</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <select name="completed" id="completed" class="border-gray-300 border p-2 rounded-lg ms-2" style="color: black;">
                                <option value="" @selected($filters['completed'] == '')>All</option>
                                <option value="1" @selected($filters['completed'] == 1)>Completed</option>
                                <option value="0" @selected($filters['completed'] === '0')>Not Completed</option>
                            </select>

                            <input type="datetime-local" name="due_date" id="due_date" class="border-gray-300 border p-2 rounded-lg ms-2" style="color: black;" />

                            <select name="priority" id="priority" class="border-gray-300 border p-2 rounded-lg ms-2" style="color: black;">
                                <option value="" @selected($filters['priority'] == '')>All</option>
                                <option value="1" @selected($filters['priority'] == 1)>Low</option>
                                <option value="2" @selected($filters['priority'] == 2)>Medium</option>
                                <option value="3" @selected($filters['priority'] == 3)>High</option>
                            </select>

                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ms-2" type="submit">Filter</button>
                        </form>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mt-4">
                        <ul>
                            @foreach($groupTodo as $date => $todos)
                                <li class="mt-4">
                                    <h2 class="text-lg font-semibold">{{ $date }}</h2>
                                    <ul>
                                        @foreach($todos as $todo)
                                            <li class="flex justify-between mp-2 border-b border-gray-300 py-2 items-center">
                                                <div>
                                                    <input type="checkbox" name="completed" id="completed" {{ $todo->completed ? 'checked' : '' }} />
                                                    @if($todo->completed)
                                                        <del>{{ $todo->title }}</del>
                                                    @else
                                                        <span>{{ $todo->title }}</span>
                                                    @endif
                                                </div>
                                                <span>
                                                    <a class="btn-update bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('todo.edit', $todo->id) }}">Edit</a>
                                                    <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded disabled:opacity-75" @disabled($todo->completed)>Delete</button>
                                                    </form>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach

                            @if(count($groupTodo) === 0)
                                <li class="mt-4">
                                    <h2 class="text-lg font-semibold">No todo found</h2>
                                </li>
                            @endif

                            <li class="flex justify-between items-center mt-4">
                                <form action="{{ route('todo.store') }}" method="POST" class="flex items-center">
                                    @csrf
                                    <select name="category_id" class="border-gray-300 border p-2 rounded-lg" style="color: black; width: 100px; text-wrap: wrap;">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="project_id" value="{{ request()->input('project_id') }}" />
                                    <input type="text" name="title" class="border-gray-300 border p-2 rounded-lg ms-2" placeholder="Add a new todo" style="color: black;" />
                                    <input type="datetime-local" name="due_date" class="border-gray-300 border p-2 rounded-lg ms-2" style="color: black;" />
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ms-2">Add</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

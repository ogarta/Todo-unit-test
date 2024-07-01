<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Todo list
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="flex items-center">
                        <form action="{{ route('todo.update', $todo->id) }}" method="POST" id="updateCompleted-{{ $todo->id }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="completed" value="{{ old('completed', $todo->completed) }}" id="completed-hidden-{{ $todo->id }}"/>
                        </form>
                        <input type="checkbox" id="completed" data-id="{{ $todo->id }}" @checked(old('completed',$todo->completed)) />
                        @if ($todo->completed)
                        <del>{{ $todo->title }}</del>
                        @else
                        <input type="text" value="{{ old('title',$todo->title) }}" class="disabled:opacity-75 form-control border-gray-300 border p-2 rounded-lg ms-2" style="color: black;" id="title"/>
                        @endif
                    </div>
                    <fieldset @disabled($todo->completed)>
                        <span class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                            Subtasks
                        </span>
                        <ul class="list-group">
                            @foreach($todo->subtasks as $subtask)
                                <li class="list-group list-group-item d-flex justify-content-between align-items-center mt-2 flex items-center">
                                    <form action="{{ route('todo.update', $subtask->id) }}" method="POST" id="updateCompleted-{{ $subtask->id }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="completed" value="{{ $subtask->completed }}" id="completed-hidden-{{ $subtask->id }}"/>
                                    </form>
                                    <input type="checkbox" class="disabled:opacity-75" id="completed" data-id="{{ $subtask->id }}" @checked($subtask->completed) />
                                    @if ($subtask->completed)
                                        <del>{{ $subtask->title }}</del>
                                    @else
                                        <form action="{{ route('todo.update', $subtask->id) }}" method="POST" id="updateSubtask-{{ $subtask->id }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="category_id" value="{{ $subtask->category_id }}" />
                                            <input type="hidden" name="priority" value="{{ $subtask->priority }}" />
                                            <input type="text" name="title" value="{{ $subtask->title }}" class="disabled:opacity-75 title-subtask form-control border-gray-300 border p-2 rounded-lg ms-2" style="color: black;" data-id="{{ $subtask->id }}" />
                                        </form>
                                    @endif
                                    <form action="{{ route('todo.destroy', $subtask->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="disabled:opacity-75 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ms-2" @disabled($subtask->completed)>Delete</button>
                                    </form>
                                </li>
                            @endforeach
                            <form action="{{ route('subtask.store', $todo->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="subtask[due_date]" value="{{ $todo->due_date }}" />
                                <input type="hidden" name="subtask[category_id]" value="{{ $todo->category_id }}" />
                                <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                                    <input type="text" name="subtask[title]" class="disabled:opacity-75 form-control border-gray-300 border rounded-lg" style="color: black;" placeholder="Add a new subtask" value="{{ old('subtask.title') }}"/>
                                    <span>
                                        <button type="submit" class="disabled:opacity-75 btn-update bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add</button>
                                    </span>
                                </li>
                            </form>
                        </ul>
                        <form action="{{ route('todo.update', $todo->id) }}" method="POST" id="updateTodo-{{ $todo->id }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ old('title', $todo->title) }}" id="title-hidden"/>
                            <table class="table-fixed mt-2 mb-2">
                                <tbody>
                                    <tr class="mb-2">
                                        <td>
                                            <label for="due_date">Due date</label>
                                        </td>
                                        <td>
                                            <input type="datetime-local" name="due_date" class="disabled:opacity-75 form-control border-gray-300 border p-2 rounded-lg ms-2 w-full" value="{{ $todo->due_date }}" style="color: black;"/>
                                        </td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td>
                                            <label for="category_id">Category</label>
                                        </td>
                                        <td>
                                            <select name="category_id" class="disabled:opacity-75 form-control border-gray-300 border p-2 rounded-lg ms-2 w-full" style="color: black;">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td>
                                            <label for="priority">Priority</label>
                                        </td>
                                        <td>
                                            <select name="priority" class="disabled:opacity-75 form-control border-gray-300 border p-2 rounded-lg ms-2 w-full" style="color: black;">
                                                @foreach(\App\Enums\PriorityEnum::cases() as $priority)
                                                    <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <label for="description">Description</label>
                            <textarea name="description" class="disabled:opacity-75 form-control border-gray-300 border p-2 rounded-lg ms-2 w-full" style="color: black;">{{ old('description', $todo->description) }}</textarea>
                        </form>
                        <button type="submit" class="disabled:opacity-75 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" form="updateTodo-{{ $todo->id }}">Update</button>
                        <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="disabled:opacity-75 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-2">Delete</button>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <x-slot:scripts>
        <script>
            $(document).ready(function() {
                $('input[type="checkbox"]').on('change', function() {
                    let id = $(this).data('id');
                    console.log(id);
                    $('#completed-hidden-' + id).val($(this).prop('checked') ? 1 : 0);
                    $('#updateCompleted-' + id).submit();
                });
            

                $('#title').on('change', function() {
                    $('#title-hidden').val($(this).val());
                });

                $('.title-subtask').on('keypress', function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        let id = $(this).data('id');
                        console.log(e.which, id);
                        $('#updateSubtask-' + id).submit();
                    }
                });
            });
        </script>
    </x-slot:scripts>
</x-app-layout>
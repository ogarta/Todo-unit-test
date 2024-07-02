<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Project List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold">Project List</h1>
                    <div class="mt-4 mb-4">
                        <ul>
                            @foreach($projects as $project)
                                <li class="flex justify-between mp-2 border-b border-gray-300 py-2 items-center">
                                    <span>{{ $project->name }}</span>
                                    <span>
                                        <a class="btn-update bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('project.edit', $project->id) }}">Edit</a>
                                        <form action="{{ route('todo.destroy', $project->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded disabled:opacity-75">Delete</button>
                                        </form>
                                    </span>
                                </li>
                            @endforeach

                            @if(count($projects) === 0)
                                <li class="mt-4">
                                    <h2 class="text-lg font-semibold">No prject found</h2>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <a class="btn-create bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" href="{{ route('project.create') }}">Create Project</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

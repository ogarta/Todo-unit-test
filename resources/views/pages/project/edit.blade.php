<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Project
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div
                            class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('project.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Project Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                            <textarea name="description" id="description"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                            <select name="status" id="status"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                <option value="0">Pending</option>
                                <option value="1">Completed</option>
                                <option value="2">Closed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="start_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">List Users</label>
                            <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                @foreach ($users as $user)
                                    <li>
                                        <label for="user_{{ $user->id }}" class="flex items-center">
                                            <input type="checkbox" name="users[]" id="user_{{ $user->id }}"
                                                value="{{ $user->id }}"
                                                @checked(in_array($user->id, $project->users->pluck('id')->toArray())) />
                                            <span class="ml-2 text-sm">{{ $user->name }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

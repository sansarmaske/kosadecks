<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h2 class="font-bold text-lg mb-10">Add Category </h2>

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="group" class="sr-only">Group</label>
                            <select name="group" id="group"
                                class="bg-gray-100 w-full p-4 rounded-sm @error('group') border-red-500 @enderror">
                                <option value="">Select Group</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>

                            @error('group')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="title" class="sr-only">Title</label>
                            <input type="text" name="name" id="name" placeholder="Name"
                                class="bg-gray-100 w-full p-4 rounded-sm @error('name') border-red-500 @enderror"
                                value="{{ old('name') }}">

                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Add
                                Category</button>
                        </div>



                </div>
            </div>
        </div>
    </div>
</x-app-layout>

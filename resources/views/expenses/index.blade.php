<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (Session::has('message'))
        <div class="p-4 mb-4 text-sm {{ Session::get('alert-class', 'text-blue-700 bg-blue-100') }} rounded-lg"
            role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end">
                        <a href="{{ route('expenses.create', ['group_id' => $group->id]) }}"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">Add
                            Expense</a>
                    </div>

                    <div class="mt-10">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Title & Description</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Paid By</th>

                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $expense->expense_date->format('j') }}<sup>{{ $expense->expense_date->format('S') }}</sup> {{ $expense->expense_date->format('F Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->category->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <p class="text-lg font-semibold text-gray-900">{{ $expense->title }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">{{ $expense->description }}</p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-red-500">${{ $expense->amount }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->user->name }}</td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('expenses.edit', $expense) }}"
                                                    class="inline-flex items-center px-2 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">Edit</a>
                                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

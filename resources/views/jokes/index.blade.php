<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('User Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Jokes')}}
            </h3>

            <x-primary-link-button
                href="{{ route('jokes.create') }}"
                class="hover:bg-green-500 text-white flex items-center gap-2 mt-6"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Add Joke</span>
            </x-primary-link-button>
        </header>

        <table class="table w-full bg-white border">
            <thead class="bg-black text-gray-200">
            <tr>
                <th class="p-2">Title</th>
                <th class="p-2">User ID</th>
                <th class="p-2">Content</th>
                <th class="p-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($jokes as $joke)
                <tr class="odd:bg-gray-100">
                    <td class="p-2">{{ $joke->title }}</td>
                    <td class="p-2">{{ $joke->user_id }}</td>
                    <td class="p-2">{!! Str::of($joke->content??"")->stripTags() !!}</td>
                    <td class="p-2 flex gap-4">
                        <x-primary-link-button
                            href="{{ route('jokes.show', $joke) }}"
                            class="hover:bg-sky-500">
                            <i class="fa-solid fa-eye pr-2"></i>
                            <span class="sr-only">Show</span>
                        </x-primary-link-button>

                        @if(auth()->id() === $joke->user_id)
                            <x-primary-link-button
                                href="{{ route('jokes.edit', $joke) }}"
                                class="hover:bg-green-500">
                                <i class="fa-solid fa-edit pr-2"></i>
                                <span class="sr-only">Edit</span>
                            </x-primary-link-button>
                            <x-secondary-link-button
                                href="{{ route('jokes.delete', $joke) }}"
                                class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white!">
                                <i class="fa-solid fa-trash pr-2"></i>
                                <span class="sr-only">Delete</span>
                            </x-secondary-link-button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No Jokes</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td class="p-4" colspan="3">
                    @if($jokes->hasPages())
                        {{ $jokes->links() }}
                    @else
                        @if($jokes->total() > 0)
                            All Jokes shown
                        @else
                            No Jokes
                        @endif
                    @endif
                </td>
            </tr>
            </tfoot>
        </table>
    </section>

</x-app-layout>

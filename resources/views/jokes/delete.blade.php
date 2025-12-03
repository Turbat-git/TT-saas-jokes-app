<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('User Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Joke')}}: {{ __('Delete') }}
            </h3>
        </header>

        <dl class="flex flex-wrap gap-4">
            <dt class="w-1/6">Name</dt>
            <dd class="grow">{{ $joke->title }}</dd>
            <dt class="w-1/6">Content</dt>
            <dd class="grow min-w-2/3">{{ $joke->content }}</dd>
        </dl>

        <footer>
            <form action="{{ route('jokes.destroy', $joke) }}"
                  method="POST"
                  class="flex gap-4">

                @csrf
                @method('DELETE')

                <x-primary-link-button
                    href="{{ route('jokes.index') }}"
                    class="hover:bg-sky-500 gap-4">
                    <i class="fa-solid fa-list pr-2"></i>
                    <span>All Jokes</span>
                </x-primary-link-button>
                <x-primary-link-button
                    href="{{ route('jokes.edit', $joke ) }}"
                    class="hover:bg-green-500 gap-4">
                    <i class="fa-solid fa-edit pr-2"></i>
                    <span>Edit</span>
                </x-primary-link-button>
                <x-secondary-button
                    type="submit"
                    class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white! gap-4">
                    <i class="fa-solid fa-trash pr-2"></i>
                    <span>Delete</span>
                </x-secondary-button>
            </form>
        </footer>
    </section>

</x-app-layout>

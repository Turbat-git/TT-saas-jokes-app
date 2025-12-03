<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('User Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Joke')}}: {{ __('Edit') }}
            </h3>
        </header>

        <form action="{{ route('jokes.update', $joke) }}"
              method="POST">

            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">
                <x-input-label for="Title">Title</x-input-label>
                <x-textarea name="title"
                            id="Title"
                            type="text"
                            :message="old('title', $joke->title)"
                            placeholder="Category Title"
                            required autofocus
                            autocomplete="title"/>
                <x-input-error :messages="$errors->get('title')" class="mt-2"/>

                <x-input-label for="Content">Content</x-input-label>
                <x-textarea name="content"
                            id="Content"
                            :message="old('content', $joke->content)"
                            placeholder="Joke Content"
                            required autofocus
                            autocomplete="content"/>
                <x-input-error :messages="$errors->get('content')" class="mt-2"/>
            </div>

            <footer class="mt-6">
                <x-primary-button
                    class="hover:bg-green-500 gap-4">
                    <i class="fa-solid fa-save pr-2"></i>
                    <span>Save</span>
                </x-primary-button>

                <x-secondary-link-button
                    href="{{ route('jokes.index') }}"
                    class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white! gap-4">
                    <i class="fa-solid fa-times pr-2"></i>
                    <span>Cancel</span>
                </x-secondary-link-button>
            </footer>
        </form>
    </section>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('User Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Jokes')}}: {{ __('Create') }}
            </h3>
        </header>

        <form action="{{ route('jokes.store') }}"
              method="POST">

            @csrf

            <div class="flex flex-col gap-4">
                <x-input-label for="Title">Title</x-input-label>
                <x-text-input name="title"
                            id="Title"
                            placeholder="Joke Title"
                            autofocus
                            value="{{old('title') ??''}}"
                            autocomplete="title"/>
                <x-input-error :messages="$errors->get('title')" class="mt-2"/>

                <x-input-label for="Content">Content</x-input-label>
                <x-textarea name="content"
                            id="Content"
                            placeholder="Joke Content"
                            >{{ old('content') ??"" }}</x-textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2"/>

                <x-input-label for="categories">Categories</x-input-label>

                <select name="categories[]" id="categories" multiple
                        class="border-gray-300 rounded-md shadow-sm w-full">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('categories')" class="mt-2"/>
            </div>

            <footer class="mt-6">
                <x-primary-button
                    name="save"
                    class="hover:bg-green-500 gap-4" type="submit">
                    <i class="fa-solid fa-plus pr-2"></i>
                    <span>Add</span>
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

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Categories')}}: {{ __('Create') }}
            </h3>
        </header>

        <form action="{{ route('admin.categories.store') }}"
              method="POST">

            @csrf
            @method('POST')
            <div class="flex flex-col gap-4">
                <x-input-label for="Title">Title</x-input-label>
                <x-text-input name="title"
                              id="Title"
                              type="text"
                              placeholder="Category Title"
                              required autofocus
                              autocomplete="title"/>
                <x-input-error :messages="$errors->get('title')" class="mt-2"/>

                <x-input-label for="Description">Description</x-input-label>
                <x-text-input name="description"
                              id="Description"
                              type="text"
                              placeholder="Category Description"
                              required autofocus
                              autocomplete="description"/>
                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
            </div>

            <footer class="mt-6">
                <x-primary-link-button
                    href="{{ route('admin.categories.index') }}"
                    class="hover:bg-sky-500 gap-4">
                    <i class="fa-solid fa-list pr-2"></i>
                    <span>All Categories</span>
                </x-primary-link-button>

                <x-primary-button
                    class="hover:bg-green-500 gap-4">
                    <i class="fa-solid fa-plus pr-2"></i>
                    <span>Save</span>
                </x-primary-button>

                <x-secondary-link-button
                    href="{{ route('admin.categories.index') }}"
                    class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white! gap-4">
                    <i class="fa-solid fa-times pr-2"></i>
                    <span>Cancel</span>
                </x-secondary-link-button>
        </footer>
    </form>
</section>

</x-admin-layout>

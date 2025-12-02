<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg
                        flex flex-col gap-4 p-6">

                <!-- see resources/css/app.css for card definition -->
                <article class="simple-card hover:bg-white">
                    <p class="text-2xl font-medium text-gray-900">
                        {{ $category->title }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $category->description }}
                    </p>
                </article>

                <article>
                    <h3 class="text-lg">
                        Jokes in Category
                    </h3>
                </article>

            </div>
        </div>
    </div>

</x-app-layout>

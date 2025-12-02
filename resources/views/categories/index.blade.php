<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg
                        grid grid-cols-3 gap-4 p-6">
                @forelse($categories as $category)
                    <!-- see resources/css/app.css for card definition -->
                    <a href="{{ route('categories.show', $category) }}"
                       class="simple-card hover:border-gray-500">
                        <article>
                            <p class="text-2xl font-medium text-gray-900">
                                {{ $category->title }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $category->snippet() }}
                            </p>
                        </article>
                    </a>
                @empty
                    <h3 class="font-bold"> {{ __('No Categories') }}</h3>
                @endforelse
            </div>
        </div>
    </div>

</x-app-layout>

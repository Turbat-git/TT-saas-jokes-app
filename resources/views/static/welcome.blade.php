<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Some random humour from the vaults...') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if($joke)
                    <article class="mb-6">
                        <header class="bg-black text-white p-4 rounded-md mb-4">
                            <h2 class="text-2xl font-bold">{{ $joke->title }}</h2>
                            <p class="text-sm text-gray-300">
                                Added on: {{ $joke->created_at->format('d M Y') }}
                            </p>
                        </header>

                        <div class="prose max-w-none mb-4">
                            {!! $joke->content !!}
                        </div>

                        {{-- Categories --}}
                        <footer class="mt-4">
                            <h3 class="font-semibold text-gray-700">Categories:</h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @forelse ($joke->categories as $category)
                                    <span class="px-2 py-1 bg-gray-200 rounded text-sm">
                                        {{ $category->title }}
                                    </span>
                                @empty
                                    <span class="text-gray-500">No categories assigned.</span>
                                @endforelse
                            </div>
                        </footer>
                    </article>

                @else
                    <p class="text-gray-600">No jokes found!</p>
                @endif

                {{-- Another Joke Button --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md transition">
                        <i class="fa-solid fa-shuffle mr-2"></i>
                        Another Joke
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

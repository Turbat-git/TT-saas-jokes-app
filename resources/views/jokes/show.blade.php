<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('User Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Jokes')}}: {{ __('Detail') }}
            </h3>
        </header>


        <dl class="space-y-4">
            <div class="flex">
                <dt class="w-1/4 font-semibold">Name</dt>
                <dd class="w-3/4">{{ $joke->title }}</dd>
            </div>

            <div class="flex">
                <dt class="w-1/4 font-semibold">Tags:</dt>
                <dd class="w-3/4">
                    @foreach($joke->categories as $category)
                        <span class="px-2 py-1 bg-gray-200 rounded text-sm">{{ $category->title }}</span>
                    @endforeach
                </dd>
            </div>

            <div class="flex">
                <dt class="w-1/4 font-semibold">Content</dt>
                <dd class="w-3/4">{!! $joke->content !!}</dd>
            </div>
        </dl>

        <footer>
            <x-primary-link-button
                href="{{ route('jokes.index') }}"
                class="hover:bg-sky-500 gap-4">
                <i class="fa-solid fa-list pr-2"></i>
                <span>All Jokes</span>
            </x-primary-link-button>
            @if(auth()->id() === $joke->user_id)
                <x-primary-link-button
                    href="{{ route('jokes.index') }}"
                    class="hover:bg-green-500 gap-4">
                    <i class="fa-solid fa-edit pr-2"></i>
                    <span>Edit</span>
                </x-primary-link-button>
                <x-secondary-link-button
                    href="{{ route('jokes.index') }}"
                    class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white! gap-4">
                    <i class="fa-solid fa-trash pr-2"></i>
                    <span>Delete</span>
                </x-secondary-link-button>
            @endif
            <div class="text-right">
                @livewire('like-dislike', [$joke])
            </div>
        </footer>
    </section>

</x-app-layout>

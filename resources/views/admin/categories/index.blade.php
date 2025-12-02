<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('Categories')}}
            </h3>

            <x-primary-link-button
                href="{{ route('admin.categories.create') }}"
                class="hover:bg-green-500 text-white flex items-center gap-2 mt-6"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Add Category</span>
            </x-primary-link-button>
        </header>

        <table class="table w-full bg-white border">
            <thead class="bg-black text-gray-200">
            <tr>
                <th class="p-2">Name</th>
                <th class="p-2">Description</th>
                <th class="p-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="odd:bg-gray-100">
                    <td class="p-2">{{ $category->title }}</td>
                    <td class="p-2">{!! Str::of($category->description??"")->stripTags() !!}</td>
                    <td class="p-2 flex gap-4">
                        <x-primary-link-button
                            href="{{ route('admin.categories.show', $category) }}"
                            class="hover:bg-sky-500">
                            <i class="fa-solid fa-eye pr-2"></i>
                            <span class="sr-only">Show</span>
                        </x-primary-link-button>
                        <x-primary-link-button
                            href="{{ route('admin.categories.edit', $category ) }}"
                            class="hover:bg-green-500">
                            <i class="fa-solid fa-edit pr-2"></i>
                            <span class="sr-only">Edit</span>
                        </x-primary-link-button>
                        <x-secondary-link-button
                            href="{{ route('admin.categories.delete', $category) }}"
                            class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white!">
                            <i class="fa-solid fa-trash pr-2"></i>
                            <span class="sr-only">Delete</span>
                        </x-secondary-link-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No Categories</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td class="p-4" colspan="3">
                    @if($categories->hasPages())
                        {{ $categories->links() }}
                    @else
                        @if($categories->total() > 0)
                            All Categories shown
                        @else
                            No Categories
                        @endif
                    @endif
                </td>
            </tr>
            </tfoot>
        </table>
    </section>

</x-admin-layout>

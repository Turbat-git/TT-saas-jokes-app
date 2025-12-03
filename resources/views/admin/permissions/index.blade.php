<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header class="flex justify-between">
            <h3 class="text-2xl font-bold text-zinc-700">
                <a href="{{ route('admin.permissions.index') }}"
                   class="hover:text-zinc-500">
                    {{__('Permissions')}}
                </a>
            </h3>
        </header>

        <div class="w-full">
            <table class="min-w-full divide-y-2 divide-gray-200 bg-gray-50">
                <thead class="sticky top-0 bg-zinc-700 ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-white">
                    <th class="px-3 py-2 whitespace-nowrap">Permissions</th>
                    <th class="px-3 py-2 whitespace-nowrap">Protecting</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                @foreach($permissions as $permission)
                    <tr class="*:text-gray-900 *:first:font-medium hover:bg-white">
                        <td class="px-3 py-1 whitespace-nowrap min-w-1/3">
                            <span class="">{{ $permission->name }}</span>
                        </td>
                        <td class="px-3 py-1 whitespace-nowrap w-auto">
                        <span class="text-xs rounded-full bg-gray-700 p-0.5 px-2 text-gray-200">
                            <span class="">{{ $permission->guard_name }}</span>
                        </span>
                        </td>

                        <td class="px-3 py-1 whitespace-nowrap flex gap-2 w-full">

                            <a href="{{ route('admin.permissions.show', $permission) }}"
                               class="hover:text-green-500 transition border p-2 text-center rounded">
                                <i class="fa-solid fa-user-tag"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach

                </tbody>

                <tfoot>
                <tr>
                    <td colspan="4" class="p-3">
                        {{
                        $permissions->onEachSide(2)
                            ->links("vendor.pagination.tailwind")
                        }}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('System')}}
            </h3>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <article
                class="items-center rounded-lg bg-white shadow hover:shadow-none align-middle hover:bg-zinc-700 transition duration-500 group overflow-hidden border border-zinc-700/75">
                <div class="flex">
                    <header
                        class="w-1/4 bg-zinc-700 text-white  flex items-center justify-center py-6 transition-colors duration-500">
                        <i class="fa-solid fa-info-circle text-4xl group-hover:-rotate-12 duration-500 transition-transform"></i>
                    </header>

                    <section class="w-3/4 p-6 flex flex-col justify-center">
                        <p class="text-2xl font-bold text-gray-800 group-hover:text-white mb-1 transition-colors duration-500">
                            {{ env('APP_VERSION')??"development" }}
                        </p>

                        <p class="text-gray-600 group-hover:text-white text-sm uppercase tracking-wide transition-colors duration-500">
                            {{__('Version')}}
                        </p>
                    </section>
                </div>
            </article>

            <article
                class="items-center rounded-lg bg-white shadow hover:shadow-none align-middle hover:bg-zinc-700 transition duration-500 group overflow-hidden border border-zinc-700/75">
                <div class="flex">
                    <header
                        class="w-1/4 bg-zinc-700 text-white  flex items-center justify-center py-6 transition-colors duration-500">
                        <i class="fa-solid fa-computer text-4xl group-hover:-rotate-12 duration-500 transition-transform"></i>
                    </header>

                    <section class="w-3/4 p-6 flex flex-col justify-center">
                        <p class="text-2xl font-bold text-gray-800 group-hover:text-white mb-1 transition-colors duration-500">
                            {{ env('APP_ENV')??'Unknown' }}
                        </p>

                        <p class="text-gray-600 group-hover:text-white text-sm uppercase tracking-wide transition-colors duration-500">
                            {{__('Environment')}}
                        </p>
                    </section>
                </div>
            </article>

        </div>

    </section>

</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header class="flex justify-between items-center">
            <h3 class="text-2xl font-bold text-zinc-700">
                <a href="{{ route('admin.roles.index') }}"
                   class="hover:bg-zinc-500 hover:text-white transition border p-2 text-center rounded">
                    <i class="fa-solid fa-users"></i>
                    All Roles
                </a>
            </h3>
        </header>

        <div class="w-full bg-gray-100 p-6 rounded shadow">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Role Details</h3>

            <div class="mb-4">
                <x-input-label :value="__('Role Name')" />
                <p class="mt-1 text-gray-900">{{ $role->name }}</p>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Current Permissions</h3>

                <div class="flex flex-row gap-2 flex-wrap">
                    @forelse($rolePermissions as $rolePermission)
                        <span class="text-xs bg-gray-700 text-white p-1 px-2 rounded-full whitespace-nowrap">
                            {{ $rolePermission->name }}
                        </span>
                    @empty
                        <p class="text-gray-600 text-sm">No Permissions</p>
                    @endforelse
                </div>
            </div>
        </div>

    </section>
</x-admin-layout>

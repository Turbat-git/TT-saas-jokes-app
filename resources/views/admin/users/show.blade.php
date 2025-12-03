<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('User')}}: {{ __('Detail') }}
            </h3>
        </header>

        <dl class="space-y-4">
            <div class="flex">
                <dt class="w-1/4 font-semibold">ID</dt>
                <dd class="w-3/4">{{ $user->id }}</dd>
            </div>

            <div class="flex">
                <dt class="w-1/4 font-semibold">Name</dt>
                <dd class="w-3/4">{{ $user->name }}</dd>
            </div>

            <div class="flex">
                <dt class="w-1/4 font-semibold">Email</dt>
                <dd class="w-3/4">{!! $user->email !!}</dd>
            </div>

            @foreach($roles as $role)
                <div class="flex">
                    <dt class="w-1/4 font-semibold">Role</dt>
                    <dd class="w-3/4">{!! $role->name !!}</dd>
                </div>
            @endforeach

            <div class="flex">
                <dt class="w-1/4 font-semibold">Email Verified</dt>
                <dd class="w-3/4">{!! $user->email_verified_at !!}</dd>
            </div>
        </dl>

        <footer>
            <x-primary-link-button
                href="{{ route('admin.users.index') }}"
                class="hover:bg-sky-500 gap-4">
                <i class="fa-solid fa-list pr-2"></i>
                <span>All Users</span>
            </x-primary-link-button>
            <x-primary-link-button
                href="{{ route('admin.users.edit', $user ) }}"
                class="hover:bg-green-500 gap-4">
                <i class="fa-solid fa-edit pr-2"></i>
                <span>Edit</span>
            </x-primary-link-button>
            <x-secondary-link-button
                href="{{ route('admin.users.delete', $user) }}"
                class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white! gap-4">
                <i class="fa-solid fa-trash pr-2"></i>
                <span>Delete</span>
            </x-secondary-link-button>
        </footer>
    </section>

</x-admin-layout>

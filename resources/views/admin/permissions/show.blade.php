<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-6">

        <header class="flex justify-between items-center">
            <h3 class="text-2xl font-bold text-zinc-700">
                <a href="{{ route('admin.permissions.index') }}"
                   class="hover:text-zinc-500 transition">
                    {{ __('Permissions') }}
                </a>
                <span class="text-zinc-400">/</span>
                <span class="text-zinc-700">{{ $permission->name }}</span>
            </h3>

            <a href="{{ route('admin.permissions.index') }}"
               class="text-sm px-3 py-2 rounded bg-zinc-700 text-white hover:bg-zinc-600 transition">
                ← {{ __('Back to Permissions') }}
            </a>
        </header>

        <!-- Permission Details Card -->
        <div class="rounded-lg bg-white shadow border border-zinc-200 p-6">
            <h4 class="text-lg font-semibold text-zinc-800 mb-4">
                {{ __('Permission Details') }}
            </h4>

            <div class="space-y-4">

                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">
                        {{ __('Name') }}
                    </p>
                    <p class="text-zinc-800 text-lg font-medium">
                        {{ $permission->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">
                        {{ __('Guard') }}
                    </p>
                    <span class="text-sm rounded-full bg-gray-700 px-2 py-1 text-gray-200">
                        {{ $permission->guard_name }}
                    </span>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">
                        {{ __('Created At') }}
                    </p>
                    <p class="text-zinc-700">
                        {{ $permission->created_at?->format('Y-m-d H:i') ?? __('Unknown') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">
                        {{ __('Last Updated') }}
                    </p>
                    <p class="text-zinc-700">
                        {{ $permission->updated_at?->format('Y-m-d H:i') ?? __('Unknown') }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Roles That Have This Permission -->
        <div class="rounded-lg bg-white shadow border border-zinc-200 p-6">
            <h4 class="text-lg font-semibold text-zinc-800 mb-4">
                {{ __('Roles with this Permission') }}
            </h4>

            @php
                $roles = $permission->roles;
            @endphp

            @if($roles->count())
                <ul class="list-disc ml-6 space-y-1 text-zinc-800">
                    @foreach($roles as $role)
                        <li>{{ $role->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-zinc-600 italic">
                    {{ __('No roles currently assigned this permission.') }}
                </p>
            @endif
        </div>

    </section>
</x-admin-layout>

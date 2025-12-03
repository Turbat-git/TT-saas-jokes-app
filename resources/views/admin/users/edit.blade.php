<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('User')}}: {{ __('Edit') }}
            </h3>
        </header>

        <form action="{{ route('admin.users.update', $user) }}"
              method="POST">

            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">
                <div class="flex">
                    <dt class="w-1/4 font-semibold">ID</dt>
                    <dd class="w-3/4">{{ $user->id }}</dd>
                </div>

                <x-input-label for="Name">User's Name</x-input-label>
                <x-text-input name="name"
                            id="Name"
                            type="text"
                            placeholder="User's Name"
                            value="{{old('name') ?? $user->name}}"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>

                <x-input-label for="Email">Email</x-input-label>
                <x-textarea name="email"
                            id="Email"
                            placeholder="User Email"
                            >{{ old('email') ?? $user->email }}</x-textarea>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>

                <x-input-label for="roles">Roles</x-input-label>
                <div class="flex flex-col gap-2">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-2">
                            <input type="checkbox"
                                   name="roles[]"
                                   value="{{ $role->id }}"
                                {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('roles')" class="mt-2"/>


                <div class="flex">
                    <dt class="w-1/4 font-semibold">Email Verified</dt>
                    <dd class="w-3/4">{!! $user->email_verified_at !!}</dd>
                </div>
            </div>

            <footer class="mt-6">
                <x-primary-button
                    class="hover:bg-green-500 gap-4">
                    <i class="fa-solid fa-save pr-2"></i>
                    <span>Save</span>
                </x-primary-button>

                <x-secondary-link-button
                    href="{{ route('admin.users.index') }}"
                    class="bg-red-100 hover:bg-red-500 text-gray-500! hover:text-white! gap-4">
                    <i class="fa-solid fa-times pr-2"></i>
                    <span>Cancel</span>
                </x-secondary-link-button>
            </footer>
        </form>
    </section>

</x-admin-layout>

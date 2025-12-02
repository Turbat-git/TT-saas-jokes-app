<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Zone') }}
        </h2>
    </x-slot>

    <section class="py-12 mx-12 space-y-4">

        <header>
            <h3 class="text-2xl font-bold text-zinc-700">
                {{__('User')}}: {{ __('Create') }}
            </h3>
        </header>

        <form action="{{ route('admin.users.store') }}"
              method="POST">

            @csrf
            @method('POST')
            <div class="flex flex-col gap-4">
                <x-input-label for="Name">Name</x-input-label>
                <x-textarea name="name"
                            id="Name"
                            type="text"
                            placeholder="User Name"
                            required autofocus
                            autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>

                <x-input-label for="Email">Email</x-input-label>
                <x-textarea name="email"
                            id="Email"
                            type="text"
                            placeholder="User Email"
                            required autofocus
                            autocomplete="email"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>

                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password"
                              class="block mt-1 w-full"
                              type="password"
                              name="password"
                              placeholder="Password"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation"
                              class="block mt-1 w-full"
                              type="password"
                              placeholder="Confirm Password"
                              name="password_confirmation"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <footer class="mt-6">
                <x-primary-button
                    class="hover:bg-green-500 gap-4">
                    <i class="fa-solid fa-plus pr-2"></i>
                    <span>Add</span>
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

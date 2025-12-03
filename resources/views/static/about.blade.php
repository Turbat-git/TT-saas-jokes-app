<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 leading-relaxed">

                    <h3 class="text-2xl font-bold mb-4 text-indigo-600">
                        Welcome to the JokeHub Application!
                    </h3>

                    <p class="mb-4">
                        This project is part of the <strong>ICT50120 – Diploma of Information Technology</strong> assessment.
                        It demonstrates the use of Laravel, MVC design principles, user authentication, role-based access,
                        and dynamic content management.
                    </p>

                    <p class="mb-6">
                        Users can browse jokes, create their own submissions, and manage their profile.
                        Higher-level roles (Client, Staff, Admin, Super-Admin) have additional abilities such as managing categories,
                        users, roles, and permissions.
                    </p>

                    {{-- USER STATISTICS --}}
                    @auth
                        <div class="mt-8 p-5 bg-gray-100 rounded-lg border border-gray-300">
                            <h4 class="text-lg font-semibold mb-2">Project Activity</h4>

                            <p>
                                You have created
                                <strong>{{ $jokesCount }}</strong>
                                {{ Str::plural('joke', $jokesCount) }} so far.
                            </p>
                        </div>
                    @endauth

                    <div class="mt-10 text-sm text-gray-500">
                        <p>This application is for educational purposes only.</p>
                        <p class="mt-1">Built with ❤️ using Laravel 12.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View Profile') }}
            </h2>
            <div>
                <a href="{{ route('profiles.edit', $profile) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit Profile') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Avatar and Basic Info -->
                        <div class="md:col-span-1">
                            <div class="flex flex-col items-center">
                                @if($profile->avatar)
                                    <img class="profile-avatar  rounded-full" 
                                    src="{{ $profile->avatar_url }}" 
                                    alt="{{ $profile->name }}">
                                @else
                                    <div class="h-32 w-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mb-4">
                                        <span class="text-gray-500 dark:text-gray-400 text-2xl font-medium">
                                            {{ substr($profile->name, 0, 2) }}
                                        </span>
                                    </div>
                                @endif
                                <h3 class="text-lg font-medium">{{ $profile->name }}</h3>
                                <p class="text-gray-500 dark:text-gray-400">{{ $profile->email }}</p>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</h4>
                                    <p class="mt-1">{{ $profile->created_at->format('F j, Y') }}</p>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h4>
                                    <p class="mt-1">{{ $profile->updated_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button onclick="window.history.back()" type="button">
                            {{ __('Back') }}
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
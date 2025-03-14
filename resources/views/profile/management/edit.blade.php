<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('profile.management.update', $profile) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                @if($profile->avatar)
                                    <img class="h-16 w-16 object-cover rounded-full" src="{{ Storage::url($profile->avatar) }}" alt="{{ $profile->user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400 text-lg font-medium">
                                            {{ substr($profile->user->name, 0, 2) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="avatar" :value="__('Avatar')" />
                                <input type="file" id="avatar" name="avatar" class="mt-1 block w-full" accept="image/*">
                                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="bio" :value="__('Bio')" />
                            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('bio', $profile->bio) }}</textarea>
                            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $profile->phone)" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $profile->address)" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $profile->city)" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="state" :value="__('State')" />
                                <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $profile->state)" />
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $profile->country)" />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="postal_code" :value="__('Postal Code')" />
                                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $profile->postal_code)" />
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="timezone" :value="__('Timezone')" />
                                <select id="timezone" name="timezone" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    @foreach(timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}" {{ old('timezone', $profile->timezone) == $timezone ? 'selected' : '' }}>
                                            {{ $timezone }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="language" :value="__('Language')" />
                                <select id="language" name="language" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="en" {{ old('language', $profile->language) == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="pt-BR" {{ old('language', $profile->language) == 'pt-BR' ? 'selected' : '' }}>Português (Brasil)</option>
                                    <option value="es" {{ old('language', $profile->language) == 'es' ? 'selected' : '' }}>Español</option>
                                </select>
                                <x-input-error :messages="$errors->get('language')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="theme" :value="__('Theme')" />
                                <select id="theme" name="theme" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="light" {{ old('theme', $profile->theme) == 'light' ? 'selected' : '' }}>Light</option>
                                    <option value="dark" {{ old('theme', $profile->theme) == 'dark' ? 'selected' : '' }}>Dark</option>
                                </select>
                                <x-input-error :messages="$errors->get('theme')" class="mt-2" />
                            </div>

                            <div>
                                <div class="flex items-center mt-4">
                                    <input id="notifications_enabled" name="notifications_enabled" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('notifications_enabled', $profile->notifications_enabled) ? 'checked' : '' }}>
                                    <x-input-label for="notifications_enabled" :value="__('Enable Notifications')" class="ml-2" />
                                </div>
                                <x-input-error :messages="$errors->get('notifications_enabled')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

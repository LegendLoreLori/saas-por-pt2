<section
    class="py-4 bg-gray-600 text-gray-50 dark:text-white px-4 rounded-lg mb-4 flex flex-row justify-center sm:justify-between items-center">
    <div class="flex flex-col">
        <h2 class="text-3xl font-semibold">Management Area</h2>
        <nav x-data="{ open: false }"
             class="flex flex-col sm:flex-row justify-center items-center sm:justify-around">
            {{-- I don't know what class "group" is and I actually just hate tailwind, so these are good enough --}}
            <x-nav-link :href="route('listings.manage')" :active="request()->routeIs
                ('listings.manage')" class="group">
                {{ __('Listings') }}
            </x-nav-link>
            <x-nav-link :href="route('users.index')" :active="request()->routeIs
                ('users.*')" class="group">
                {{ __('Users') }}
            </x-nav-link>
        </nav>
    </div>
    <i class="hidden sm:block fa fa-user-tie text-5xl"></i>
</section>

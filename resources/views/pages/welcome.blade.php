<x-app-layout>

    @canany(['manage-listings, manage-staff', 'manage-clients'])
    @else
    <x-slot name="topBanner">
        <section class="bg-blue-900 text-white py-6 text-center">
            <div class="container mx-auto">
                <h2 class="text-3xl font-semibold">Unlock Your Career Potential</h2>
                <p class="text-lg mt-2">
                    Discover the perfect job opportunity for you.
                </p>
            </div>
        </section>
    </x-slot>

    <x-slot name="showcase">
        <section
            class="showcase relative bg-cover bg-center bg-no-repeat h-72 flex items-center">
            <div class="overlay"></div>
            <div class="container mx-auto text-center z-10">
                <h2 class="text-4xl text-white font-bold mb-4">Find Your Dream Job</h2>
                <form class="mb-4 block mx-5 md:mx-auto">
                    <input type="text"
                           name="keywords"
                           placeholder="Keywords"
                           class="w-full md:w-auto mb-2 px-4 py-2 focus:outline-none"/>
                    <input type="text"
                           name="location"
                           placeholder="Location"
                           class="w-full md:w-auto mb-2 px-4 py-2 focus:outline-none"/>
                    <button class="w-full md:w-auto bg-blue-500 hover:bg-blue-600
                                   text-white px-4 py-2 focus:outline-none">
                        <i class="fa fa-search"></i> Search
                    </button>
                </form>
            </div>
        </section>
    </x-slot>
    @endcanany

    <!-- Main Content -->
    <section>
        <div class="text-center text-3xl mb-4 border border-gray-300 font-bold p-3
                    bg-gray-200 dark:bg-gray-500 text-black dark:text-white/80 rounded-lg">
            Recent Jobs
        </div>

        <div class="container mx-auto p-4 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                @foreach($listings as $listing)
                    <div class="rounded-lg shadow-md bg-white max-h-128 overflow-hidden">
                        <div class="p-4 flex flex-col h-full">
                            <h2 class="text-xl font-semibold">{{$listing->title}}</h2>
                            <p class="text-gray-700 text-lg mt-2 overflow-hidden text-ellipsis md:h-48">
                                {{ $listing->description }}
                            </p>
                            <ul class="my-4 bg-gray-100 p-4 rounded flex-grow">
                                <li class="mb-2">
                                    <strong>Salary: </strong>{{$listing->salary}}
                                </li>
                                <li class="text-nowrap mb-2 overflow-hidden text-ellipsis">
                                    <strong>Location: </strong>{{ $listing->city }}, {{ $listing->address }}
                                </li>
                                @if(!empty($listing->tags))
                                    <li class="mb-2">
                                        <strong>Tags: </strong> {{ $listing->tags }}
                                    </li>
                                @endif
                            </ul>
                            <a href="{{ route('listings.show', $listing )}}"
                               class="block w-full text-center px-5 py-2.5 shadow-sm
                    rounded border text-base font-medium text-indigo-700
                    bg-indigo-100 hover:bg-indigo-200 mt-auto">
                                Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <a href="{{ route('listings.index') }}" class="block text-xl text-center dark:text-white pb-4 ">
            <i class="fa fa-arrow-alt-circle-right"></i>
            Show All Jobs
        </a>
    </section>


</x-app-layout>

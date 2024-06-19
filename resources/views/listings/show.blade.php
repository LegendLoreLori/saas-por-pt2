<x-app-layout>
    <article class="container mx-auto max-w-7xl">
        <header
            class="py-4 bg-gray-600 text-gray-200 px-4 rounded-t-lg mb-4 flex flex-row justify-between items-center">
            <div>
                <h2 class="text-3xl font-semibold">Management Area</h2>
                <h3 class="text-2xl">User Details</h3>
            </div>
            <i class="fa fa-user text-5xl"></i>
        </header>

        @if(Session::has('success'))
            <section id="Messages" class="my-4 px-4">
                <div
                    class="p-4 border-green-500 bg-green-100 text-green-700 rounded-lg">
                    {{Session::get('success')}}
                </div>
            </section>
        @endif

        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach

        <section class="container mx-auto p-4 mt-4">
            <div class="rounded-lg shadow-md bg-white p-3">
                <div class="flex flex-col md:flex-row p-2 justify-between items-center md:items-stretch">
                    <a class="block p-2 text-blue-700" href="{{route('listings.index')}}">
                        <i class="fa fa-arrow-alt-circle-left"></i>
                        Back To Listings
                    </a>
                    <div class="flex space-x-4">
                        <!-- Edit and Delete Form -->
                        @if(Gate::allows('manage-listing', $listing))
                            <form
                                class="flex flex-col md:flex-row gap-2 pr-2"
                                action="{{ route('listings.delete', $listing) }}"
                                method="GET">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('listings.edit', $listing) }}"
                                   class="sm:py-2 px-6 text-center rounded-md
                                      text-purple-600 hover:text-purple-200 dark:hover:text-black bg-purple-200 dark:bg-black hover:bg-purple-500
                                      duration-300 ease-in-out transition-all">
                                    <i class="fa fa-save text-lg"></i>
                                    <span>Edit</span>
                                </a>

                                <button type="submit"
                                        class="p-1 px-2 text-center rounded-md
                                           text-red-600 hover:text-red-200 dark:hover:text-black bg-red-200 dark:bg-black hover:bg-red-500
                                           duration-300 ease-in-out transition-all">
                                    <i class="fa fa-trash text-lg"></i>
                                    <span>Delete</span>
                                </button>

                            </form>
                        @endif
                        <!-- End Delete Form -->
                    </div>
                </div>
                <div class="p-4">
                    <h2 class="text-xl font-semibold"> {{ $listing->title }}</h2>
                    <p class="text-gray-700 text-lg mt-2">
                        {{ $listing->description }}
                    </p>
                    <ul class="my-4 bg-gray-100 p-4">
                        <li class="mb-2">
                            <strong>Salary:</strong> {{ $listing->salary }}
                        </li>
                        <li class="mb-2">
                            <strong>Location:</strong> {{  $listing->city }}, {{ $listing->address }}
                        </li>
                        @if(!empty($listing->tags))
                            <li class="mb-2">
                                <strong>Tags:</strong> {{$listing->tags}}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>

        <section class="container mx-auto p-4">
            <h2 class="text-xl font-semibold mb-4">Job Details</h2>
            <div class="rounded-lg shadow-md bg-white p-4">
                <h3 class="text-lg font-semibold mb-2 text-blue-500">
                    Job Requirements
                </h3>
                <p>
                    {{ $listing->requirements }}
                </p>
                <h3 class="text-lg font-semibold mt-4 mb-2 text-blue-500">
                    Benefits</h3>
                <p>{{ $listing->benefits }}</p>
            </div>
            <p class="my-5 dark:text-white">
                Put "Job Application" as the subject of your email and
                attach your
                resume.
            </p>
            <a
                href="mailto:{{ $listing->email }}"
                class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium cursor-pointer text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
            >
                Apply Now
            </a>
        </section>
    </article>
</x-app-layout>

<x-app-layout>
    <article class="container mx-auto max-w-7xl">
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
                <div class="flex flex-col md:flex-row p-2 justify-between items-center md:items-stretch bg-red-200 rounded">
                        <p class="block p-2 text-red-600">Are you sure you want to delete this listing?</p>
                    <div class="flex space-x-4">
                        {{--                        TODO: add authorisation--}}
                        {{--                        <?php if (Framework\Authorisation::isOwner($listing->user_id)): ?>--}}
                        <!-- Delete Form -->
                        <form method="POST"
                              action="{{ route('listings.destroy', $listing) }}"
                              method="POST"
                                class="flex flex-col md:flex-row gap-2 pr-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="sm:py-2 px-2 text-center rounded-md
                                           text-red-600 hover:text-red-200 dark:hover:text-black bg-red-200 dark:bg-black hover:bg-red-500
                                           duration-300 ease-in-out
                                           transition-all">
                                <i class="fa fa-trash text-lg"></i>
                                <span>Confirm</span>
                            </button>
                            <a href="{{ route('listings.show', $listing) }}"
                               class="sm:py-2 px-6 flex items-center rounded-md
                                      text-blue-600 hover:text-blue-200 dark:hover:text-black bg-blue-200 dark:bg-black hover:bg-blue-500
                                      duration-300 ease-in-out transition-all">
                                <i class="fa fa-arrow-left text-lg"></i>
                                <span>Back</span>
                            </a>
                        </form>
                        <!-- End Delete Form -->
                        {{--                        <?php endif; ?>--}}
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
                            <strong>Location:</strong> {{  $listing->city }}
                            , {{ $listing->state }}
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
            <h2 class="text-xl dark:text-white font-semibold mb-4">Job Details</h2>
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
        </section>
    </article>
</x-app-layout>

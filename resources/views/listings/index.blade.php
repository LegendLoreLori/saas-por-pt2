<x-app-layout>
    <article class="container mx-auto max-w-7xl">
        @canany(['manage-staff', 'manage-clients'])
        @else
            <header
                class="py-4 bg-gray-600 text-gray-200 px-4 rounded-lg mb-4 flex flex-row justify-between items-center">
                <div>
                    <h2 class="text-3xl font-semibold">Listings</h2>
                </div>
            </header>
        @endcanany

        @if(Session::has('success'))
            <section id="Messages" class="my-4 px-4">
                <div
                    class="p-4 border-green-500 bg-green-100 text-green-700 rounded-lg">
                    {{Session::get('success')}}
                </div>
            </section>
        @endif
        <section>
            <div class="container mx-auto p-4 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    @foreach($listings as $listing)
                        <div
                            class="rounded-lg shadow-md bg-white max-h-128 overflow-hidden">
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
                                        <strong>Location: </strong>{{ $listing->city }}
                                        , {{ $listing->address }}
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

            <div>
                <div class="border border-gray-200
                           dark:border-gray-700 dark:text-gray-400">
                    <div class="py-2 px-2">{{
                    $listings->links() }}</div>
                </div>
            </div>

        </section>

    </article>
</x-app-layout>

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

        @if($errors->count()>0)
            <section
                class="bg-red-200 text-red-800 mx-4 my-2 px-4 py-2 flex flex-col gap-1 rounded border-red-600">
                <p>We have noted some data entry issues, please update and
                    resubmit.</p>
            </section>
        @endif

        <section class="flex justify-center items-center mt-20">
            <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
                <h2 class="text-4xl text-center font-bold mb-4">Edit Job
                    Listing</h2>
                <form method="POST" action="{{ route('listings.update', $listing) }}">

                    @csrf
                    @method('patch')

                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                        Job Info
                    </h2>

                    {{--                    There would be a proper way to receive the current User's ID but this will do for now--}}
                    <fieldset class="hidden">
                        <input
                            type="text"
                            name="user_id"
                            value="1">
                    </fieldset>
                    @error("user_id")
                    <span class="text-gray-500 col-span-2"></span>
                    <p class="small text-red-500 col-span-5 text-sm">{{ $message }}</p>
                    @enderror

                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="title"
                            placeholder="Job Title"
                            value="{{ old('title') ?? $listing->title }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                        @error("title")
                        <span class="text-gray-500 col-span-2"></span>
                        <p class="small text-red-500 col-span-5 text-sm">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <textarea
                        name="description"
                        placeholder="Job Description"
                        class="w-full px-4 py-2 border rounded focus:outline-none"
                    >{{ old('description') ?? $listing->description }}</textarea>
                    <fieldset class="mb-4">
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="salary"
                            placeholder="Annual Salary"
                            value="{{ old('salary') ?? $listing->salary }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <textarea
                            type="text"
                            name="requirements"
                            placeholder="Requirements"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        >{{ old('requirements') ?? $listing->requirements }}</textarea>
                    </fieldset>
                    <fieldset class="mb-4">
                        <textarea
                            type="text"
                            name="benefits"
                            placeholder="Benefits"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        >{{ old('benefits') ?? $listing->benefits }}</textarea>
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="tags"
                            placeholder="Tags"
                            value="{{ old('tags') ?? $listing->tags }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                        Company Info & Location
                    </h2>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="company"
                            placeholder="Company Name"
                            value="{{ old('company') ?? $listing->company }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="address"
                            placeholder="Address"
                            value="{{ old('address') ?? $listing->address }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="city"
                            placeholder="City"
                            value="{{ old('city') ?? $listing->city }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="state"
                            placeholder="State"
                            value="{{ old('state') ?? $listing->state }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="phone"
                            placeholder="Phone"
                            value="{{ old('phone') ?? $listing->phone }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="email"
                            name="email"
                            placeholder="Email Address For Applications"
                            value="{{ old('email') ?? $listing->email }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                        />
                    </fieldset>
                    <fieldset class="mb-4 flex flex-col gap-2">
                        <button type="submit"
                                class="p-2 px-4 text-center rounded-md w-full
                                      text-green-600 hover:text-green-200 dark:hover:text-black bg-green-200 dark:bg-black hover:bg-green-500
                                      duration-300 ease-in-out transition-all">
                            <i class="fa fa-save text-lg"></i>
                            {{ __('Save changes') }}
                        </button>
                        <a href="{{ route('listings.show', $listing) }}"
                           class="p-2 px-4 text-center rounded-md w-full
                                      text-blue-600 hover:text-blue-200 dark:hover:text-black bg-blue-200 dark:bg-black hover:bg-blue-500
                                      duration-300 ease-in-out transition-all">
                            <i class="fa fa-arrow-left text-lg"></i>
                            {{ __('Cancel') }}
                        </a>
                    </fieldset>
                </form>
            </div>
        </section>
    </article>
</x-app-layout>

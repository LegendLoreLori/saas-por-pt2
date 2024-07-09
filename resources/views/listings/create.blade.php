<x-app-layout>
    <article class="container mx-auto max-w-7xl">
        @canany(['manage-staff', 'manage-clients'])
        @else
            <header
                class="py-4 bg-gray-600 text-gray-200 px-4 rounded-lg mb-4 flex flex-row justify-between items-center">
                <div>
                    <h2 class="text-3xl font-semibold">Create Listing</h2>
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
                <h2 class="text-4xl text-center font-bold mb-4">Create Job
                    Listing</h2>
                <form method="POST" action="{{ route('listings.store') }}">

                    @csrf

                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                        Job Info
                    </h2>

                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="title"
                            placeholder="Job Title"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('title') }}"
                        />
                        @error("title")
                        <span class="text-gray-500 col-span-2"></span>
                        <p class="small text-red-500 col-span-5 text-sm">{{ $message }}</p>
                        @enderror
                    </fieldset>
                    <fieldset class="mb-4">
            <textarea
                name="description"
                placeholder="Job Description"
                class="w-full px-4 py-2 border rounded focus:outline-none"
            >{{ old('description') }}</textarea>
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="salary"
                            placeholder="Annual Salary"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('salary') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="requirements"
                            placeholder="Requirements"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('requirements') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="benefits"
                            placeholder="Benefits"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('benefits') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="tags"
                            placeholder="Tags"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('tags') }}"
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
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('company') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="address"
                            placeholder="Address"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('address') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="city"
                            placeholder="City"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('city') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="state"
                            placeholder="State"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('state') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="text"
                            name="phone"
                            placeholder="Phone"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('phone') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4">
                        <input
                            type="email"
                            name="email"
                            placeholder="Email Address For Applications"
                            class="w-full px-4 py-2 border rounded focus:outline-none"
                            value="{{ old('email') }}"
                        />
                    </fieldset>
                    <fieldset class="mb-4 flex flex-col gap-2">
                        <button type="submit"
                                class="p-2 px-4 text-center rounded-md w-full
                                      text-green-600 hover:text-green-200 dark:hover:text-black bg-green-200 dark:bg-black hover:bg-green-500
                                      duration-300 ease-in-out transition-all">
                            <i class="fa fa-save text-lg"></i>
                            {{ __('Create') }}
                        </button>
                        <a href="{{ route('listings.index') }}"
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

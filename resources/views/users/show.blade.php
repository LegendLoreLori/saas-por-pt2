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


        <section
            class="flex flex-col gap-4 p-4">
            <div class="grid grid-cols-12">
                <p class="col-span-12 md:col-span-2 xl:col-span-1 text-gray-500">
                    Name</p>
                <p class="col-span-12 md:col-span-10 xl:col-span-11
                dark:text-white">{{
                $user->name }}</p>
            </div>

            <div class="grid grid-cols-12">
                <p class="col-span-12 md:col-span-2 xl:col-span-1 text-gray-500">
                    Email</p>
                <p class="col-span-12 md:col-span-10 xl:col-span-11
                dark:text-white">{{ $user->email }}</p>
            </div>

            <div class="grid grid-cols-12">
                <p class="col-span-12 md:col-span-2 xl:col-span-1 text-gray-500">
                    Last Login</p>
                <p class="col-span-12 md:col-span-10 xl:col-span-11 dark:text-white">{{ $user->login_at ?? "---" }}</p>
            </div>

            <div class="grid grid-cols-12">
                <p class="col-span-12 md:col-span-2 xl:col-span-1 text-gray-500">
                    Status</p>
                <p class="col-span-12 md:col-span-10 xl:col-span-11 dark:text-white">{{ $user->status ?? "---" }}</p>
            </div>

            <div class="grid grid-cols-12">
                <p class="col-span-12 md:col-span-2 xl:col-span-1 text-gray-500">
                    Actions</p>
                <form
                    class="col-span-12 md:col-span-10 xl:col-span-11 flex flex-row gap-2 items-center "
                    action="{{ route('users.delete', $user) }}"
                    method="GET">
                    @csrf
                    @method('DELETE')

                    <a href="{{ route('users.index') }}"
                       class="p-1 px-6 text-center rounded-md
                                      text-blue-600 hover:text-blue-200 dark:hover:text-black bg-blue-200 dark:bg-black hover:bg-blue-500
                                      duration-300 ease-in-out transition-all">
                        <i class="fa fa-arrow-left text-lg"></i>
                        <span>Back</span>
                    </a>

                    <a href="{{ route('users.edit', $user) }}"
                       class="p-1 px-6 text-center rounded-md
                                      text-purple-600 hover:text-purple-200 dark:hover:text-black bg-purple-200 dark:bg-black hover:bg-purple-500
                                      duration-300 ease-in-out transition-all">
                        <i class="fa fa-save text-lg"></i>
                        <span>Edit</span>
                    </a>
                    @can('delete', $user)
                        <button type="submit"
                                class="p-1 px-2 text-center rounded-md
                                       text-red-600 hover:text-red-200 dark:hover:text-black bg-red-200 dark:bg-black hover:bg-red-500
                                       duration-300 ease-in-out transition-all">
                            <i class="fa fa-trash text-lg"></i>
                            <span>Delete</span>
                        </button>
                    @else
                        <div class="p-1 px-2 text-center rounded-md
                                   text-gray-600 bg-gray-200 dark:bg-black">
                            <i class="fa fa-trash text-lg"></i>
                            <span>Delete</span>
                        </div>
                    @endcan

                </form>
            </div>

        </section>
    </article>
</x-app-layout>

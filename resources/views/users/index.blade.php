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

        <section class="px-4 pb-8">
            <header class="flex flex-row justify-between items-center gap-2">
                <p class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Browse') }}
                </p>
                <section class="flex flex-row justify-between gap-4">
                    <a href="{{ route('users.create') }}"
                       class="p-2 px-4 text-center rounded-md h-10
                              text-blue-600 hover:text-blue-200 bg-blue-200 hover:bg-blue-500
                              duration-300 ease-in-out transition-all">
                        <i class="fa fa-user-plus font-xl"></i>
                        {{ __('New User') }}
                    </a>
                    @canany(['user-trash-recover', 'user-trash-remove',
                             'user-trash-recover-all', 'user-trash-empty'])
                    <a href="{{ route('users.trash') }}"
                       class="p-2 px-4 text-center rounded-md h-10
                              text-slate-600 hover:text-slate-200 bg-slate-200 hover:bg-slate-500
                              duration-300 ease-in-out transition-all space-x-2">
                        <i class="fa fa-trash font-xl"></i>
                    </a>
                    @endcanany
                </section>
            </header>

            <table class="mt-4 table bg-white dark:bg-gray-800
                          overflow-hidden shadow-sm sm:rounded-lg
                          border border-gray-600 dark:border-gray-700 w-full">

                <thead class="py-1 px-2 bg-gray-700 text-gray-200 ">
                {{-- This design is pretty bad for mobile --}}
                <tr class="bg-gray-400 text-gray-800 py-2 rounded-lg ">
                    <th class="pl-2 flex-0 text-left">Name</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Role</th>
                    <th class="text-left">Last Update</th>
                    <th class="pr-2 text-right">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr class="group
                               hover:bg-gray-200 dark:hover:bg-gray-900 ease-in-out duration-300 transition-all
                               border border-gray-200 dark:border-gray-700
                               dark:text-gray-400">

                        <td class="py-2 pl-2 flex-0 text-left">{{ $user->name }}</td>
                        <td class="py-2 text-left">{{ $user->email }}</td>
                        <td class="py-2 flex-col text-left">
                            @foreach($user->roles as $role)
                                {{ucfirst($role->name)}}
                            @endforeach
                        </td>
                        <td class="py-2 text-left">{{ $user->updated_at }}</td>
                        <td class="py-2 pr-2 text-right">
                            <form
                                class="flex flex-row gap-2 items-center justify-end"
                                action="{{ route('users.destroy', $user) }}"
                                method="POST">
                                @csrf
                                @method("DELETE")
                                <a href="{{ route('users.show', $user) }}"
                                   class="p-1 w-10 text-center rounded-md
                                          text-blue-600 hover:text-blue-200 dark:hover:text-black bg-blue-200 dark:bg-black hover:bg-blue-500
                                          duration-300 ease-in-out transition-all">
                                    <i class="fa fa-eye text-lg"></i>
                                    <span class="sr-only hidden">View</span>
                                </a>
                                @can('edit', $user)
                                <a href="{{ route('users.edit', $user) }}"
                                   class="p-1 w-10 text-center rounded-md
                                          text-purple-600 hover:text-purple-200 dark:hover:text-black bg-purple-200 dark:bg-black hover:bg-purple-500
                                          duration-300 ease-in-out transition-all">
                                    <i class="fa fa-pen text-lg"></i>
                                    <span class="sr-only">Edit</span>
                                </a>
                                @else
                                    <div class="p-1 w-10 text-center rounded-md
                                               text-gray-600 bg-gray-200 dark:bg-black">
                                        <i class="fa fa-pen text-lg"></i>
                                        <span class="sr-only">Edit</span>
                                    </div>
                                @endcan
                                @can('delete', $user)
                                    <button type="submit"
                                            class="p-1 w-10 text-center rounded-md
                                               text-red-600 hover:text-red-200 dark:hover:text-black bg-red-200 dark:bg-black hover:bg-red-500
                                               duration-300 ease-in-out transition-all">
                                        <i class="fa fa-trash text-lg"></i>
                                        <span class="sr-only">Delete</span>
                                    </button>
                                @else
                                    <div class="p-1 w-10 text-center rounded-md
                                               text-gray-600 bg-gray-200 dark:bg-black">
                                        <i class="fa fa-trash text-lg"></i>
                                        <span class="sr-only">Delete</span>
                                    </div>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr class="border border-gray-200
                           dark:border-gray-700 dark:text-gray-400">
                    <td colspan="4" class="py-2 px-2">{{
                    $users->links() }}</td>
                </tr>
                </tfoot>
            </table>

        </section>
    </article>
</x-app-layout>

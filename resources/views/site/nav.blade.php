<div class="p-4 flex flex-row justify-between items center">
    <div class="text-xl font-semibold">Laravel DFW</div>

    <div class="flex flex-row justify-end items-center">
        <a class="rounded p-2 bg-sky-600 hover:bg-sky-700 text-white hover:text-gray-200 mr-4"
           target="_blank"
           href="https://www.meetup.com/laravel-dallas-fort-worth/">
            Meetup Group
        </a>
        @guest
        <a class="rounded p-2 bg-sky-600 hover:bg-sky-700 text-white hover:text-gray-200 mr-4" href="/login">Login</a>
        <a class="rounded p-2 bg-sky-600 hover:bg-sky-700 text-white hover:text-gray-200" href="/register">Register</a>
        @endguest
        @auth
        <a class="rounded p-2 bg-sky-600 hover:bg-sky-700 text-white hover:text-gray-200" href="/account">Account</a>
        @endauth
    </div>
</div>

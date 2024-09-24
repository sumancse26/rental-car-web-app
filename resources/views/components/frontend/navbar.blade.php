<nav class="bg-sky-800 p-4 fixed w-full z-10 top-0">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo -->
        <a href="#" class="text-white text-2xl font-bold">CarRental</a>

        <!-- Navigation Links -->
        <ul class="hidden md:flex space-x-6">
            <li><a href="/" class="text-white hover:text-yellow-600 transition">Home</a></li>
            <li><a href="{{ route('frontend.car') }}" class="text-white hover:text-yellow-600 transition">Cars</a></li>
            <li><a href="{{ route('frontend.rentals') }}" class="text-white hover:text-yellow-600 transition">Rentals</a>
            </li>
            <li><a href="{{ route('frontend.bookings') }}"
                    class="text-white hover:text-yellow-600 transition">Bookings</a>
            </li>
        </ul>


        <div class="hidden md:flex items-center space-x-4">
            <a href="{{ route('auth.login') }}"
                class="text-white bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600 transition">Login
            </a>
            <a href="{{ route('user.add') }}"
                class="text-white bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600 transition">Sign
                Up</a>

            <a href="{{ route('user.logout') }}"
                class="text-white bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600 transition">Logout</a>
            <a href="{{ route('dashboard') }}"
                class="text-white bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600 transition">Dashboard</a>

        </div>
    </div>
</nav>

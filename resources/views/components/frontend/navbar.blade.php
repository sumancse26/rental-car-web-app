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

        <!-- User Section -->
        <div class="hidden md:flex items-center space-x-4">
            <a href="#" class="text-white bg-yellow-500 px-4 py-2 rounded hover:bg-yellow-600 transition">Login /
                Sign Up</a>
            <!-- Uncomment for profile dropdown when logged in -->
            <!--
            <div class="relative group">
                <img src="profile.jpg" alt="Profile" class="w-8 h-8 rounded-full cursor-pointer">
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden group-hover:block">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Bookings</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
            -->
        </div>
    </div>
</nav>

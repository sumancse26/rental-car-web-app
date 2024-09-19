<nav aria-label="alternative nav">
    <div class="bg-gray-800 shadow-xl h-20 fixed bottom-0  md:relative md:h-screen z-10 w-full md:w-48 content-center">
        <div
            class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
            <ul class=" flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">

                <li class="mr-3 flex-1">
                    <a href="{{ route('home') }}"
                        class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                        <i class="fas fa-tasks pr-0 md:pr-3"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Home</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('user.list') }}"
                        class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                        <i class="fa fa-user pr-0 md:pr-3"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">User</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('car.list') }}"
                        class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">

                        <i class="fas fa-car pr-0 md:pr-3"></i>
                        <span
                            class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Car</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('rental.list') }}"
                        class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                        <i class="fa fa-wallet pr-0 md:pr-3"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Rental</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="w-screen mx-auto flex items-center justify-center my-32">
    <form class=" w-2/3 p-5 border-2 border-gray-300 rounded-lg shadow-lg" method="POST"
        action="{{ route('rental.addFromFrontend', ['id' => $rental->id]) }}" enctype="multipart/form-data">
        @csrf
        <h4 class="font-bold text-center pb-2">Book</h4>
        <div class="flex items-center justify-around gap-3">
            <div class="flex flex-col mb-4">
                <label class="text-sm text-gray-600 mb-2" for="start-date">Select Car</label>
                <select id="select" name="selected_car"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pl-10 h-10"
                    onchange="getSelectedCar(this)">
                    <option value="" disabled selected>Select a car</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car }}" @selected($car)>{{ $car->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col mb-4">
                <label class="text-sm text-gray-600 mb-2" for="start-date">Start Date</label>
                <input type="date" id=start_date name="start_date" value="{{ $rental->start_date }}"
                    onchange="getSelectedCar(document.getElementById('select'))"
                    class="py-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="flex flex-col mb-4">
                <label class="text-sm text-gray-600 mb-2" for="start-date">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ $rental->end_date }}"
                    onchange="getSelectedCar(document.getElementById('select'))"
                    class="py-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </div>

        <div class="flex flex-wrap justify-between mb-4">
            <div class="w-1/2 md:w-1/3 xl:w-1/4">

                <label class="block text-gray-600">Car Model:</label>
                <p name="car_model" id="car_model" class="text-lg font-bold">{{ $rental->car->model }}</p>
            </div>
            <div class="w-1/2 md:w-1/3 xl:w-1/4">
                <label class="block text-gray-600">Rent:</label>
                <p name="rent" id="rent" class="text-lg font-bold"> {{ $rental->car->daily_rent_price }}</p>
            </div>
            <div class="w-1/2 md:w-1/3 xl:w-1/4">

                <label class="block text-gray-600">Total Cost:</label>
                <p name="total_cost" id="total_cost" class="text-lg font-bold"> {{ $rental->total_cost }}</p>
            </div>
        </div>



        <div class="flex justify-center gap-2">
            <a href="{{ route('home') }}"
                class="mt-5 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Cancel</a>

            <button type="submit"
                class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Book
            </button>
        </div>

    </form>
</div>

<script>
    function getSelectedCar(selectElement) {
        const car = JSON.parse(selectElement.value);
        document.getElementById('car_model').innerHTML = car.model;
        document.getElementById('rent').innerHTML = car.daily_rent_price;
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        const totalHour = (new Date(endDate).getTime() - new Date(startDate).getTime()) / (1000 * 3600);

        document.getElementById('total_cost').innerHTML = car.daily_rent_price * totalHour;


    }
</script>

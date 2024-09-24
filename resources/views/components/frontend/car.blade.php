<!-- Blade Template -->
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center">Welcome to Our Car Rental Service</h1>
    <p class="text-center mt-2">Find the perfect car for your next adventure!</p>

    <div class="mt-8 flex justify-center">
        <input type="text" id="search-input" placeholder="Search by car type, brand..."
            class="border border-gray-300 rounded-lg p-2">
        <button class="bg-blue-500 text-white rounded-lg px-4 ml-2" onclick="searchCar()">Search</button>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($cars as $car)
            <div class="border rounded-lg overflow-hidden shadow-lg car">
                <img src="{{ $car->image }}" alt="Car Image" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="font-semibold">{{ $car->name }}</h2>
                    <p>{{ $car->brand }}</p>
                    <p>${{ number_format($car->daily_rent_price, 2) }} per day</p>
                    <a href="{{ route('rental.bycar', $car->id) }}"
                        class="bg-green-500 text-white rounded-lg px-4 py-1 mt-2">Book Now</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function searchCar() {
        const input = document.getElementById('search-input');
        const value = input.value.toLowerCase();
        const cars = document.querySelectorAll('.car');

        cars.forEach(car => {
            if (car.innerText.toLowerCase().includes(value)) {
                car.style.display = 'block';
            } else {
                car.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('search-input');
        if (input) {
            input.addEventListener('input', searchCar);
        }
    });
</script>

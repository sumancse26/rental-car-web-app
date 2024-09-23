<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold">Available Rentals</h1>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($cars as $car)
            <div class="border rounded-lg overflow-hidden shadow-lg">
                <img src="{{ $car->image }}" alt="Car Image" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="font-semibold">{{ $car->name }}</h2>
                    <p>{{ $car->brand }}</p>
                    <p>{{ $car->daily_rent_price }}</p>
                    <a href="{{ route('rental.bycar', $car->id) }}"
                        class="bg-green-500 text-white rounded-lg px-4 py-1 mt-2">Book Now</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

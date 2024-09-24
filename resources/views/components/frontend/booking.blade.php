<div class="container mx-auto px-4 py-8 mt-12">
    <div class="mt-4">
        <h2 class="text-xl font-semibold">Current Bookings</h2>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($bookings as $booking)
                <div class="border rounded-lg overflow-hidden shadow-lg car">
                    <div class="p-4">
                        <p>{{ $booking->car->name }}</p>
                        <p>{{ $booking->start_date }}to {{ $booking->end_date }}</p>
                        <p>{{ $booking->daily_rent_price }}</p>
                        @if ($booking->status == 'pending')
                            <p class="text-red-600">{{ $booking->status }}</p>
                        @elseif ($booking->status == 'ongoing')
                            <p class="text-blue-600">{{ $booking->status }}</p>
                        @elseif ($booking->status == 'completed')
                            <p class="text-green-500">{{ $booking->status }}</p>
                        @else
                            <p class="text-red-600">{{ $booking->status }}</p>
                        @endif

                        @if ($booking->status == 'ongoing')
                            <div class="mt-2">
                                <a href="{{ route('rental.cancelFromFrontend', $booking->id) }}"
                                    class="bg-red-500 text-white rounded-lg px-2 py-1 mt-2">Cancel</a>

                                <a href="{{ route('rental.completeFromFrontend', $booking->id) }}"
                                    class="bg-green-500 text-white rounded-lg px-2 py-1 mt-2">Complete
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

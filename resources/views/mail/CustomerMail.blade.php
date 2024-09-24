<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Rental Confirmation</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Car Rental Confirmation</h1>
            <p class="mb-4">Dear <strong>{{ $user->name }}</strong>,</p>
            <p class="mb-4">Thank you for renting a car with us! Here are the details of your rental:</p>

            <div class="mb-4">
                <h2 class="font-semibold">Rental Details:</h2>
                <ul class="list-disc pl-5">
                    <li><strong>Car Model:</strong> {{ $car->model }}</li>
                    <li><strong>Rental Period:</strong> {{ $data->start_date }} to {{ $data->end_date }}</li>
                    <li><strong>Total Amount:</strong> $ {{ $data->total_cost }}</li>
                </ul>
            </div>

            <p class="mb-4">If you have any questions, feel free to contact us.</p>
            <p>Best Regards,<br>Your Car Rental Team</p>
        </div>
    </body>

</html>

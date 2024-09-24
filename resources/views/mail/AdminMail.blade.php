<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Car Rental Notification</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">New Car Rental Notification</h1>
            <p class="mb-4">Hello Admin,</p>
            <p class="mb-4">A new car rental has been made. Here are the details:</p>

            <div class="mb-4">
                <h2 class="font-semibold">Rental Details:</h2>
                <ul class="list-disc pl-5">
                    <li><strong>Customer Name:</strong> {{ $user->name }}</li>
                    <li><strong>Car Model:</strong> {{ $car->model }}</li>
                    <li><strong>Rental Period:</strong> {{ $data->start_date }} to {{ $data->end_date }}</li>
                    <li><strong>Total Amount:</strong> {{ $data->total_cost }}</li>
                </ul>
            </div>

            <p class="mb-4">Please make sure to prepare for the customer's arrival.</p>
            <p>Best Regards,<br>Your Car Rental System</p>
        </div>
    </body>

</html>

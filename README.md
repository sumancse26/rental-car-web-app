
## About The Project

This is a project where customer can rent a car, also can cancel the booking.
The admin user can manipulate Car, Booking and also manipulate customer.

### Built With

* Laravel
* JS
* Tailwind css

<!-- GETTING STARTED -->
## Getting Started

Please follow the instruction to run the project.

### Prerequisites

* npm

  ```sh
  npm install npm@latest -g
  ```

### Installation

1. Clone the repo

   ```sh
   git clone https://github.com/sumancse26/rental-car-web-app.git
   ```

2. Install Composer

   ```sh
   composer install
   ```

3. Install NPM packages

   ```sh
   npm install
   ```

4. Enter your Token encryption Key in `.env` file

   ```
   JWT_KEY = 'aswerDFWKIF0472~[]\Trwbc.';
   ```

5. Login Credential both for admin and user

   ```
   Password = '12345'

   ```

6. Configure Database

   ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=rental_car
    DB_USERNAME=root
    DB_PASSWORD=

   ```

7. Configure Mail

   ```
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=e7e869d864f322
    MAIL_PASSWORD=10d99d1bc4002d
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="<no-replay@suman.com>"
    MAIL_FROM_NAME="Car Rental Web"

   ```

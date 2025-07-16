# Website Tamu Perumahan

Welcome to the Website Tamu Perumahan project! This application is designed to manage guest visits in a residential area, providing a seamless experience for both residents and security personnel.

## Features

- **Guest Management**: Easily add, edit, and remove guest information.
- **Activity Logging**: Track guest activities with detailed logs.
- **Responsive Design**: Access the application on any device with a responsive user interface.
- **User Authentication**: Secure login for residents and security personnel.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/LuthfiMirza/Website-Tamu-Perumahan.git
   ```
2. Navigate to the project directory:
   ```bash
   cd Website-Tamu-Perumahan
   ```
3. Install dependencies:
   ```bash
   composer install
   npm install
   ```
4. Set up the environment:
   - Copy `.env.example` to `.env` and configure your database settings.
   - Generate an application key:
     ```bash
     php artisan key:generate
     ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Access the application at `http://localhost:8000`.
- Log in with your credentials to start managing guest visits.

## Contributing

We welcome contributions! Please fork the repository and submit a pull request for any improvements or bug fixes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

For any inquiries, please contact the project maintainer at [email@example.com](mailto:email@example.com).

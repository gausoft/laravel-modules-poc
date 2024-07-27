# Laravel mini ERP POC

This project is a Proof of Concept (POC) for a mini ERP using Laravel 11 and the `nWidart/laravel-modules` package. The aim of this project is to demonstrate a modular approach with the ability to dynamically activate and deactivate modules, as well as load modules only when they are needed.

## Table of contents

- [Laravel mini ERP POC](#laravel-mini-erp-poc)
  - [Table of contents](#table-of-contents)
  - [Project description](#project-description)
  - [Modules](#modules)
  - [Installation](#installation)
  - [Configuration](#configuration)
  - [Dynamic loading approach](#dynamic-loading-approach)
  - [Usage](#usage)
  - [Contributing](#contributing)
  - [License](#license)

## Project description

This project uses Laravel to create a mini ERP with a modular architecture. The `nWidart/laravel-modules` package is used to manage modules dynamically through artisan commands. The modules include core functionalities such as stock management, sales, finance, human resources (HR), and customer relationship management (CRM).

## Modules

The project includes the following modules:

- **Core**: The central module with basic functionalities.
- **Stock**: Stock management.
- **Sales**: Sales management.
- **Accounting**: Financial management, including accounting.
- **HR**: Human resources management.
- **CRM**: Customer relationship management.

## Installation

To install the project, follow these steps:

1. Clone the repository:

    ```sh
    git clone https://github.com/gausoft/laravel-modules-poc.git
    cd laravel-modules-poc
    ```

2. Install the dependencies using Composer:

    ```sh
    composer install
    ```

3. Configure your `.env` file by copying the example file and modifying the variables as needed:

    ```sh
    cp .env.example .env
    ```

4. Generate the application key:

    ```sh
    php artisan key:generate
    ```

5. Run the migrations to create the necessary tables:

    ```sh
    php artisan migrate
    ```

6. Start the development server:

    ```sh
    php artisan serve
    ```

## Configuration

[TODO]

<!-- After installing the project, you can activate or deactivate modules via the user interface available at `/modules`. Ensure that the modules you wish to activate are marked as active in the database. -->

## Dynamic loading approach

The project uses the `nWidart/laravel-modules` package to manage modules. Modules are dynamically loaded based on their status in the database. Only active modules are loaded, and their routes are registered. Here's how it works:

1. **Module Registration**: Modules are registered in the `AppServiceProvider` using the `registerModules()` method, which checks the status of modules in the database.

2. **Route Registration**: Routes for modules are registered only if the module is active. This is handled in the `registerRoutes()` method of the `AppServiceProvider`.

## Usage

Once the server is running, you can access the module routes via the following API endpoints:

- **Core**: `/api/core`
- **Stock**: `/api/stock`
- **Sales**: `/api/sales`
- **Accounting**: `/api/accounting`
- **HR**: `/api/hr`
- **CRM**: `/api/crm`

Responses from each endpoint should indicate that the corresponding module is active.

## Contributing

Contributions are welcome! Please open an issue or a pull request for any improvements or bug fixes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

# Shopping App - Laravel & Vue.js Demo

This is a simple shopping application built with a Laravel 11 and a Vue.js 3
The application allows users to import products from the Fake Store API, update products via a secure API, and interact with a product listing and cart system.

## Table of Contents

-   [Project Overview](#project-overview)
-   [Tech Stack](#tech-stack)
-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
    -   [Backend Setup (Laravel)](#backend-setup-laravel)
    -   [Frontend Setup (Vue.js)](#frontend-setup-vue.js)
-   [Running the Application](#running-the-application)
-   [Usage](#usage)
-   [Testing](#testing)
    -   [Backend Tests](#backend-tests)
    -   [Frontend Tests](#frontend-tests)
-   [API Documentation](#api-documentation)
-   [Project Structure](#project-structure)
-   [Notes](#notes)

## Project Overview

The application consists of:

-   **Backend**: A Laravel API that:
    -   Imports products from the Fake Store API using a custom Artisan command.
    -   Provides a secure endpoint to update product details (title, description, image, price).
    -   Uses Laravel Sanctum for authentication.
-   **Frontend**: A Vue.js 3 application that:
    -   Displays a product listing with name, price, category, image, and an "Add to Cart" button.
    -   Includes a cart page to view, remove, and (optionally) adjust product quantities, with persistence across page reloads.
    -   Uses Pinia for state management and Bootstrap-Vue for styling.

The focus is on code quality, readability, testability, and reusability, as per the assignment's evaluation criteria.

## Tech Stack

-   **Backend**:
    -   PHP 8.1+
    -   Laravel 11
    -   MySQL
    -   Laravel Sanctum (for authentication)
-   **Frontend**:
    -   Vue.js 3
    -   Pinia (state management)
    -   Bootstrap-Vue (UI components)
    -   Axios (API requests)
-   **Testing**:
    -   PHPUnit (backend)
    -   Vitest (frontend)
-   **Tools**:
    -   Composer
    -   Node.js 18+
    -   npm

## Prerequisites

Before setting up the project, ensure you have the following installed:

-   PHP 8.1 or higher
-   Composer
-   Node.js 18 or higher with npm
-   MySQL 8.0 or higher
-   Git

## Installation

### Backend Setup (Laravel)

1.  **Clone the Repository**:
    
    ```bash
    git clone https://github.com/DarshPhpDev/shopping-app.git
    cd shopping-app
    ```
    
2.  **Install Backend Dependencies**:
    
    ```bash
    composer install
    ```
    
3.  **Configure Environment**:
    
    -   Copy the `.env.example` file to `.env`:
        
        ```bash
        cp .env.example .env
        ```
        
    -   Update the `.env` file with your MySQL database credentials:
        
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=shopping_app
        DB_USERNAME=your_username
        DB_PASSWORD=your_password
        ```
        
    -   Generate an application key:
        
        ```bash
        php artisan key:generate
        ```
        
4.  **Set Up the Database**:
    
    -   Create a MySQL database named `shopping_app`.
        
    -   Run migrations to create the necessary tables:
        
        ```bash
        php artisan migrate
        ```

### Frontend Setup (Vue.js)
        
1.  **Install Frontend Dependencies**:
    
    ```bash
    npm install
    ```

## Running the Application

1.  **Start the Laravel Backend**:
    
    -   In the project root directory:
        
        ```bash
        php artisan serve
        ```
        
2.  **Start the Vue.js Frontend**:
    
    -   In another terminal run:
        
        ```bash
        npm run dev
        ```
        
2.  **Access the Application**:
    
    -   Open `http://localhost:8000` in your browser to view the product listing page.
    - Add some products to cart
    -   Use the navbar to navigate to the cart page.

## Usage

1.  **Import Products**:
    
    -   Run the Artisan command to fetch and sync products from the Fake Store API:
        
        ```bash
        php artisan products:import
        ```
        
    -   This command ensures no duplicates and updates existing products if modified.
        
2.  **Update Products**:
    
    -   Authenticate as a user (register/login via the API or a provided endpoint).
        
    -   Use the API endpoint `PATCH /api/products/{id}` to update product fields (title, description, image, price).
        
    -   Example cURL request:
        
        ```bash
        curl -X PATCH http://localhost:8000/api/products/1 \
          -H "Authorization: Bearer your_token" \
          -H "Content-Type: application/json" \
          -d '{"title":"New Title","description":"New Description","image":"https://example.com/image.jpg","price":29.99}'
        ```
        
3.  **Interact with the Frontend**:
    
    -   **Product Listing**: Browse products, view details (name, price, category, image), and click "Add to Cart".
    -   **Cart Page**: View cart contents, remove items, and adjust quantities. The cart persists across reloads using local storage with Pinia.
    -   **Cart Link**: Check the navbar for the cart link, which displays the number of items.

## Testing

### Backend Tests

-   The backend uses PHPUnit for unit and feature tests, located in `tests/Feature` and `tests/Unit`.
    
-   **Run Backend Tests**:
    
    ```bash
    php artisan test
    ```

### Frontend Tests

-   The frontend uses Vitest for unit tests, located in `resources/js/tests`.
    
-   **Run Frontend Tests**:
    
    ```bash
    npm run test
    ```

## API Documentation

### Authentication Endpoints

#### Register
- **POST** `/api/register`
- **Description**: Create a new user account
- **Body**:
```json
{
    "name": "string",
    "email": "string",
    "password": "string"
}
```
- **Response**: Returns access token on success

#### Login
- **POST** `/api/login`
- **Description**: Authenticate user and get access token
- **Body**:
```json
{
    "email": "string",
    "password": "string"
}
```
- **Response**: Returns access token on success

#### Logout
- **POST** `/api/logout`
- **Description**: Invalidate current access token
- **Headers**: `Authorization: Bearer {token}`
- **Response**: Success message

### Product Endpoints

#### List Products
- **GET** `/api/products`
- **Description**: Get all products
- **Access**: Public
- **Response**: List of products


#### Update Product
- **PUT** `/api/products/{id}`
- **Description**: Update product details
- **Access**: Protected (requires authentication)
- **Headers**: `Authorization: Bearer {token}`
- **Body**:
```json
{
    "title": "string (optional)",
    "description": "string (optional)",
    "price": "number (optional)",
    "image": "string url (optional)"
}
```
- **Response**: Updated product details


## Project Structure

```
shopping-app/
├── app/
│   ├── Console/
│   │   └── Commands/               # Artisan commands (products:import)
│   └── Contracts/                  # Service Contracts
│   └── Http/
│   │   └── Controllers/            # API controllers
│   │   └── Requests/               # Form request validation
│   └── Models/                     # Eloquent models
│   └── Services/                   # Business logic implementation
├── database/
│   ├── factories/                  # Model factories for testing
│   └── migrations/                 # Database migrations
├── resources/
│   └── js/
│       └── api/                    # API integration
│       ├── components/             # Vue components
│       │   ├── ProductList.vue
│       │   ├── CartPage.vue
│       │   └── CartLink.vue
│       └── router/                 # Router
│       ├── stores/                 # Pinia stores
│       │   ├── productStore.js
│       │   └── cartStore.js
│       └── tests/                  # Unit Tests
│       └── utils/                  # Helper Utilities

├── routes/
│   └── api.php                     # API routes
└── tests/
    ├── Feature/                    # Feature tests
    └── Unit/                       # Unit tests
```

## Notes

-   **Authentication**: The product update API requires a valid Sanctum token. Ensure you register a user and obtain a token for testing.
-   **Fake Store API**: The import command relies on `https://fakestoreapi.com/products`. Ensure internet connectivity before running the artisan command.
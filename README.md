Product Management System (Clothing Store)
This is a custom Product Management System built with Laravel 12. It was designed specifically for a clothing store context to handle products, categories, and dynamic attributes like size and color.

It includes a custom Admin Panel (built with Blade and custom HTML/CSS) and a public-facing page with AJAX filtering.

Project Overview
Admin Panel 
a. Custom authentication (Login/Logout) without using Breeze or Jetstream. 
b. Dashboard. 
c. Category Management (Add, Edit, List, Delete). d. Product Management (Image upload, dynamic attributes, status toggle).

Public Interface 
a. Grid view of all active products. 
b. Sidebar filters for Categories, Price Range, and Keyword Search. 
c. Filtering happens via AJAX (no page reloads).

REST API 
a. Full CRUD endpoints for managing products via API.

Requirements:
PHP 8.2 or higher
Composer
MySQL
Node.js and NPM (for assets)

Installation Steps,
Follow these steps to get the project running on your local machine:

Clone the repository git clone [your-repo-url] cd ProductMS
Install PHP dependencies: composer install
Configure Environment :
    a. Copy the example environment file: cp .env.example .env 
    b. Generate the application key: php artisan key:generate
Database Setup 
    a. Open your .env file and update the DB_ settings (DB_DATABASE, DB_USERNAME, etc.). 
    b. Run the migrations to create the tables: php artisan migrate
Seeding Data 
    a. Create the default admin user by running: php artisan db:seed --class=AdminSeeder
The default credentials are: 
    Email: admin@yopmail.com 
    Password: password
Storage Setup a. Link the storage folder so images are accessible publicly: php artisan storage:link
Run the Application: php artisan serve
Then the site will be load via local server

Database Layout
The system uses four main tables:
admins: Stores the custom admin users.
categories: Stores product categories (e.g., Men, Women) with active/inactive status.
products: Main product data including name, price, description, and image path.
product_attributes: Stores dynamic options linked to products (Key: Size, Value: Large).

How to Use
Admin Panel 
    a. Go to http://localhost:8000/admin/login 
    b. Log in with the seed credentials. 
    c. Use the sidebar to navigate between Categories and Products. 
    d. When adding a product, you can click "Add Attribute" to add multiple rows for things like Fabric, Color, or Size.

Public Page 
    a. Go to the homepage http://localhost:8000 
    b. You will see all active products. 
    c. Use the sidebar to filter products. The results update automatically without refreshing the page.

API Endpoints
The system provides a basic REST API for external access.
Base URL: http://localhost:8000/api
GET /api/products Lists all products.
GET /api/products/{id} Gets details for a single product.
POST /api/products Creates a new product. Required fields: name, price, category_id. Optional: image, attributes.
PUT /api/products/{id} Updates an existing product.
DELETE /api/products/{id} Deletes a product.

Folder Structure Notes
app/Http/Controllers: Contains Admin controllers and the API controller.
public/css/style.css: All custom styling is located here.
resources/views/admin: Contains all backend Blade files.
resources/views/layouts: Contains the master layout file.


Github url: https://github.com/PrithvirajKR15/Product-Management-System.git
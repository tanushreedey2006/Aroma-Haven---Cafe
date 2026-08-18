# Aroma Haven ☕

A full-stack e-commerce web application for an online coffee business, developed using PHP and MySQL.

## Features

### User Features

* User Registration and Login
* Product Browsing and Category Filtering
* Product Search
* Shopping Cart Management
* Wishlist Management
* Checkout and Order Placement
* Order Tracking and Management
* Table Reservation and Booking

### Admin Features

* Admin Dashboard
* Product Management
* Category and Subcategory Management
* Order Management
* Booking Management
* Customer Management

## Technologies Used

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* Bootstrap

## Installation and Setup

### 1. Download the Project

Clone the repository:

```bash
git clone <repository-url>
```

Or download the project as a ZIP file and extract it.

### 2. Move the Project to XAMPP

Place the project folder inside the XAMPP `htdocs` directory:

```text
C:\xampp\htdocs\
```

For example:

```text
C:\xampp\htdocs\CoffeeShop2
```

### 3. Start XAMPP

Open the XAMPP Control Panel and start:

* Apache
* MySQL

### 4. Import the Database

1. Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

2. Create a new database.
3. Select the database.
4. Click **Import**.
5. Choose the `.sql` file included in this repository.
6. Click **Import**.

### 5. Configure the Database Connection

Open the database connection file:

```text
connect.php
```

Update the database configuration if required:

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";
```

Make sure the database name matches the imported database.

### 6. Run the Application

Open your browser and visit:

```text
http://localhost/CoffeeShop2/
```

If you use a different folder name, update the URL accordingly.

## Project Highlights

* Full-stack PHP and MySQL application
* User and Admin functionality
* Product, Cart, and Wishlist system
* Order and Checkout workflow
* Table Booking system
* Responsive user interface

## Author

**Tanushree Dey**

BCA Student 


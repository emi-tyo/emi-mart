Émi Mart - Online Grocery Store  
=================================

Author: Emi Sekikawa  
Subject: Assignment 1 - Internet Programming  
Student ID: 14507608

Overview:
-------------------------------
Émi Mart is a simple online grocery store built with PHP and MySQL.  
It demonstrates key functionalities of a basic e-commerce website including product listings, category filtering, search, shopping cart, and delivery form.

Environment Requirements:
-------------------------------
- XAMPP (or MAMP / any local server stack with PHP & MySQL)
- PHP 7.x or higher
- MySQL 5.x or higher
- Modern web browser (e.g., Chrome, Firefox)

Setup Instructions:
-------------------------------
1. Launch XAMPP and start Apache and MySQL
2. Open phpMyAdmin and create a database named `grocery_store`
3. Import the provided `grocery_store.sql` file (if included)
4. Place the `grocery-store` folder inside the `htdocs` directory
5. Access the project at: `http://localhost/grocery-store/index.php`

Project Structure:
-------------------------------
- `index.php` – Home page with featured products
- `pages/`
    - `category.php` – Displays products by category
    - `cart.php` – Shopping cart
    - `delivery.php` – Delivery details form
- `includes/`
    - `header.php`, `footer.php`, `db.php` – Shared layout and database connection
- `functions/`
    - `cart_functions.php` – Cart-related logic
- `assets/`
    - `styles.css` – Custom styling
    - `images/` – Product images
- `sql/`
    - `grocery_store.sql` – Database data

Key Features:
-------------------------------
- Product listings with image, name, price, and stock status
- Category and sub-category filtering
- Keyword-based product search (supports partial match)
- "Out of Stock" items have disabled buttons and styling
- Shopping cart with quantity update, removal, and total calculation
- Real-time subtotal and total update using JavaScript
- Delivery form with required fields and input validation
- Order confirmation page with simulated email message

Notes:
-------------------------------
- Design kept simple for beginner readability
- Future improvements may include: responsive design, order confirmation, product detail pages

This project showcases the foundational elements of an online e-commerce platform, and has been developed with beginner-friendly structure while incorporating interactive and dynamic features for a modern user experience.


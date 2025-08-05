# ShopEasy - E-Commerce Website

[![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=fff)](#)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=fff)](#)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=000)](#)
[![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=fff)](#)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=fff)](#)

---

## Overview
ShopEasy is a simple and interactive E-Commerce web application designed for online product selling.  
It includes a user-friendly interface with product listing, cart, checkout, and authentication features.

---

## Features
- **Home Page**: Modern design with hero section and navigation.
- **User Authentication**: Login and Register pages styled like the homepage.
- **Product Listing**: Grid-based layout with images, names, descriptions, and prices.
- **Cart Management**: Add to cart functionality with row-wise view and back buttons.
- **Checkout**: Stylish centered card layout similar to login page.
- **Responsive Design**: Works across desktop and mobile devices.
- **Work Flow**: Completed with guidance & real-time changes through ChatGPT sessions.

---

## Technologies Used
- **Frontend**: HTML5, CSS3, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL  
- **Server**: XAMPP (Apache + MySQL)

---

## Project Structure
ecommerce-website/
│── index.html
│── login.php
│── register.php
│── products.html
│── cart.php
│── checkout.php
│── thankyou.php
│
├── assets/
│ ├── css/
│ │ └── style.css
│ ├── js/
│ │ └── products.js
│ └── uploads/ (product images)
│
├── api/
│ ├── products.php
│ └── add_to_cart.php
│
└── config/
└── database.php

---

## Screenshots
### Home Page
![Home Page](assets/uploads/screenshot-homepage.png)

### Product Page
![Product Page](assets/uploads/screenshot-products.png)

### Cart Page
![Cart Page](assets/uploads/screenshot-cart.png)

### Checkout Page
![Checkout Page](assets/uploads/screenshot-checkout.png)

*(Replace with actual screenshots of your project)*

---

## Database Schema
### **Users Table**
- `id` (INT, Primary Key)
- `username` (VARCHAR)
- `email` (VARCHAR)
- `password` (VARCHAR)

### **Products Table**
- `id` (INT, Primary Key)
- `name` (VARCHAR)
- `description` (TEXT)
- `price` (DECIMAL)
- `image_url` (VARCHAR)

### **Cart Table**
- `id` (INT, Primary Key)
- `user_id` (INT, Foreign Key)
- `product_id` (INT, Foreign Key)
- `quantity` (INT)

---

## Installation & Setup
1. Install [XAMPP](https://www.apachefriends.org/download.html) and start **Apache** & **MySQL**.
2. Copy the project folder (`ecommerce-website`) into `htdocs` directory.
3. Import database:
   - Open phpMyAdmin → Create a new database (`ecommerce_db`).
   - Import SQL schema provided in the `database.sql` file.
4. Configure database:
   - Edit `/config/database.php` with your database credentials.
5. Access the project in the browser:
http://localhost/ecommerce-website/
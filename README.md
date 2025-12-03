# E-Commerce Website - PHP & MySQL

A fully functional e-commerce website built with PHP and MySQL.

## Features

- User registration and authentication
- Product catalog and categories
- Shopping cart functionality
- Order management
- Admin dashboard
- Payment integration
- Responsive design

## Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap

## Installation

1. Clone this repository
2. Import the database schema from `database/` folder
3. Configure database connection in `config.php`
4. Run on XAMPP/WAMP server

## Setup

1. Place files in `htdocs` folder
2. Create MySQL database
3. Update database credentials in config file
4. Access via `http://localhost/E-Commerce`

## Project Structure
<img width="1496" height="873" alt="image" src="https://github.com/user-attachments/assets/dd4e2186-e51a-40e0-9297-869af2ee31da" />
<img width="1431" height="857" alt="image" src="https://github.com/user-attachments/assets/9557b250-6b5a-4952-84b6-7ac2af169aa0" />
<img width="1502" height="865" alt="image" src="https://github.com/user-attachments/assets/544d7a72-d38b-47aa-bf74-7b9fc6c1181b" />
<img width="1470" height="430" alt="image" src="https://github.com/user-attachments/assets/c704497f-5bb0-4a2b-aed2-55cb884cb03c" />
<img width="1415" height="624" alt="image" src="https://github.com/user-attachments/assets/8f25ca4b-716f-4a8b-b032-25037d6ec7f8" />
<img width="1068" height="348" alt="image" src="https://github.com/user-attachments/assets/a85db111-44d0-4f5e-8879-1094e4c72699" />
<img width="1416" height="859" alt="image" src="https://github.com/user-attachments/assets/653f445a-a299-4951-bdde-76baf7f1b3c9" />
<img width="1919" height="871" alt="image" src="https://github.com/user-attachments/assets/f44b8108-3be1-4983-8fe4-2b0f87380a4b" />
Admin Credational:- Admin/ password:- 12345


## 🚀 Recent Improvements & Security Fixes

### ✅ Critical Security Issues Fixed:
- **SQL Injection Vulnerabilities**: All database queries now use prepared statements with parameter binding
- **XSS Protection**: Implemented `htmlspecialchars()` output escaping throughout the application
- **Secure Authentication**: Password hashing with `password_hash()` and session management
- **File Upload Security**: MIME type validation and size limits for uploaded images

### ✅ Missing Features Implemented:
1. **Order Status Management System** 
   - Admin can update order status through full workflow: Pending → Confirmed → Payment Pending → Payment Received → Delivered → Canceled
   - Status change history tracking in database
   - Admin interface at `/admin/update_order_status.php`

2. **RESTful API Architecture**
   - Products API: `GET /api/products.php` (all products) and `GET /api/products.php?id=1` (single product)
   - Orders API: `GET /api/orders.php` (view orders), `POST /api/orders.php` (create order)
   - JSON responses with proper HTTP status codes
   - CORS headers for frontend integration

3. **Complete Order History**
   - Users can view all their orders (not just pending)
   - Order status badges with visual indicators
   - Detailed order information display

### ✅ Code Quality Improvements:
- Separated business logic from presentation
- Created reusable helper functions in `/includes/` directory
- Improved error handling and logging
- Consistent code formatting and commenting


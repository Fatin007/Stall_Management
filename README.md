# Stall Management System

A comprehensive web-based management system for tracking sales, products, investors, and managers in a stall business environment.

## 🌐 Live Demo

**[View Live Application](https://byte-n-bite.infinityfreeapp.com/)**

Experience the full functionality of the Stall Management System with our live deployment.

## Features

### 📊 Dashboard
- Real-time statistics display
- Total sales tracking
- Product count overview
- Investor and manager management
- Recent transactions view
- Product-wise sales analytics (card layout)

### 🛍️ Sales Management
- Add new sales transactions
- Edit existing transactions
- Delete transactions (with confirmation)
- Link sales to products and managers
- Real-time sales totals

### 📦 Product Management
- Add new products
- View all products
- Product-wise sales totals
- Product linking with sales data

### 💰 Investor Management
- Add new investors
- Edit investor information
- Track individual investor amounts
- Calculate total investment
- Responsive card/table layout

### 👥 Manager Management
- Add new managers
- Associate managers with sales
- Track manager performance

### 🔐 Authentication
- Secure login system
- Session management
- Role-based access control
- Protected routes for sensitive operations

## Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 5
- **Icons**: Font Awesome
- **Server**: Apache (XAMPP)

## Installation

### Prerequisites
- XAMPP (or LAMP/WAMP) installed
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser

### Setup Instructions

1. **Clone or download the project**
   ```bash
   # Place the project in your XAMPP htdocs directory
   cd c:\xampp\htdocs\
   # Copy Stall_Management folder here
   ```

2. **Start XAMPP services**
   - Start Apache
   - Start MySQL

3. **Create Database**
   ```sql
   CREATE DATABASE stall_management;
   USE stall_management;
   
   -- Create tables (see Database Schema section)
   ```

4. **Configure Database Connection**
   - Update `db.php` with your database credentials
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "stall_management";
   ```

5. **Access the Application**
   - Open web browser
   - Navigate to: `http://localhost/Stall_Management/`

## Database Schema

### Tables Required

#### 1. Sales Table
```sql
CREATE TABLE sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    prod_name VARCHAR(255) NOT NULL,
    manager_id INT,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 2. Product Table
```sql
CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    prod_name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 3. Investor Table
```sql
CREATE TABLE investor (
    investor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 4. Managers Table
```sql
CREATE TABLE managers (
    manager_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## File Structure

```
Stall_Management/
├── README.md                 # Project documentation
├── index.php                 # Main entry point (redirects to dashboard)
├── dashboard.php             # Main dashboard with statistics
├── db.php                    # Database connection
├── login.php                 # User authentication
├── logout.php                # Session termination
├── transaction.php           # Add new sales transactions
├── edit.php                  # Edit sales transactions
├── delete.php                # Delete sales transactions
├── add_product.php           # Add new products
├── add_investor.php          # Add new investors
├── edit_investor.php         # Edit investor information
├── add_manager.php           # Add new managers
├── show_investors.php        # Display all investors (responsive)
├── assets/
│   ├── css/
│   │   └── style.css         # Custom styles
│   └── icon/
│       └── favicon.ico       # Site icon
└── includes/
    ├── header.php            # Common header template
    ├── footer.php            # Common footer template
    └── functions.php         # Utility functions
```

## Key Functions

### Authentication Functions
- `isLoggedIn()` - Check if user is authenticated
- `requireLogin()` - Redirect to login if not authenticated
- `getCurrentManagerId()` - Get current user's ID
- `getCurrentManagerName()` - Get current user's name

### Data Retrieval Functions
- `getTotalSales()` - Calculate total sales amount
- `getTotalInvestment()` - Calculate total investment
- `getProductCount()` - Count total products
- `getInvestorCount()` - Count total investors
- `getManagerCount()` - Count total managers
- `getAllProducts()` - Fetch all products
- `getAllManagers()` - Fetch all managers

### Utility Functions
- `getSaleById($id)` - Get specific sale record
- `getInvestorById($id)` - Get specific investor record
- `displayErrors($errors)` - Format error messages

## Features Details

### Responsive Design
- Mobile-first approach
- Bootstrap 5 responsive grid
- Card layouts for mobile devices
- Table layouts for desktop
- Adaptive navigation

### Security Features
- Session-based authentication
- SQL injection prevention with prepared statements
- XSS protection with `htmlspecialchars()`
- CSRF protection consideration
- Input validation

### User Experience
- Intuitive dashboard design
- Real-time statistics
- Confirmation dialogs for deletions
- Success/error message feedback
- Clean, modern UI with Font Awesome icons

## Usage

### Adding a Transaction
1. Navigate to dashboard
2. Click "Add Transaction" or use Quick Links
3. Select product and manager
4. Enter amount
5. Submit transaction

### Managing Investors
1. Go to "Investors" section
2. View in responsive table/card layout
3. Add new investors with investment amounts
4. Edit existing investor information
5. View total investment summary

### Managing Products
1. Access "Add Product" from dashboard
2. Create products that can be linked to sales
3. View product-wise sales totals in dashboard

## Browser Support

- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For support or questions, please create an issue in the project repository.

## Changelog

### Version 1.0.0
- Initial release
- Dashboard with statistics
- Sales management
- Product management
- Investor management
- Manager management
- Authentication system
- Responsive design implementation

---

**Note**: Make sure to configure your database connection in `db.php` before running the application.

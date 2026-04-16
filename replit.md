# ShopEase (QuickCart) – E-Commerce Application

## Overview
A PHP + MySQL e-commerce web application with three user roles: Customer, Admin, and Delivery Agent.

## Tech Stack
- **Backend:** PHP (native, no framework)
- **Database:** MySQL 8.0 via `mysqli`
- **Frontend:** HTML5, Bootstrap 5.3.3, FontAwesome 6.5.1
- **Server:** PHP built-in development server on port 5000

## Project Structure
```
QuickCart/
├── index.php                  # Entry point → redirects to customer_mode/index.php
├── start.php                  # Role selector (Customer / Admin / Delivery Agent)
├── style.css                  # Global styles
├── customer_mode/             # Customer-facing storefront
│   ├── index.php              # Main shop page (guest + logged-in mode)
│   ├── customer_login.php     # Login page (supports pending_product param)
│   ├── customer_registration.php  # Registration (supports pending_product param)
│   ├── checkout.php
│   ├── place_order.php
│   ├── profile_page.php
│   ├── top_up.php
│   ├── view_orders.php
│   ├── rate_order.php
│   └── rate_delivery.php
├── admin_mode/                # Admin dashboard
├── agent_mode/                # Delivery agent interface
├── functions/
│   └── common_function.php    # Shared PHP functions (product display, cart, orders)
├── includes/
│   ├── connect.php            # Database connection
│   └── footer.php
└── images/                    # Product images
```

## Authentication Flow
- State is managed via **URL parameters** (e.g., `?customer_id=123`), not PHP sessions.
- **Guest Browsing:** Users can open the site and see all products without logging in.
- **Conditional Login:** Clicking "Add to Cart" as a guest opens a login modal on the same page.
- **Pending Product:** After login/register, the pending cart action completes automatically via `add_to_cart` URL param.

## Guest vs Logged-In Mode (customer_mode/index.php)
- **Guest:** No `customer_id` in URL. Shows products, search, categories. "Add" buttons trigger login modal.
- **Logged In:** Full features — cart dropdown, wallet balance, profile/orders nav, logout.

## Key Features
- Internal wallet system for purchases
- Category sidebar and product search
- Cart management (add, remove, update quantity)
- Order lifecycle: Customer → Admin Dispatch → Agent Delivery
- Product and delivery reviews

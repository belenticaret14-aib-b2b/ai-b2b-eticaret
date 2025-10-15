# E-Commerce Backend API

A simple Flask-based e-commerce API for product management and order processing.

## Setup

```bash
pip install -r requirements.txt
python app.py
```

## API Endpoints

- `GET /api/products` - List all products
- `GET /api/products/search?q=<term>` - Search products
- `POST /api/orders/create` - Create new order
- `GET /api/orders/recent` - Get recent orders with details

## Features

- Product catalog management
- Order processing with discount codes
- Search functionality
- Order history

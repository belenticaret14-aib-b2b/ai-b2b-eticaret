"""
E-commerce Application Backend
A Flask-based e-commerce API with product management and order processing
"""

from flask import Flask, request, jsonify
import sqlite3
from datetime import datetime

app = Flask(__name__)
DATABASE = 'ecommerce.db'


def get_db_connection():
    """Create database connection"""
    conn = sqlite3.connect(DATABASE)
    conn.row_factory = sqlite3.Row
    return conn


def init_db():
    """Initialize database with sample data"""
    conn = get_db_connection()
    cursor = conn.cursor()
    
    # Create tables
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price REAL NOT NULL,
            stock INTEGER NOT NULL,
            category TEXT
        )
    ''')
    
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            total_amount REAL NOT NULL,
            discount_applied REAL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ''')
    
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            quantity INTEGER NOT NULL,
            price_at_purchase REAL NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )
    ''')
    
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            email TEXT UNIQUE NOT NULL,
            loyalty_points INTEGER DEFAULT 0
        )
    ''')
    
    # Insert sample data if tables are empty
    cursor.execute('SELECT COUNT(*) FROM products')
    if cursor.fetchone()[0] == 0:
        sample_products = [
            ('Laptop', 999.99, 10, 'Electronics'),
            ('Mouse', 29.99, 50, 'Electronics'),
            ('Keyboard', 79.99, 30, 'Electronics'),
            ('Monitor', 299.99, 15, 'Electronics'),
            ('Desk Chair', 199.99, 20, 'Furniture')
        ]
        cursor.executemany(
            'INSERT INTO products (name, price, stock, category) VALUES (?, ?, ?, ?)',
            sample_products
        )
    
    conn.commit()
    conn.close()


# FIXED: SQL Injection Vulnerability - Now using parameterized queries
@app.route('/api/products/search', methods=['GET'])
def search_products():
    """
    Search products by name or category
    SECURE: Uses parameterized queries to prevent SQL injection
    """
    search_term = request.args.get('q', '')
    
    conn = get_db_connection()
    cursor = conn.cursor()
    
    # FIXED: Using parameterized query with placeholders
    # The database driver properly escapes the parameters
    query = "SELECT * FROM products WHERE name LIKE ? OR category LIKE ?"
    search_pattern = f'%{search_term}%'
    cursor.execute(query, (search_pattern, search_pattern))
    
    products = cursor.fetchall()
    conn.close()
    
    return jsonify([dict(row) for row in products])


# BUG 2: Logic Error in Discount Calculation
@app.route('/api/orders/create', methods=['POST'])
def create_order():
    """
    Create a new order with discount calculation
    HAS LOGIC ERROR IN DISCOUNT CALCULATION!
    """
    data = request.json
    user_id = data.get('user_id')
    items = data.get('items', [])  # [{product_id, quantity}]
    promo_code = data.get('promo_code', '')
    
    conn = get_db_connection()
    cursor = conn.cursor()
    
    # Calculate total
    total = 0
    order_items = []
    
    for item in items:
        cursor.execute('SELECT price FROM products WHERE id = ?', (item['product_id'],))
        product = cursor.fetchone()
        if product:
            item_total = product['price'] * item['quantity']
            total += item_total
            order_items.append({
                'product_id': item['product_id'],
                'quantity': item['quantity'],
                'price': product['price']
            })
    
    # FIXED: Proper discount calculation with validation
    discount = 0
    discount_error = None
    
    if promo_code == 'SAVE10':
        # Fixed discount requires minimum order amount
        if total < 50:
            discount_error = 'SAVE10 requires minimum order of $50'
        else:
            discount = 10  # $10 off
    elif promo_code == 'SAVE20PERCENT':
        # Percentage discount
        discount = total * 0.20  # 20% off
    
    # Validate discount doesn't exceed total (with small buffer for rounding)
    if discount > total:
        discount = total * 0.99  # Cap at 99% of total
    
    final_total = total - discount
    
    # Ensure final total is never negative or zero
    if final_total <= 0:
        final_total = 0.01  # Minimum $0.01 order
    
    # Return error if discount code is invalid
    if discount_error:
        conn.close()
        return jsonify({'error': discount_error}), 400
    
    # Create order
    cursor.execute(
        'INSERT INTO orders (user_id, total_amount, discount_applied) VALUES (?, ?, ?)',
        (user_id, final_total, discount)
    )
    order_id = cursor.lastrowid
    
    # Insert order items
    for item in order_items:
        cursor.execute(
            'INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)',
            (order_id, item['product_id'], item['quantity'], item['price'])
        )
    
    conn.commit()
    conn.close()
    
    return jsonify({
        'order_id': order_id,
        'total': total,
        'discount': discount,
        'final_total': final_total
    })


# FIXED: N+1 Query Performance Issue - Using JOINs
@app.route('/api/orders/recent', methods=['GET'])
def get_recent_orders():
    """
    Get recent orders with product details
    OPTIMIZED: Uses a single JOIN query instead of N+1 queries
    """
    limit = request.args.get('limit', 10, type=int)
    
    conn = get_db_connection()
    cursor = conn.cursor()
    
    # FIXED: Single JOIN query to get all data at once
    # This reduces hundreds of queries to just ONE query
    query = '''
        SELECT 
            o.id as order_id,
            o.user_id,
            o.total_amount,
            o.discount_applied,
            o.created_at,
            oi.id as item_id,
            oi.product_id,
            oi.quantity,
            oi.price_at_purchase,
            p.name as product_name
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE o.id IN (
            SELECT id FROM orders ORDER BY created_at DESC LIMIT ?
        )
        ORDER BY o.created_at DESC, oi.id
    '''
    
    cursor.execute(query, (limit,))
    rows = cursor.fetchall()
    conn.close()
    
    # Group results by order_id
    orders_map = {}
    for row in rows:
        order_id = row['order_id']
        
        if order_id not in orders_map:
            orders_map[order_id] = {
                'id': order_id,
                'user_id': row['user_id'],
                'total_amount': row['total_amount'],
                'discount_applied': row['discount_applied'],
                'created_at': row['created_at'],
                'items': []
            }
        
        # Add item if it exists (LEFT JOIN might return null items)
        if row['item_id']:
            orders_map[order_id]['items'].append({
                'product_id': row['product_id'],
                'product_name': row['product_name'] or 'Unknown',
                'quantity': row['quantity'],
                'price': row['price_at_purchase']
            })
    
    # Convert to list and maintain order
    result = list(orders_map.values())
    
    return jsonify(result)


@app.route('/api/products', methods=['GET'])
def get_products():
    """Get all products"""
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute('SELECT * FROM products')
    products = cursor.fetchall()
    conn.close()
    
    return jsonify([dict(row) for row in products])


if __name__ == '__main__':
    init_db()
    app.run(debug=True)

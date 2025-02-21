from flask import Flask, render_template, request, redirect, url_for, session, jsonify
import mysql.connector
from flask_cors import CORS  # Import CORS
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)

application=app
# Database connection details
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '12345',  # Replace with your password
    'database': 'product_db'
}

CORS(app)
# Secret key for session management
app.secret_key = 'your_secret_key'

# Number of products to display per page
PRODUCTS_PER_PAGE = 12


# Route for the home page
@app.route('/')

def home():
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor(dictionary=True)

    cursor.execute("SELECT name, url FROM brands")
    brands = cursor.fetchall()

    cursor.close()
    conn.close()

    return render_template('index.html', brands=brands)

@app.route('/about')
def about():
    return render_template('About.html')

@app.route('/contact')
def contact():
    return render_template('contact.html')


# Shop route with filters, sorting, and pagination
@app.route('/shop', methods=['GET'])
def shop():
    try:
        # Get query parameters for sorting, filtering, and pagination
        sort_by = request.args.get('sort', 'product_name')
        sort_order = request.args.get('order', 'ASC')
        category = request.args.get('category', '')
        brand = request.args.get('brand', '')
        current_page = int(request.args.get('page', 1))  # Default page is 1
        
        # Calculate the offset for pagination
        offset = (current_page - 1) * PRODUCTS_PER_PAGE
        
        # Create the base SQL query for filtered products
        query = "SELECT id, product_name, category, brand, description, image_url FROM products"
        
        # Apply category filter if provided
        filters = []
        if category:
            filters.append(f"category = %s")
        if brand:
            filters.append(f"brand = %s")
        
        if filters:
            query += " WHERE " + " AND ".join(filters)
        
        # Apply sorting
        query += f" ORDER BY {sort_by} {sort_order}"
        
        # Apply pagination (LIMIT and OFFSET)
        query += f" LIMIT {PRODUCTS_PER_PAGE} OFFSET {offset}"
        
        # Connect to the database
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor(dictionary=True)
        
        # Execute the query with the optional category and brand filters
        cursor.execute(query, tuple([category, brand] if category and brand else [category] if category else [brand] if brand else []))
        
        # Fetch the products for the current page
        products = cursor.fetchall()

        # Get total number of filtered products for pagination
        count_query = "SELECT COUNT(*) FROM products"
        if filters:
            count_query += " WHERE " + " AND ".join(filters)
        
        cursor.execute(count_query, tuple([category, brand] if category and brand else [category] if category else [brand] if brand else []))
        total_products = cursor.fetchone()['COUNT(*)']
        total_pages = (total_products // PRODUCTS_PER_PAGE) + (1 if total_products % PRODUCTS_PER_PAGE else 0)
        
        # Get all categories and brands to populate the filter dropdowns
        cursor.execute("SELECT DISTINCT category FROM products")
        categories = cursor.fetchall()
        
        cursor.execute("SELECT DISTINCT brand FROM products")
        brands = cursor.fetchall()

        return render_template('shop.html', products=products, sort_by=sort_by, sort_order=sort_order, category=category, brand=brand, categories=categories, brands=brands, total_pages=total_pages, current_page=current_page)
    
    except mysql.connector.Error as e:
        return f"Error connecting to database: {e}"
    
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()




@app.route('/admin/products', methods=['GET'])
def admin_products():
    if not session.get('logged_in'):
        return redirect(url_for('login'))
    try:
        # Define products per page
        PRODUCTS_PER_PAGE = 12  # or another number based on your preference
        
        # Get query parameters for sorting, filtering, and pagination
        sort_by = request.args.get('sort', 'product_name')
        sort_order = request.args.get('order', 'ASC')
        category = request.args.get('category', '')
        brand = request.args.get('brand', '')
        current_page = int(request.args.get('page', 1))  # Default page is 1
        
        # Calculate the offset for pagination
        offset = (current_page - 1) * PRODUCTS_PER_PAGE
        
        # Create the base SQL query for filtered products
        query = "SELECT id, product_name, category, brand, description, image_url FROM products"
        
        # Apply category filter if provided
        filters = []
        if category:
            filters.append(f"category = %s")
        if brand:
            filters.append(f"brand = %s")
        
        if filters:
            query += " WHERE " + " AND ".join(filters)
        
        # Apply sorting
        query += f" ORDER BY {sort_by} {sort_order}"
        
        # Apply pagination (LIMIT and OFFSET)
        query += f" LIMIT {PRODUCTS_PER_PAGE} OFFSET {offset}"
        
        # Connect to the database
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor(dictionary=True)
        
        # Execute the query with the optional category and brand filters
        cursor.execute(query, tuple([category, brand] if category and brand else [category] if category else [brand] if brand else []))
        
        # Fetch the products for the current page
        products = cursor.fetchall()

        # Get total number of filtered products for pagination
        count_query = "SELECT COUNT(*) FROM products"
        if filters:
            count_query += " WHERE " + " AND ".join(filters)
        
        cursor.execute(count_query, tuple([category, brand] if category and brand else [category] if category else [brand] if brand else []))
        total_products = cursor.fetchone()['COUNT(*)']
        total_pages = (total_products // PRODUCTS_PER_PAGE) + (1 if total_products % PRODUCTS_PER_PAGE else 0)
        
        # Get all categories and brands to populate the filter dropdowns
        cursor.execute("SELECT DISTINCT category FROM products")
        categories = cursor.fetchall()
        
        cursor.execute("SELECT DISTINCT brand FROM products")
        brands = cursor.fetchall()

        return render_template('admin.html', products=products, sort_by=sort_by, sort_order=sort_order, category=category, brand=brand, categories=categories, brands=brands, total_pages=total_pages, current_page=current_page)
    
    except mysql.connector.Error as e:
        return f"Error connecting to database: {e}"
    
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()



@app.route('/admin_dashboard', methods=['GET', 'POST'])
def admin_dashboard():
    # Check if user is logged in
    if not session.get('logged_in'):
        return redirect(url_for('login'))
    
    connection = mysql.connector.connect(**db_config)
    cursor = connection.cursor(dictionary=True)
    
    if request.method == 'POST':  # Handling form submission for adding or editing a product
        if 'add_product' in request.form:
            product_name = request.form['product_name']
            category = request.form['category']
            image_url = request.form['image_url']
            description = request.form['description']
            if category == 'new':
                category = request.form['new_category']
            
            # Insert product into the database
            cursor.execute("""INSERT INTO products (product_name, category, image_url, description) 
                            VALUES (%s, %s, %s, %s)""", 
                            (product_name, category, image_url, description))
            connection.commit()
            return redirect(url_for('admin_dashboard'))
        
        elif 'edit_product' in request.form:  # Handling the edit form submission
            product_id = request.form['product_id']
            product_name = request.form['product_name']
            category = request.form['category']
            image_url = request.form['image_url']
            description = request.form['description']
            
            # Update product in the database
            cursor.execute("""
                UPDATE products
                SET product_name = %s, category = %s, image_url = %s, description = %s
                WHERE id = %s
            """, (product_name, category, image_url, description, product_id))
            connection.commit()
            return redirect(url_for('admin_dashboard'))

    # Handle "edit" or "delete" via query parameters
    product_to_edit = None
    if 'edit' in request.args:
        product_id = request.args.get('edit')
        cursor.execute("SELECT * FROM products WHERE id = %s", (product_id,))
        product_to_edit = cursor.fetchone()

    # Handle "delete" via query parameters
    if 'delete' in request.args:
        product_id = request.args.get('delete')
        cursor.execute("DELETE FROM products WHERE id = %s", (product_id,))
        connection.commit()
        return redirect(url_for('admin_products'))

    # Fetch all products to display in the table
    cursor.execute("SELECT * FROM products")
    products = cursor.fetchall()
    
    # Fetch unique categories for the dropdown
    cursor.execute("SELECT DISTINCT category FROM products WHERE category IS NOT NULL")
    categories = cursor.fetchall()
    
    cursor.close()
    connection.close()
    
    return render_template('new.html', 
                         products=products, 
                         product_to_edit=product_to_edit,
                         categories=categories)  # Pass categories to template
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']

        # Fetch user details from DB
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor(dictionary=True)
        cursor.execute("SELECT * FROM users WHERE username = %s", (username,))
        user = cursor.fetchone()

        # Verify the password
        if user and check_password_hash(user['password'], password):
            session['logged_in'] = True
            return redirect(url_for('admin_products'))
        else:
            message = "Invalid credentials"
            return render_template('login.html', message=message)

    return render_template('login.html')


@app.route('/register', methods=['GET', 'POST'])
def register():
    if 'logged_in' not in session:  # Check if the user is logged in
        return redirect(url_for('login'))  # Redirect to login page if not logged in
    
    if request.method == 'POST':
        name = request.form['name']
        username = request.form['username']
        password = request.form['password']
        
        # Generate hashed password
        hashed_password = generate_password_hash(password)
        
        # Store the hashed password in the database (no need to split it)
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("INSERT INTO users (username, password,name) VALUES (%s, %s, %s)", (username, hashed_password, name))
        connection.commit()
        
        return redirect(url_for('login'))

    return render_template('register.html')



@app.route('/logout', methods=['GET', 'POST'])
def logout():
    # Clear the session or any authentication token
    session.clear()  # This will clear the session in Flask
    return redirect(url_for('home'))  # Redirect to the login page after logging out



@app.route('/api/users', methods=['GET'])
def get_customers():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor(dictionary=True)
        cursor.execute("SELECT * FROM users")
        customers = cursor.fetchall()
        
        # Check if the request wants JSON (API call) or HTML (browser request)
        if request.headers.get('Accept') == 'application/json':
            return jsonify({
                'customers': customers
            })
        else:
            # Render the HTML template with the customers data
            return render_template(
                'customer.html',  # You'll need to create this template
                customers=customers,
                title="Customer Management"
            )
            
    except Exception as e:
        if request.headers.get('Accept') == 'application/json':
            return jsonify({'error': str(e)}), 400
        else:
            return f"Error: {str(e)}", 400
    finally:
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()

@app.route('/api/users/<int:id>', methods=['POST'])
def save_customer(id):
    try:
        # Get the new name and email from the request
        data = request.json
        new_name = data.get('name')
        new_email = data.get('email')
        print(new_name,new_email)
        # Connect to the database
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()

        # Update the user in the database
        update_query = """
            UPDATE users
            SET name = %s, username = %s
            WHERE id = %s
        """
        cursor.execute(update_query, (new_name, new_email, id))
        connection.commit()

        # Return success response
        return jsonify({'message': 'Customer updated successfully'})

    except Exception as e:
        return jsonify({'error': str(e)}), 400
    finally:
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()


@app.route('/api/new_user')
def new():
    return render_template('register.html')


@app.route('/api/delete_customer/<int:customer_id>', methods=['DELETE'])
def delete_customer(customer_id):
    try:
        # Connect to the database
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()

        # Delete the customer from the database
        delete_query = """
            DELETE FROM users
            WHERE id = %s
        """
        cursor.execute(delete_query, (customer_id,))
        connection.commit()

        # Check if any row was affected (customer was found and deleted)
        if cursor.rowcount > 0:
            return jsonify({'message': 'Customer deleted successfully'}), 200
        else:
            return jsonify({'error': 'Customer not found'}), 404

    except Exception as e:
        return jsonify({'error': str(e)}), 500
    finally:
        if 'connection' in locals() and connection.is_connected():
            cursor.close()
            connection.close()

@app.route('/brands')
def brand():
    if not session.get('logged_in'):
        return redirect(url_for('login'))
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor(dictionary=True)  
    
    cursor.execute("SELECT id, name , url  FROM brands")
    brands = cursor.fetchall()
    
    cursor.close()
    conn.close()

    return render_template('brands.html', brands=brands)


# Add a new brand
@app.route('/brands/add', methods=['POST'])
def add_brand():
    if not session.get('logged_in'):
        return redirect(url_for('login'))
    name = request.form['name']
    url = request.form['url']

    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()
    
    cursor.execute("INSERT INTO brands (name, url) VALUES (%s, %s)", (name, url))
    conn.commit()

    cursor.close()
    conn.close()

    return redirect(url_for('brand'))  


# Delete a brand
@app.route('/brands/delete/<int:brand_id>')
def delete_brand(brand_id):

    if not session.get('logged_in'):
        return redirect(url_for('login'))
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()
    
    cursor.execute("DELETE FROM brands WHERE id = %s", (brand_id,))
    conn.commit()

    cursor.close()
    conn.close()

    return redirect(url_for('brand'))  

if __name__ == '__main__':
    app.run()



# 🏗 Ganapati Build Mart - Official Company Website  

### 🌐 Hosted at: [www.gbmart.in](http://www.gbmart.in)  

---

## 📑 Project Description  
This is a **dynamic and responsive website** developed for **Ganapati Build Mart**, a company specializing in **construction materials, building products, and hardware supplies**. The website is designed to offer a smooth user experience with a clean and modern interface.  

The website consists of:  
- ✅ **Home Page:** Showcasing company profile, services, and contact details.  
- ✅ **About Us Page:** Provides detailed information about the company.  
- ✅ **Products Page:** Lists all the products available at Ganapati Build Mart.  
- ✅ **Contact Page:** Allows visitors to send inquiries via a contact form.  
- ✅ **Admin Panel:** A password-protected area for authorized users to manage products, inquiries, and website content.  

The website is built with:  
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** Flask (Python)  
- **Database:** MySQL  

The website is currently **live at:** [www.gbmart.in](http://www.gbmart.in) 🚀  

---

## 💻 Features  
### ✅ Public Pages  
- **Home Page:** Displays company introduction, services, and contact details.  
- **About Page:** Provides an overview of the company's background and values.  
- **Products Page:** Lists various products offered by Ganapati Build Mart.  
- **Contact Page:** Allows users to submit inquiries through a form.  

### ✅ Admin Panel  
- **Login Protected:** Requires a username and password to access.  
- **Manage Products:** Add, Edit, or Delete products.  
- **View Inquiries:** View all customer inquiries submitted via the contact form.  
- **Modify Content:** Update text content on the website (if needed).  

### ✅ Dynamic Backend  
- **Built with Flask:** Flask handles the server-side operations like contact form submissions and product management.  
- **MySQL Database:** All data (products, inquiries, etc.) is stored in a MySQL database.  
- **Secure Authentication:** Admin Panel is secured with a username and password.  

---

## 💾 Technology Stack  
| Technology       | Usage                           |  
|-----------------|-----------------------------------|  
| **HTML5**        | Structure of the website         |  
| **CSS3**         | Styling and responsiveness       |  
| **JavaScript**   | Client-side interactivity        |  
| **Flask (Python)** | Backend server & API management |  
| **MySQL**        | Database to store data           |  

---

## 📊 Database Structure  
The website uses **MySQL** as its database. Below is the basic structure of the database:  

### **1. Products Table**  
| Column Name     | Type        | Description                   |  
|----------------|-------------|-------------------------------|  
| id             | INT (Primary Key) | Auto-incremented ID      |  
| name           | VARCHAR(255)  | Name of the product           |  
| description    | TEXT          | Product description           |  
| price          | FLOAT         | Price of the product          |  
| image_url      | VARCHAR(255)  | Image link for the product    |  

---

### **2. Contact Form Table**  
| Column Name     | Type        | Description                   |  
|----------------|-------------|-------------------------------|  
| id             | INT (Primary Key) | Auto-incremented ID      |  
| name           | VARCHAR(255)  | Name of the sender           |  
| email          | VARCHAR(255)  | Email of the sender          |  
| message        | TEXT          | Message content              |  
| created_at     | TIMESTAMP     | Date/Time of form submission  |  

---

### **3. Admin Table (Optional)**  
| Column Name     | Type        | Description                   |  
|----------------|-------------|-------------------------------|  
| id             | INT (Primary Key) | Auto-incremented ID      |  
| username       | VARCHAR(255)  | Admin username               |  
| password       | VARCHAR(255)  | Hashed password (for security) |  

---

## 🔐 Admin Page Details  
The **Admin Panel** is a password-protected section that allows authorized users to manage products and view inquiries.  

### ✔ Default Admin Credentials  
| Field     | Value                |  
|------------|--------------------|  
| **URL**    | `/admin`             |  
| **Username** | admin              |  
| **Password** | your-password       |  

👉 **Please change the default credentials after deployment.**  

---

## 📜 How to Run the Project Locally  
If you want to run the website on your local machine, follow these steps:  

### ✅ 1. Clone the Repository  
```bash
git clone https://github.com/your-username/ganapati-build-mart.git
cd ganapati-build-mart
```

### ✅ 2. Create a Virtual Environment (Optional but Recommended)  
```bash
python -m venv venv
source venv/bin/activate  # For Linux/Mac
venv\Scripts\activate     # For Windows
```

### ✅ 3. Install Dependencies  
```bash
pip install -r requirements.txt
```

### ✅ 4. Configure Database  
Open the `app.py` file and update the MySQL database configuration:  
```python
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://username:password@localhost/ganapati_build_mart'
```

Run the following command to create the database:  
```bash
flask db init
flask db migrate -m "Initial migration."
flask db upgrade
```

### ✅ 5. Run the Flask Application  
```bash
python app.py
```

The website will be available at:  
👉 **http://localhost:5000**  

The Admin Panel can be accessed at:  
👉 **http://localhost:5000/admin**  

---

## 📬 Contact Form  
The **Contact Us** form collects user messages and stores them in the database.  
- The form sends a confirmation message to the admin.  
- Admin can review the submitted messages in the Admin Panel.  

---

## 📬 API Endpoints  
| Endpoint             | Method | Description                   |  
|--------------------|--------|-------------------------------|  
| `/`                 | GET    | Load the home page              |  
| `/about`            | GET    | Load the about page             |  
| `/products`         | GET    | Load the products page          |  
| `/contact`          | POST   | Handle contact form submission  |  
| `/admin`            | GET/POST | Admin login page              |  
| `/dashboard`        | GET    | Admin dashboard page            |  

---

## 🚀 Deployment  
The website is **live and hosted** at:  
👉 **[www.gbmart.in](http://www.gbmart.in)**  

If you wish to deploy the website on a cloud server like **Heroku**, **PythonAnywhere**, or **cPanel**, I can help you set it up. Just let me know. 🚀  

---

## 💙 Future Improvements  
Here are some planned improvements for the website:  
- ✅ **Online Orders:** Allow customers to place orders directly from the website.  
- ✅ **Email Notifications:** Send email confirmations to customers after form submission.  
- ✅ **Payment Integration:** Add payment gateways like Razorpay, Stripe, etc.  
- ✅ **Stock Management:** Add stock quantity management in the Admin Panel.  
- ✅ **User Registration:** Allow users to create accounts and login.  

👉 **Would you like me to implement any of these features?** 🚀🙂  

---

## 💯 Credits  
- **Company:** Ganapati Build Mart  
- **Website:** [www.gbmart.in](http://www.gbmart.in)  
- **Developer:** [Your Name]  
- 💼 **GitHub:** [Your GitHub Profile]  
- 📧 **Email:** your-email@gmail.com  

---

## 📝 License  
This project is licensed under the **MIT License**.  
Feel free to modify, distribute, or use it for any commercial or personal use. 🚀  

---

## 💁 Need Help?  
If you need:  
- ✅ **Help with deployment** (cPanel, Heroku, etc.)  
- ✅ **Add Payment Integration** (Razorpay, Stripe, etc.)  
- ✅ **Database Optimization** or **Admin Panel Customization**  
- ✅ **SEO Optimization** for your website  

👉 **Just let me know, and I'll do it for you. 🚀🙂**  

---

## 💡 Final Note  
The **Ganapati Build Mart** website is now live and running successfully. 💯  
If you ever need:  
- ✅ More features  
- ✅ Customization  
- ✅ Mobile App Integration  
- ✅ SEO Optimization  

👉 Feel free to contact me anytime. 🚀  

---

🔥 Would you like me to:  
1. ✅ Create a **Dockerfile** for easy deployment?  
2. ✅ Add **email notifications** when a user submits a form?  
3. ✅ Integrate an **online order system** with payment gateways?  

👉 Just let me know if you'd like any of these features added. 🚀🙂

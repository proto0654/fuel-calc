# Fuel Calculator - Test Task

A modern fuel calculator web application built with Vue.js 3 and PHP backend, featuring real-time calculations, responsive design, and email functionality.

## 🌟 Features

- **Interactive Fuel Calculator** with real-time calculations
- **Regional Settings** with different fuel limits per region
- **Fuel Type Selection** (Benzene, Gas, Diesel) with dynamic pricing
- **Brand Selection** with animated icons
- **Tariff System** (Economy, Favorite, Premium) based on fuel amount
- **Promo Actions** with percentage discounts
- **Additional Services** selection (up to 4 services)
- **Modal Order Form** with validation
- **Email Integration** via Brevo API
- **Responsive Design** (minimum 360px width)
- **Modern UI** with Tailwind CSS and custom animations

## 🛠 Tech Stack

### Frontend

- **Vue.js 3** - Progressive JavaScript framework
- **Vite** - Fast build tool and development server
- **Tailwind CSS** - Utility-first CSS framework
- **SVG Components** - Dynamic icon system
- **ESLint & Prettier** - Code quality tools

### Backend

- **PHP** - Server-side logic and API
- **Brevo API** - Email service integration
- **AJAX** - Asynchronous frontend-backend communication

## 📋 Requirements

- **Node.js** 16+ and npm
- **PHP** 7.4+ with cURL extension
- **Composer** for PHP dependencies
- **Web Server** (Apache, Nginx, or PHP built-in server)

## 🚀 Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd fuel-calculator
```

### 2. Install Frontend Dependencies

```bash
npm install
```

### 3. Install Backend Dependencies

```bash
cd backend
composer install
```

### 4. Configure Email Service

Edit `backend/api.php` and update the Brevo API key:

```php
$apiKey = 'your-brevo-api-key-here';
```

Also update the admin email:

```php
$adminEmail = 'your-admin-email@example.com';
```

## 🔧 Development

### Start Frontend Development Server

```bash
npm run dev
```

The frontend will be available at `http://localhost:5173`

### Start Backend Development Server

```bash
cd backend
php -S localhost:8000
```

The backend API will be available at `http://localhost:8000`

The Vite config includes a proxy that forwards `/backend` requests to `http://localhost:8000`.

### Other Commands

```bash
# Build for production
npm run build

# Lint code
npm run lint

# Preview production build
npm run preview
```

## 🌐 Production Deployment

### 1. Build Frontend

```bash
npm run build
```

### 2. Upload Files

Upload the contents of `dist/` folder and `backend/` folder to your web server.

### 3. Configure PHP

Ensure your server has:

- PHP 7.4+ with cURL extension
- Proper SSL certificates for cURL (cacert.pem)
- Write permissions for log files

### 4. Install Backend Dependencies on Server

```bash
cd backend
composer install --no-dev
```

### 5. Configure Web Server

Point your domain to the `dist/` folder and ensure `backend/` is accessible via `/backend/` URL.

## 📊 Calculator Logic

### Regional Limits

- **Region 1**: Max 1200 tons
- **Region 2**: Max 800 tons
- **Region 3**: Max 500 tons

### Fuel Pricing (per ton)

- **Benzene**: 500.200 ₽
- **Gas**: 200.100 ₽
- **Diesel**: 320.700 ₽

### Tariff Determination

**Benzene:**

- < 100t → Economy
- 100-300t → Favorite
- > 300t → Premium

**Gas:**

- < 200t → Economy
- 200-700t → Favorite
- > 700t → Premium

**Diesel:**

- < 150t → Economy
- 150-350t → Favorite
- > 350t → Premium

### Discounts

**Tariff Discounts:**

- Economy: 3%
- Favorite: 5%
- Premium: 7%

**Promo Actions:**

- Economy: 2%, 5%
- Favorite: 5%, 20%
- Premium: 20%, 50%

## 📧 Email Configuration

The application uses Brevo (ex-Sendinblue) for email sending:

1. Create account at [Brevo](https://www.brevo.com/)
2. Generate API key in account settings
3. Verify sender email/domain
4. Update API key in `backend/api.php`

## 📁 Project Structure

```
fuel-calculator/
├── src/                    # Vue.js source files
│   ├── components/         # Vue components
│   ├── composables/        # Vue composables
│   ├── assets/            # Static assets
│   └── main.js            # App entry point
├── backend/               # PHP backend
│   ├── api.php           # Main API endpoint
│   ├── composer.json     # PHP dependencies
│   └── vendor/           # PHP packages (auto-generated)
├── dist/                 # Production build (auto-generated)
├── public/               # Public assets
└── README.md
```

## 🔍 API Endpoints

### POST /backend/api.php

**Get Configuration**

```json
{
  "action": "get_config"
}
```

**Calculate Fuel Cost**

```json
{
  "action": "calculate",
  "region": "region1",
  "amount": 200,
  "fuelType": "benzene",
  "promoAction": 20
}
```

**Submit Form**

```json
{
  "action": "submit_form",
  "inn": "123456789012",
  "phone": "71234567890",
  "email": "user@example.com",
  "agreeToTerms": true
  // ... calculation data
}
```

## 🐛 Troubleshooting

### Common Issues

**1. cURL SSL Certificate Error**

```
cURL error 60: SSL certificate problem: unable to get local issuer certificate
```

**Solution:** Update `php.ini` with path to `cacert.pem` file:

```ini
curl.cainfo = "/path/to/cacert.pem"
openssl.cafile = "/path/to/cacert.pem"
```

**2. Email Not Sending**

- Verify Brevo API key is correct
- Check sender email is verified in Brevo
- Review `backend/php-errors.log` for detailed errors

**3. Frontend Build Issues**

```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

## 📝 License

This project is created as a test task for demonstration purposes.

## 🤝 Contributing

This is a test project. For educational purposes only.

---

**Live Demo:** [fuel-calc.weblaba.ru](https://fuel-calc.weblaba.ru)

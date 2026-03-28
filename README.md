<div align="center">

<img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"/>
<img src="https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D" alt="Vue.js"/>
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
<img src="https://img.shields.io/badge/Google_APIs-4285F4?style=for-the-badge&logo=google&logoColor=white" alt="Google APIs"/>

# 🏡 AusProperty — Real Estate Platform

**A full-stack real estate web application built for the Australian property market.**  
Powered by Laravel, Vue.js, MySQL, and Google Maps / Places APIs.

[Live Demo](#) · [Report Bug](issues) · [Request Feature](issues)

</div>

---

## 📌 Overview

AusProperty is a modern real estate platform developed for an Australian property company. It enables users to browse, search, and explore property listings with an interactive map-driven experience powered by Google APIs. Agents can manage listings through a secure admin panel, and buyers can filter properties by suburb, price range, property type, and more.

---

## ✨ Features

- 🔍 **Google Maps & Places API** — interactive map search, suburb autocomplete, and geolocation-based property discovery
- 🏠 **Property Listings** — detailed listing pages with image galleries, floor plans, and agent contact forms
- 🗺️ **Map-Based Search** — browse properties visually on a live map with cluster markers
- 📍 **Suburb Autocomplete** — location search powered by Google Places Autocomplete
- 🔐 **Authentication** — secure login and registration for buyers and agents
- 👤 **Agent Dashboard** — create, edit, and manage property listings
- 💾 **Saved Properties** — users can bookmark and revisit favourite listings
- 📱 **Responsive Design** — fully optimised for desktop, tablet, and mobile
- 🔔 **Enquiry System** — in-app contact form for each listing with email notifications
- 📊 **Admin Panel** — manage users, listings, enquiries, and analytics

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 10.x (PHP 8.2) |
| **Frontend** | Vue.js 3 (Composition API) |
| **Build Tool** | Vite |
| **Database** | MySQL 8.x |
| **Maps & Search** | Google Maps JavaScript API, Google Places API, Geocoding API |
| **Authentication** | Laravel Sanctum |
| **Styling** | Tailwind CSS |
| **State Management** | Pinia |
| **HTTP Client** | Axios |
| **Email** | Laravel Mail (SMTP) |
| **Storage** | Laravel Storage / AWS S3 (optional) |

---

## 🗂️ Project Structure

```
ausproperty/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # API & web controllers
│   │   └── Middleware/
│   ├── Models/                 # Eloquent models (Property, User, Agent, Enquiry)
│   └── Services/               # Google Maps service layer
├── database/
│   ├── migrations/             # MySQL table definitions
│   └── seeders/                # Demo data seeders
├── resources/
│   ├── js/
│   │   ├── components/         # Vue components (PropertyCard, MapView, etc.)
│   │   ├── pages/              # Vue page-level components
│   │   ├── stores/             # Pinia stores
│   │   └── router/             # Vue Router config
│   └── views/                  # Blade entry point
├── routes/
│   ├── api.php                 # API routes
│   └── web.php                 # Web routes
├── .env.example
└── vite.config.js
```

---

## ⚙️ Prerequisites

Make sure you have the following installed:

- PHP >= 8.2
- Composer
- Node.js >= 18.x & npm
- MySQL 8.x
- A [Google Cloud Console](https://console.cloud.google.com/) project with the following APIs enabled:
  - **Maps JavaScript API**
  - **Places API**
  - **Geocoding API**

---

## 🚀 Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/******/******
cd realestate
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment variables

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and update the following:

```env
# Application
APP_NAME="AusProperty"
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ausproperty
DB_USERNAME=root
DB_PASSWORD=your_password

# Google APIs
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
GOOGLE_PLACES_API_KEY=your_google_places_api_key

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@ausproperty.com.au
MAIL_FROM_NAME="AusProperty"
```

### 5. Run database migrations and seeders

```bash
php artisan migrate --seed
```

### 6. Start the development servers

In two separate terminals:

```bash
# Terminal 1 — Laravel backend
php artisan serve

# Terminal 2 — Vite frontend
npm run dev
```

The application will be available at `http://localhost:8000`.

---

## 🗺️ Google APIs Integration

This project uses three Google Cloud APIs for property search and mapping:

### Maps JavaScript API
Used to render interactive property maps with custom markers and cluster overlays on the listing search page.

```javascript
// resources/js/components/MapView.vue
const map = new google.maps.Map(document.getElementById("map"), {
  center: { lat: -33.8688, lng: 151.2093 }, // Sydney default
  zoom: 12,
});
```

### Places API — Autocomplete
Powers the suburb/address search bar, scoped to Australia.

```javascript
const autocomplete = new google.maps.places.Autocomplete(input, {
  types: ["(regions)"],
  componentRestrictions: { country: "au" },
});
```

### Geocoding API
Converts property addresses to latitude/longitude coordinates when a new listing is saved.

```php
// app/Services/GoogleMapsService.php
public function geocodeAddress(string $address): array
{
    $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
        'address' => $address . ', Australia',
        'key'     => config('services.google.maps_key'),
    ]);

    return $response->json('results.0.geometry.location');
}
```

---

## 🗃️ Database Schema

Key tables in the MySQL database:

| Table | Description |
|---|---|
| `users` | Buyers, agents, and admin accounts |
| `properties` | Core listing data (address, price, type, status) |
| `property_images` | Multiple images per listing |
| `property_features` | Bedrooms, bathrooms, parking, land size |
| `enquiries` | Contact form submissions per listing |
| `saved_properties` | User bookmarks (pivot) |
| `agents` | Agent profiles linked to users |
| `suburbs` | Cached suburb/postcode reference data |

---

## 🔌 API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/properties` | List all properties (filterable) |
| `GET` | `/api/properties/{id}` | Get a single listing |
| `POST` | `/api/properties` | Create a new listing (agent auth) |
| `PUT` | `/api/properties/{id}` | Update a listing (agent auth) |
| `DELETE` | `/api/properties/{id}` | Delete a listing (agent auth) |
| `GET` | `/api/properties/search` | Search by suburb, price, type |
| `POST` | `/api/enquiries` | Submit a listing enquiry |
| `GET` | `/api/agents/{id}/listings` | Listings by agent |
| `POST` | `/api/auth/register` | Register new user |
| `POST` | `/api/auth/login` | Login (returns Sanctum token) |

---

## 🌏 Australian Market Specifics

- All property prices are in **AUD ($)**
- Address formats follow **Australian Standard** (Street, Suburb, State, Postcode)
- Supported states: NSW, VIC, QLD, WA, SA, TAS, ACT, NT
- Geolocation defaults to **Sydney, Australia** on map initialisation
- Google Places Autocomplete is restricted to `componentRestrictions: { country: "au" }`

---

## 🧪 Running Tests

```bash
# PHP unit and feature tests
php artisan test

# or with coverage
php artisan test --coverage
```

```bash
# Frontend (if configured)
npm run test
```

---

## 🏗️ Building for Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m 'Add: your feature description'`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Open a Pull Request

Please follow [PSR-12](https://www.php-fig.org/psr/psr-12/) for PHP and the [Vue.js Style Guide](https://vuejs.org/style-guide/) for frontend code.

---

## 📄 License

This project is proprietary software developed for a private Australian real estate company. All rights reserved.

---

## 👥 Credits

Developed by **[Your Name / Team Name]**  
Built for **[Company Name] Pty Ltd** — Australia 🇦🇺

---

<div align="center">
Made with ❤️ for the Australian property market
</div>

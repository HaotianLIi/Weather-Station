# Weather Station API

A Laravel Application takes data from Ecowitt and Wunderground weather stations and stores it in a PostgreSQL database. Anyone can pull live weather data from the server using the public API endpoints below.

## Features

- Receives weather data via Ecowitt protocol (`POST /data/report`)
- Receives weather data via Wunderground protocol (`GET /weatherstation/updateweatherstation.php`)
- **Pull weather data from anywhere** via public GET endpoints
- Health check endpoint (`GET /health`)

## Local Development Setup

### 1. Clone the Repository

```bash
git clone git@github.com:your-repo/weather-station.git
cd weather-station
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

cp .env.example .env
Edit `.env` with your settings

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

# For PostgreSQL (ensure database exists first)
php artisan migrate --force
```

### 6. Start Development Server

php artisan serve --host=0.0.0.0 --port=8000

The app will be available at `http://localhost:8000`

## Testing the API

### Health Check

curl http://localhost:8000/health
```

### Ecowitt Endpoint

```bash
curl -X POST http://localhost:8000/data/report \
  -d "PASSKEY=test123&tempf=79.3&humidity=70"
```

### Wunderground Endpoint

```bash
curl "http://localhost:8000/weatherstation/updateweatherstation.php?ID=test123&tempf=79.3"
```

## Pulling Weather Data (Remote Access)

Once deployed, anyone can pull all weather data from the server from anywhere:

```bash
curl http://YOUR_SERVER/api/weather
```

Replace `YOUR_SERVER` with the actual server address (e.g. `170.75.168.206:8000` or your domain). Returns all weather data as JSON, newest first.


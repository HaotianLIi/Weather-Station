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

Once the server is deployed, anyone can pull weather data from anywhere using these endpoints. Replace `YOUR_SERVER` with the actual server address (e.g. `170.75.168.206:8000` or your domain).

### Get Latest Reading

Returns the most recent reading from all stations (or a specific station).

```bash
# Latest from all stations
curl http://YOUR_SERVER/api/weather/latest

# Latest from a specific station
curl "http://YOUR_SERVER/api/weather/latest?station_id=YOUR_STATION_ID"
```

### Get Historical Data

Query past weather readings with optional date range and limit filters.

```bash
# Last 100 readings (default)
curl http://YOUR_SERVER/api/weather/history

# Filter by station and date range
curl "http://YOUR_SERVER/api/weather/history?station_id=YOUR_STATION_ID&start=2026-01-01&end=2026-03-08&limit=500"
```

| Parameter    | Required | Description                          |
|-------------|----------|--------------------------------------|
| station_id  | No       | Filter by a specific station         |
| start       | No       | Start date (e.g. `2026-01-01`)       |
| end         | No       | End date (e.g. `2026-03-08`)         |
| limit       | No       | Max rows returned (default 100, max 1000) |

### List All Stations

See all stations that have reported data, along with reading counts and date ranges.

```bash
curl http://YOUR_SERVER/api/weather/stations
```

### Example JSON Response

```json
{
  "status": "ok",
  "count": 1,
  "data": [
    {
      "id": 42,
      "station_id": "ABC123",
      "data_source": "ecowitt",
      "temperature_f": 72.5,
      "humidity_pct": 65,
      "wind_speed_mph": 5.2,
      "pressure_inhg": 29.92,
      "measured_at": "2026-03-08T12:00:00Z"
    }
  ]
}
```

### Using from Code (Examples)

**Python:**
```python
import requests

response = requests.get("http://YOUR_SERVER/api/weather/latest")
data = response.json()
print(f"Temperature: {data['data'][0]['temperature_f']}°F")
```

**JavaScript:**
```javascript
const res = await fetch("http://YOUR_SERVER/api/weather/latest");
const { data } = await res.json();
console.log(`Temperature: ${data[0].temperature_f}°F`);
```


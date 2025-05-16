# PHP Referrals API

A simple PHP API for validating zip codes with CORS protection.

## Setup

1. Clone the repository
2. Install dependencies:

```bash
composer install
```

3. Create a `.env` file in the root directory with the following variables:

```
API_BASE_URL=your_api_base_url
SERVICE_TOKEN=your_service_token
ALLOWED_ORIGIN=http://localhost:3000
```

## Environment Variables

- `API_BASE_URL`: Base URL for the API endpoint
- `SERVICE_TOKEN`: Authentication token for the API
- `ALLOWED_ORIGIN`: Frontend URL that's allowed to make requests (e.g., http://localhost:3000)

## Usage

The API provides a single endpoint for validating zip codes:

- Endpoint: `/validate-zip.php`
- Method: POST
- Content-Type: application/json
- Request Body: `{ "zip_code": "12345" }`

## Response Format

Success Response:

```json
{
  "success": true
}
```

Error Response:

```json
{
  "error": "Error message"
}
```

## Security

- CORS protection is implemented to allow requests only from the specified origin
- Only POST requests are allowed
- Zip code validation ensures 5-digit format

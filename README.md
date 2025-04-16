EventHub Documentation
======================

Project Description
-------------------

EventHub is a comprehensive event management platform that allows users to create, manage, and register for events. It features a robust backend built with Laravel and a reactive frontend using Vue 3 with Composition API. The system includes event creation/management, registration with capacity constraints, real-time updates, and optimized database operations.

Installation Guide
------------------

### Manual Installation

#### Prerequisites

*   PHP 8.1 or higher
    
*   Composer
    
*   Node.js 16+ and npm/yarn
    
*   PostgreSQL or MySQL 8.0+
    

#### Installation Steps

1.  git clone https://github.com/your-repo/EventHub.gitcd EventHub
    
2.  composer install
    
3.  npm install
    
4.  cp .env.example .env
    
5.  php artisan key:generate
    
6.  iniCopyDB\_CONNECTION=mysqlDB\_HOST=127.0.0.1DB\_PORT=3306DB\_DATABASE=eventhubDB\_USERNAME=rootDB\_PASSWORD=
    
7.  php artisan migrate --seed
    
8.  npm run build
    
9.  php artisan serve
    

### Docker Installation

#### Prerequisites

*   Docker
    
*   Docker Compose
    

#### Installation Steps

1.  git clone https://github.com/your-repo/EventHub.gitcd EventHub
    
2.  cp .env.example .env
    
3.  docker-compose up -d --build
    
4.  docker-compose exec app composer install
    
5.  docker-compose exec app php artisan key:generate
    
6.  docker-compose exec app php artisan migrate --seed
    
7.  docker-compose exec app npm install
    
8.  docker-compose exec app npm run build
    
9.  **Access the application**The application will be available at http://localhost:8000
    
Default Admin Credentials
-------------------------

For your convenience, a default admin user is created when you run the database seeds. You can use these credentials to log in to the application:

**Admin User:**

*   **Email:** [admin@eventhub.com](https://mailto:admin@eventhub.com/)
    
*   **Password:** password123
    

### Security Recommendations

Change the default password immediately after your first login.

Testing
-------------------------

To execute the test suite, run the following command in your terminal:

```bash
php artisan test
```

# API Documentation

## 1. Authentication
| Endpoint            | Method | Auth | Parameters               | Description          |
|---------------------|--------|------|--------------------------|----------------------|
| `/auth/register`    | POST   | ❌   | `name, email, password`  | User registration (rate-limited) |
| `/auth/login`       | POST   | ❌   | `email, password`        | Generate auth token  |
| `/auth/logout`      | POST   | ✅   | -                        | Invalidate token     |

## 2. Event Management *(Admin)*
`REQUIRES: Valid auth token and manage-events permission`

| Endpoint       | Method | Parameters               | Description          |
|----------------|--------|--------------------------|----------------------|
| `/events`      | GET    | -                        | List all events      |
| `/events`      | POST   | `title, description, date, location` | Create event |
| `/events/{id}` | GET    | -                        | Get event details    |
| `/events/{id}` | PUT    | `title, description, date, location` | Update event |
| `/events/{id}` | DELETE | -                        | Delete event         |

## 3. Registration
`REQUIRES: Valid auth token`

| Endpoint                | Method | Description          |
|-------------------------|--------|----------------------|
| `/events/{id}/register`   | POST   | Join event           |
| `/events/{id}/unregister` | POST   | Leave event          |

## Response Schema
```json
{
  "error": "string | null",
  "data": "object | array",
  "meta": "pagination | null"
}
```

## HTTP Status Codes

### Success
| Code | Description                     |
|------|---------------------------------|
| 200  | OK - Successful request         |
| 201  | Created - Resource created      |

### Client Errors
| Code | Description                      |
|------|----------------------------------|
| 400  | Bad Request - Invalid syntax     |
| 401  | Unauthorized - Missing/invalid token |
| 403  | Forbidden - Insufficient permissions |
| 404  | Not Found - Resource doesn't exist |
| 422  | Unprocessable Entity - Validation errors |
| 429  | Too Many Requests - Rate limited |

### Server Errors
| Code | Description                      |
|------|----------------------------------|
| 500  | Internal Server Error - Unexpected server error |
| 503  | Service Unavailable - Maintenance/downtime |
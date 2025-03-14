# Profile Management API Documentation

## Overview
The Profile Management API provides endpoints for managing user profiles in a multitenancy system. Each profile belongs to a specific tenant and user, ensuring proper data isolation between different tenants.

## Authentication
All endpoints require authentication using Laravel Sanctum. Include the authentication token in the request header:
```
Authorization: Bearer <your-token>
```

## Endpoints

### List Profiles
Get a paginated list of profiles for the current tenant.

```http
GET /api/profiles
```

#### Response
```json
{
    "data": [
        {
            "id": 1,
            "tenant_id": 1,
            "user_id": 1,
            "bio": "Software Engineer with 5 years of experience",
            "avatar": "avatars/user1.jpg",
            "phone": "+1234567890",
            "address": "123 Main St",
            "city": "San Francisco",
            "state": "CA",
            "country": "USA",
            "postal_code": "94105",
            "timezone": "America/Los_Angeles",
            "language": "en",
            "theme": "light",
            "notifications_enabled": true,
            "created_at": "2025-03-14T00:00:00.000000Z",
            "updated_at": "2025-03-14T00:00:00.000000Z",
            "user": {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com"
            }
        }
    ],
    "links": {
        "first": "http://localhost/api/profiles?page=1",
        "last": "http://localhost/api/profiles?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://localhost/api/profiles",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```

### Create Profile
Create a new profile for a user in the current tenant.

```http
POST /api/profiles
```

#### Request Body
```json
{
    "user_id": 1,
    "bio": "Software Engineer with 5 years of experience",
    "avatar": "<file>",
    "phone": "+1234567890",
    "address": "123 Main St",
    "city": "San Francisco",
    "state": "CA",
    "country": "USA",
    "postal_code": "94105",
    "timezone": "America/Los_Angeles",
    "language": "en",
    "theme": "light",
    "notifications_enabled": true
}
```

#### Response
```json
{
    "data": {
        "id": 1,
        "tenant_id": 1,
        "user_id": 1,
        "bio": "Software Engineer with 5 years of experience",
        "avatar": "avatars/user1.jpg",
        "phone": "+1234567890",
        "address": "123 Main St",
        "city": "San Francisco",
        "state": "CA",
        "country": "USA",
        "postal_code": "94105",
        "timezone": "America/Los_Angeles",
        "language": "en",
        "theme": "light",
        "notifications_enabled": true,
        "created_at": "2025-03-14T00:00:00.000000Z",
        "updated_at": "2025-03-14T00:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    }
}
```

### Show Profile
Get details of a specific profile.

```http
GET /api/profiles/{id}
```

#### Response
```json
{
    "data": {
        "id": 1,
        "tenant_id": 1,
        "user_id": 1,
        "bio": "Software Engineer with 5 years of experience",
        "avatar": "avatars/user1.jpg",
        "phone": "+1234567890",
        "address": "123 Main St",
        "city": "San Francisco",
        "state": "CA",
        "country": "USA",
        "postal_code": "94105",
        "timezone": "America/Los_Angeles",
        "language": "en",
        "theme": "light",
        "notifications_enabled": true,
        "created_at": "2025-03-14T00:00:00.000000Z",
        "updated_at": "2025-03-14T00:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    }
}
```

### Update Profile
Update an existing profile.

```http
PUT /api/profiles/{id}
```

#### Request Body
```json
{
    "bio": "Updated bio",
    "avatar": "<file>",
    "phone": "+1234567890",
    "address": "456 Oak St",
    "city": "San Francisco",
    "state": "CA",
    "country": "USA",
    "postal_code": "94105",
    "timezone": "America/Los_Angeles",
    "language": "en",
    "theme": "dark",
    "notifications_enabled": false
}
```

#### Response
```json
{
    "data": {
        "id": 1,
        "tenant_id": 1,
        "user_id": 1,
        "bio": "Updated bio",
        "avatar": "avatars/user1.jpg",
        "phone": "+1234567890",
        "address": "456 Oak St",
        "city": "San Francisco",
        "state": "CA",
        "country": "USA",
        "postal_code": "94105",
        "timezone": "America/Los_Angeles",
        "language": "en",
        "theme": "dark",
        "notifications_enabled": false,
        "created_at": "2025-03-14T00:00:00.000000Z",
        "updated_at": "2025-03-14T00:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        }
    }
}
```

### Delete Profile
Delete a profile.

```http
DELETE /api/profiles/{id}
```

#### Response
```json
{
    "message": "Profile deleted successfully"
}
```

## Validation Rules

### Create/Update Profile
- `user_id` (create only): Required, must exist in users table and belong to current tenant
- `bio`: Optional, string, max 1000 characters
- `avatar`: Optional, image file, max 2MB
- `phone`: Optional, string, max 20 characters
- `address`: Optional, string, max 255 characters
- `city`: Optional, string, max 100 characters
- `state`: Optional, string, max 100 characters
- `country`: Optional, string, max 100 characters
- `postal_code`: Optional, string, max 20 characters
- `timezone`: Required, valid timezone string
- `language`: Required, one of: en, pt-BR, es
- `theme`: Required, one of: light, dark
- `notifications_enabled`: Required, boolean

## Error Responses

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
    "message": "This resource belongs to a different tenant."
}
```

### 404 Not Found
```json
{
    "message": "Profile not found."
}
```

### 422 Unprocessable Entity
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "user_id": [
            "The selected user does not belong to your tenant."
        ],
        "avatar": [
            "The avatar must not be larger than 2MB."
        ],
        "timezone": [
            "The timezone must be a valid timezone."
        ],
        "language": [
            "The language must be one of: English, Portuguese (Brazil), or Spanish."
        ],
        "theme": [
            "The theme must be either light or dark."
        ]
    }
}
```

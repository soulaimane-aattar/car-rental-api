
# API Documentation

## Endpoints

### List Cars

**GET** `/api/cars`

**Response:**
\`\`\`json
[
    {
        "id": 1,
        "model": "Model S",
        "make": "Tesla",
        "available": true
    }
]
\`\`\`

### Get Car Details

**GET** `/api/cars/{id}`

**Response:**
\`\`\`json
{
    "id": 1,
    "model": "Model S",
    "make": "Tesla",
    "available": true
}
\`\`\`

### Create Reservation

**POST** `/api/reservations`

**Request:**
\`\`\`json
{
    "carId": 1,
    "startDate": "2022-01-15T00:00:00Z",
    "endDate": "2022-01-20T00:00:00Z"
}
\`\`\`

**Response:**
\`\`\`json
{
    "id": 1,
    "startDate": "2022-01-15T00:00:00Z",
    "endDate": "2022-01-20T00:00:00Z",
    "user": "/api/users/1",
    "car": "/api/cars/1"
}
\`\`\`

### Update Reservation

**PUT** `/api/reservations/{id}`

**Request:**
\`\`\`json
{
    "startDate": "2022-01-16T00:00:00Z",
    "endDate": "2022-01-21T00:00:00Z"
}
\`\`\`

**Response:**
\`\`\`json
{
    "id": 1,
    "startDate": "2022-01-16T00:00:00Z",
    "endDate": "2022-01-21T00:00:00Z",
    "user": "/api/users/1",
    "car": "/api/cars/1"
}
\`\`\`

### Delete Reservation

**DELETE** `/api/reservations/{id}`

**Response:**
\`\`\`json
null
\`\`\`

### List User Reservations

**GET** `/api/users/{id}/reservations`

**Response:**
\`\`\`json
[
    {
        "id": 1,
        "startDate": "2022-01-15T00:00:00Z",
        "endDate": "2022-01-20T00:00:00Z",
        "car": "/api/cars/1"
    }
]
\`\`\`

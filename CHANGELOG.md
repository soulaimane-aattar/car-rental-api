
# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- Initial setup and configuration.
- Entities for Car, Reservation, and User.
- JWT Authentication.
- API endpoints for listing, creating, updating, and deleting cars and reservations.
- Unit tests for services and repositories.
- Docker configuration.
- API Documentation.

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A

## Directory Structure

Here is the directory structure of the project:

\`\`\`
app/
├── assets
├── bin
├── config
│   ├── bundles.php
│   ├── jwt/
│   │   ├── private.pem
│   │   └── public.pem
│   ├── packages/
│   │   ├── doctrine.yaml
│   │   ├── framework.yaml
│   │   ├── lexik_jwt_authentication.yaml
│   │   └── security.yaml
│   ├── routes.yaml
│   └── services.yaml
├── migrations
├── public
├── src
│   ├── Controller/
│   │   ├── CarController.php
│   │   ├── ReservationController.php
│   │   └── UserController.php
│   ├── Entity/
│   │   ├── Car.php
│   │   ├── Reservation.php
│   │   └── User.php
│   ├── Repository/
│   │   ├── CarRepository.php
│   │   ├── ReservationRepository.php
│   │   └── UserRepository.php
│   ├── Service/
│   │   └── ReservationService.php
├── templates
├── tests
│   ├── Repository/
│   │   └── CarRepositoryTest.php
│   └── Service/
│       └── ReservationServiceTest.php
├── translations
├── var
├── vendor
├── .env
├── .env.local
├── .env.test
├── .gitignore
├── compose.override.yaml
├── compose.yaml
├── composer.json
├── composer.lock
├── docker/
│   └── etc/
│       └── nginx/
│           └── conf.d/
│               └── default.conf
├── docs/
│   └── api_documentation.md
├── phpunit.xml.dist
├── symfony.lock
\`\`\`

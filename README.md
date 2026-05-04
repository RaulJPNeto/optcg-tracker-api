# OPTCG Tracker — Roadmap

Platform for the Brazilian One Piece TCG community to track Japanese spoilers, build decks, and follow the meta.

---

## Project Scope

### Features

- Card listing and advanced filtering
- Deck builder
- Tier list / meta tracking
- Invite-only editor system

### Roles

| Role     | Permissions                               |
| -------- | ----------------------------------------- |
| `ADMIN`  | Full access + manage users + send invites |
| `EDITOR` | Register/edit cards, sets, tier list      |
| `VIEWER` | Read only (public, no login required)     |

---

## Tech Stack

### Backend

- Laravel 11
- PostgreSQL
- Laravel Sanctum
- Swagger / OpenAPI
- Laravel Pint + Larastan
- PHPUnit (Feature Tests)

### Frontend

- React 19 + Vite
- TailwindCSS
- Shadcn/ui
- React Query
- React Router v7
- Axios

---

## Data Model

```
users
  id, name, email, password, role, invited_by, created_at

invitations
  id, email, token, used_at, invited_by, expires_at

sets
  id, code, name, release_date_jp, release_date_global, total_cards

cards
  id, set_id, code, name, type, color, cost, power,
  counter, attribute, effect, image_url,
  announced_at, released_at, created_by

decks
  id, user_id, name, leader_card_id, description, is_public

deck_cards
  id, deck_id, card_id, quantity

tier_list_entries
  id, card_id, tier, notes, updated_by, updated_at

tier_list_history
  id, card_id, old_tier, new_tier, changed_by, created_at
```

---

## Enums

```
UserRole       → ADMIN, EDITOR, VIEWER
CardType       → LEADER, CHARACTER, EVENT, STAGE
CardColor      → RED, BLUE, GREEN, YELLOW, PURPLE, BLACK
CardAttribute  → SLASH, RANGED, SPECIAL, WISDOM, STRIKE
Tier           → S, A, B, C, D
```

---

## API Endpoints

### Auth

| Method | Endpoint                     | Auth |
| ------ | ---------------------------- | ---- |
| POST   | `/auth/register-with-invite` | No   |
| POST   | `/auth/login`                | No   |
| POST   | `/auth/logout`               | Yes  |
| GET    | `/auth/me`                   | Yes  |

### Invitations

| Method | Endpoint               | Auth  |
| ------ | ---------------------- | ----- |
| POST   | `/invitations`         | ADMIN |
| GET    | `/invitations`         | ADMIN |
| GET    | `/invitations/{token}` | No    |

### Sets

| Method | Endpoint     | Auth         |
| ------ | ------------ | ------------ |
| GET    | `/sets`      | No           |
| GET    | `/sets/{id}` | No           |
| POST   | `/sets`      | EDITOR/ADMIN |
| PUT    | `/sets/{id}` | EDITOR/ADMIN |
| DELETE | `/sets/{id}` | ADMIN        |

### Cards

| Method | Endpoint      | Auth         |
| ------ | ------------- | ------------ |
| GET    | `/cards`      | No           |
| GET    | `/cards/{id}` | No           |
| POST   | `/cards`      | EDITOR/ADMIN |
| PUT    | `/cards/{id}` | EDITOR/ADMIN |
| DELETE | `/cards/{id}` | ADMIN        |

### Decks

| Method | Endpoint      | Auth        |
| ------ | ------------- | ----------- |
| GET    | `/decks`      | No          |
| GET    | `/decks/{id}` | No          |
| POST   | `/decks`      | Yes         |
| PUT    | `/decks/{id}` | Owner/ADMIN |
| DELETE | `/decks/{id}` | Owner/ADMIN |

### Tier List

| Method | Endpoint               | Auth         |
| ------ | ---------------------- | ------------ |
| GET    | `/tier-list`           | No           |
| PUT    | `/tier-list/{card_id}` | EDITOR/ADMIN |
| GET    | `/tier-list/history`   | EDITOR/ADMIN |

### Users

| Method | Endpoint      | Auth  |
| ------ | ------------- | ----- |
| GET    | `/users`      | ADMIN |
| PUT    | `/users/{id}` | ADMIN |
| DELETE | `/users/{id}` | ADMIN |

---

## Roadmap

### Phase 1 — Base

- [ ] Laravel project setup (Docker, Sanctum, Pint, Larastan, Swagger)
- [ ] Migrations, Models, Enums
- [ ] Authentication + invitation system
- [ ] Sets CRUD
- [ ] Cards CRUD

### Phase 2 — Features

- [ ] Deck Builder (API)
- [ ] Tier List + history
- [ ] Events + notifications

### Phase 3 — Quality

- [ ] Swagger documentation
- [ ] Feature tests
- [ ] Pint + Larastan passing clean

### Phase 4 — Frontend

- [ ] React + Vite + Tailwind + Shadcn setup
- [ ] Card listing and filters
- [ ] Card detail page
- [ ] Deck Builder (UI)
- [ ] Tier List (UI)
- [ ] Editor panel (card registration)

### Phase 5 — Product

- [ ] Deploy backend (Railway / Fly.io)
- [ ] Deploy frontend (Vercel)
- [ ] Custom domain
- [ ] Google AdSense integration

---

## Status

```
⬜ Phase 1 — Base
⬜ Phase 2 — Features
⬜ Phase 3 — Quality
⬜ Phase 4 — Frontend
⬜ Phase 5 — Product
```

# optcg-tracker-api

REST API for tracking One Piece TCG Japanese spoilers, deck building and meta analysis.

---

## Related Repositories

- **[optcg-tracker-web](https://github.com/RaulJPNeto/optcg-tracker-web)** — React frontend

---

## Tech Stack

- **Laravel 11** — PHP framework
- **PostgreSQL** — relational database
- **Docker** — containerized environment
- **Laravel Sanctum** — token-based authentication
- **Swagger / OpenAPI** — interactive API documentation
- **Mailtrap** — email testing in development
- **Laravel Pint** — code formatting
- **Larastan** — static analysis

---

## Architecture

```
Request → FormRequest → Controller → Service/Query → Model → Resource → Response
```

| Layer       | Responsibility            |
| ----------- | ------------------------- |
| Controller  | HTTP orchestration        |
| Service     | Write business logic      |
| Query       | Read, filters, pagination |
| FormRequest | Input validation          |
| Policy      | Authorization rules       |
| Resource    | Response transformation   |

---

## Roles & Access Control

| Role     | Permissions                               |
| -------- | ----------------------------------------- |
| `ADMIN`  | Full access + manage users + send invites |
| `EDITOR` | Register and edit cards, sets, tier list  |
| `VIEWER` | Read only (public, no login required)     |

Access to the system requires an invitation sent by an `ADMIN`.

---

## Enums

| Enum            | Values                                              |
| --------------- | --------------------------------------------------- |
| `UserRole`      | `ADMIN`, `EDITOR`, `VIEWER`                         |
| `CardType`      | `LEADER`, `CHARACTER`, `EVENT`, `STAGE`             |
| `CardColor`     | `RED`, `BLUE`, `GREEN`, `YELLOW`, `PURPLE`, `BLACK` |
| `CardAttribute` | `SLASH`, `RANGED`, `SPECIAL`, `WISDOM`, `STRIKE`    |
| `Tier`          | `S`, `A`, `B`, `C`, `D`                             |

---

## API Endpoints

### Auth

| Method | Endpoint                         | Auth |
| ------ | -------------------------------- | ---- |
| POST   | `/api/auth/register-with-invite` | No   |
| POST   | `/api/auth/login`                | No   |
| POST   | `/api/auth/logout`               | Yes  |
| GET    | `/api/auth/me`                   | Yes  |

### Invitations

| Method | Endpoint                   | Auth  |
| ------ | -------------------------- | ----- |
| POST   | `/api/invitations`         | ADMIN |
| GET    | `/api/invitations`         | ADMIN |
| GET    | `/api/invitations/{token}` | No    |

### Sets

| Method | Endpoint         | Auth         |
| ------ | ---------------- | ------------ |
| GET    | `/api/sets`      | No           |
| GET    | `/api/sets/{id}` | No           |
| POST   | `/api/sets`      | EDITOR/ADMIN |
| PUT    | `/api/sets/{id}` | EDITOR/ADMIN |
| DELETE | `/api/sets/{id}` | ADMIN        |

### Cards

| Method | Endpoint          | Auth         |
| ------ | ----------------- | ------------ |
| GET    | `/api/cards`      | No           |
| GET    | `/api/cards/{id}` | No           |
| POST   | `/api/cards`      | EDITOR/ADMIN |
| PUT    | `/api/cards/{id}` | EDITOR/ADMIN |
| DELETE | `/api/cards/{id}` | ADMIN        |

### Decks

| Method | Endpoint          | Auth        |
| ------ | ----------------- | ----------- |
| GET    | `/api/decks`      | No          |
| GET    | `/api/decks/{id}` | No          |
| POST   | `/api/decks`      | Yes         |
| PUT    | `/api/decks/{id}` | Owner/ADMIN |
| DELETE | `/api/decks/{id}` | Owner/ADMIN |

### Tier List

| Method | Endpoint                   | Auth         |
| ------ | -------------------------- | ------------ |
| GET    | `/api/tier-list`           | No           |
| PUT    | `/api/tier-list/{card_id}` | EDITOR/ADMIN |
| GET    | `/api/tier-list/history`   | EDITOR/ADMIN |

### Users

| Method | Endpoint          | Auth  |
| ------ | ----------------- | ----- |
| GET    | `/api/users`      | ADMIN |
| PUT    | `/api/users/{id}` | ADMIN |
| DELETE | `/api/users/{id}` | ADMIN |

All authenticated routes require:

```
Authorization: Bearer {token}
```

---

## API Documentation

Interactive documentation available via Swagger UI after starting the project:

```
http://localhost:8000/api/documentation
```

---

## Getting Started

### Requirements

- Docker
- Docker Compose

### Setup

```bash
# Clone the repository
git clone https://github.com/RaulJPNeto/optcg-tracker-api.git
cd optcg-tracker-api

# Copy environment file
cp .env.example .env

# Start containers
docker compose up -d

# Fix permissions
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache

# Install dependencies
docker compose exec app composer install

# Generate app key
docker compose exec app php artisan key:generate

# Run migrations and seed
docker compose exec app php artisan migrate:fresh --seed
```

### Environment — Mail (Mailtrap)

Add your Mailtrap credentials to `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@optcgtracker.com
MAIL_FROM_NAME="OPTCG Tracker"
```

### Default Users (seeded)

| Role  | Email            | Password   |
| ----- | ---------------- | ---------- |
| Admin | `admin@test.com` | `password` |

---

## Development

```bash
# Format code
docker compose exec app composer pint

# Check formatting without applying
docker compose exec app composer pint:test

# Run static analysis
docker compose exec app composer stan

# Format + analyse
docker compose exec app composer check

# Generate Swagger docs
docker compose exec app php artisan l5-swagger:generate

# Generate Swagger docs file for a new controller
docker compose exec app php artisan make:swagger ExampleController

# Run all tests
docker compose exec app php artisan test

# Run migrations fresh with seed
docker compose exec app php artisan migrate:fresh --seed
```

---

## Testing

Feature tests covering all modules:

```
tests/
└── Feature/
    ├── Auth/
    ├── Invitations/
    ├── Sets/
    ├── Cards/
    ├── Decks/
    ├── TierList/
    └── Users/
```

Run all tests:

```bash
docker compose exec app php artisan test
```

---

## Commit Convention

This project follows [Conventional Commits](https://www.conventionalcommits.org/).

### Format

```
<type>: <short description>
```

### Types

| Type       | When to use                              |
| ---------- | ---------------------------------------- |
| `feat`     | New feature or endpoint                  |
| `fix`      | Bug fix                                  |
| `refactor` | Code change that is not a fix or feature |
| `chore`    | Config, dependencies, tooling            |
| `docs`     | Documentation only                       |
| `test`     | Adding or updating tests                 |
| `style`    | Formatting, missing semicolons, etc.     |

---

## Project Status

```
⬜ Authentication + invitation system
⬜ Sets CRUD
⬜ Cards CRUD
⬜ Deck Builder
⬜ Tier List + history
⬜ Events & notifications
⬜ Swagger documentation
⬜ Automated tests
⬜ Pint + Larastan
```

---

## License

[MIT](LICENSE)

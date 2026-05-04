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

- [x] Laravel project setup (Docker, Sanctum, Pint, Larastan, Swagger)
- [x] Migrations, Models, Enums
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
🔄 Phase 1 — Base
⬜ Phase 2 — Features
⬜ Phase 3 — Quality
⬜ Phase 4 — Frontend
⬜ Phase 5 — Product
```

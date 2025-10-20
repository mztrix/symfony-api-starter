# Symfony API Starter

A modern, ready-to-use starter to build REST APIs with Symfony + API Platform. Dockerized, typed, tested, and equipped with quality tooling.

[![License: MIT](https://img.shields.io/badge/License-MIT-green)](https://opensource.org/licenses/MIT)
![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777bb3?logo=php&logoColor=white)
![Symfony 7.3](https://img.shields.io/badge/Symfony-7.3-black?logo=symfony)
![API Platform 4.2](https://img.shields.io/badge/API%20Platform-4.2-3849D4?logo=apiplatform&logoColor=white)
![Doctrine ORM 3.5](https://img.shields.io/badge/Doctrine%20ORM-3.5-f57600)
![PostgreSQL 17](https://img.shields.io/badge/PostgreSQL-17-336791?logo=postgresql&logoColor=white)
![Docker Ready](https://img.shields.io/badge/Docker-ready-2496ED?logo=docker&logoColor=white)


Note: This repository is a GitHub template. To get started, click “Use this template” on GitHub or fork/clone this project.


---

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Environment Configuration](#environment-configuration)
- [Composer Scripts](#composer-scripts)
- [Tests](#tests)
- [Code Quality](#code-quality)
- [Project Structure](#project-structure)
- [Tips & Gotchas](#tips--gotchas)
- [Security](#security)
- [Support](#support)

## Overview
- Production‑grade Symfony 7.3 + API Platform 4.2 starter.
- Dockerized stack (Nginx + PHP‑FPM + PostgreSQL) for local dev and CI.
- Clean developer experience: migrations, fixtures, testing, and code‑quality tooling.
- Live API docs at http://localhost:8080/docs when Docker is running.

## Features
- API Platform 4.2 with built-in documentation (/docs) and OpenAPI export.
- JWT authentication (lexik) + refresh tokens (gesdinet, single_use=true).
- Docker stack (Nginx + PHP-FPM) and PostgreSQL 17.
- Developer tooling ready: PHPUnit 12, Zenstruck Browser/Foundry, DAMA Doctrine Test Bundle, PHPStan, Rector, PHP CS Fixer.
- Doctrine migrations, Foundry factories, demo stories, versioned OpenAPI export.

## Prerequisites
- Docker and Docker Compose (recommended), or
- PHP 8.4+ with required extensions and Composer 2.x
- PostgreSQL 17 accessible via DATABASE_URL

## Quick Start

### Docker (recommended)
1. Clone the repository:
   ```bash
   git clone https://github.com/mztrix/symfony-api-starter
   cd symfony-api-starter
   ```
2. Copy and adapt the override to expose ports:
   ```bash
   cp compose.override.yaml.dist compose.override.yaml
   ```
3. Start the environment:
   ```bash
   docker compose build --no-cache
   docker compose up -d --wait
   ```
4. Open the API docs: http://localhost:8080/docs (port configurable in compose.override.yaml)

## Environment Configuration
- Copy .env to .env.local and override as needed:
  - APP_ENV (dev|prod)
  - DATABASE_URL (PostgreSQL recommended)
  - CORS_ALLOW_ORIGIN
  - JWT_SECRET_KEY, JWT_PUBLIC_KEY, JWT_PASSPHRASE (keys live under config/jwt)
- Test env derives DB name suffix from TEST_TOKEN (see below).


## Composer Scripts
- Tests: `composer run run:tests`
- Fixtures: `composer run run:fixtures`
- OpenAPI export: `composer run run:export-openapi-doc`
- PHP CS Fixer: `composer run run:php-cs-fixer`
- Rector: `composer run run:rector`


## Tests
- Tooling: PHPUnit 12, Foundry, Zenstruck Browser, DAMA Doctrine Test Bundle.
- Run tests:
  ```bash
  docker compose exec app-php bin/phpunit --testdox
  ```
- Prepare test DB/schema (first time):
  ```bash
  docker compose exec app-php bin/console doctrine:database:create --if-not-exists -e test
  docker compose exec app-php bin/console doctrine:migrations:migrate -n -e test
  docker compose exec app-php bin/console doctrine:fixtures:load -n -e test  # optional
  ```
- Parallel/isolated runs: set TEST_TOKEN to suffix the test DB name
  ```bash
  TEST_TOKEN=A docker compose exec app-php bin/phpunit --testdox
  ```

## Code Quality
- PHP CS Fixer (PSR-12): `composer run run:php-cs-fixer`
- Rector (upgrades/refactoring): `composer run run:rector`
- PHPStan: `vendor/bin/phpstan analyse`

## Project Structure
- config/ … Symfony & bundles configuration (Doctrine, API Platform, etc.)
- src/ApiPlatform … API Platform helpers/infrastructure
- src/Auth … JWT/RefreshToken and security integrations
- src/Users … user entities and resources
- fixtures/ … Foundry factories & stories (e.g., DemoStory)
- public/ … served by Nginx, /docs UI
- tests/Functional … functional tests (Zenstruck Browser/Foundry)

## Tips & Gotchas
- Two environments: dev/test; test DB name is suffixed with TEST_TOKEN for parallel runs.
- DAMA Doctrine Test Bundle wraps each test in a transaction; ensure the test schema exists (create DB and run migrations with -e test).
- Docker: copy compose.override.yaml.dist to compose.override.yaml to expose ports before starting; health checks are enabled.
- JWT keys live in config/jwt; ensure JWT_SECRET_KEY, JWT_PUBLIC_KEY, JWT_PASSPHRASE in .env(.local) match.
- OpenAPI export: `composer run run:export-openapi-doc` writes openapi.json at repo root.
- If functional tests 401/403, use actingAs(...) with a User via Foundry and check security rules.
- PHP >= 8.4 required; rebuild Docker images if you bump PHP.

## Security
To report a vulnerability, contact us directly. Avoid opening a public issue for sensitive problems.

## Support
- Open an issue on the repository.
- Or reach out via your usual (internal/private) channel.

# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress site using the [Bedrock](https://roots.io/bedrock/) boilerplate with a custom [Timber 2.x](https://timber.github.io/docs/) theme. Bedrock manages WordPress as a Composer dependency and enforces environment-based configuration. Timber brings Twig templating to WordPress.

## Commands

### From the project root

```bash
composer lint          # Check code style (Laravel Pint, PER preset)
composer lint:fix      # Auto-fix code style issues
composer test          # Run Pest tests
wp --info              # WP-CLI (docroot: web/, wp path: web/wp/)
```

### From the theme directory (`web/app/themes/hidroelectricas-theme/`)

```bash
composer test          # Run PHPUnit tests
```

## Architecture

### Bedrock directory layout

```
/
├── config/
│   ├── application.php          # WordPress constants, loads .env
│   └── environments/            # Per-environment overrides (development, staging, production)
├── web/
│   ├── index.php                # Web root entry point
│   ├── wp/                      # WordPress core (Composer-managed, do not edit)
│   └── app/                     # Replaces wp-content/
│       ├── mu-plugins/
│       ├── plugins/
│       ├── themes/
│       │   └── hidroelectricas-theme/
│       └── uploads/
├── .env                         # Local environment variables (not committed)
├── pint.json                    # Linting config
└── wp-cli.yml                   # WP-CLI path config
```

### Theme architecture

The theme lives at `web/app/themes/hidroelectricas-theme/` and follows the Timber 2 starter pattern:

- **`functions.php`** — bootstraps the theme by instantiating `StarterSite`
- **`src/StarterSite.php`** — main theme class (`extends Timber\Site`). All hooks, context additions, Twig extensions, and theme-support registrations go here. Add custom post types in `register_post_types()` and taxonomies in `register_taxonomies()`.
- **`*.php` template files** (index, single, page, archive, etc.) — thin WordPress template files that collect context and call `Timber::render('template.twig', $context)`
- **`views/*.twig`** — Twig templates following the WordPress template hierarchy. `base.twig` is the layout parent; other templates extend it.
- **`static/`** — front-end assets (CSS, JS); no build pipeline, managed manually.

### Data flow

WordPress template file → builds `$context` via `Timber::context()` → passes to `Timber::render()` → Twig template in `views/` renders final HTML.

Context shared across all templates is set in `StarterSite::add_to_context()` (e.g., menus, sidebar, site object).

### Environment configuration

Copy `.env.example` to `.env` and set at minimum: `DB_*`, `WP_HOME`, `WP_SITEURL`, and the 8 WordPress security salts. `WP_ENV` controls which file in `config/environments/` is loaded.

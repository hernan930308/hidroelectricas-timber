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

- **`functions.php`** — bootstraps the theme by instantiating `StarterSite` and `WooCommerceTheme`
- **`src/StarterSite.php`** — main theme class (`extends Timber\Site`). theme hooks,theme context additions, Twig extensions, and theme-support registrations go here.
- **`src/WooCommerceTheme`** — All woocommerce hooks, theme-support registrations for woocommerce.
- **`*.php` template files** (index, single, page, archive, etc.) — thin WordPress template files that collect context and call `Timber::render('template.twig', $context)`
- **`views/*.twig`** — Twig templates following the WordPress template hierarchy. `base.twig` is the layout parent; other templates extend it.
- **`assets/`** — front-end assets; no build pipeline, managed manually.
  - `fonts/` — Neo Sans Pro OTF family
  - `icons/` — SVG icons
  - `img/` — raster images
  - `js/` — `app.js` (main), `swiper.js` (slider)
  - `styles/app.css` — entry point; declares `@layer` order and imports Tailwind + all partials
  - `styles/tokens.css` — CSS custom properties (colors, spacing); no `@layer`, globally scoped
  - `styles/base/`, `styles/components/`, `styles/layouts/`, `styles/woocommerce/` — partials by concern

### Data flow

WordPress template file → builds `$context` via `Timber::context()` → passes to `Timber::render()` → Twig template in `views/` renders final HTML.

Context shared across all templates is set in `StarterSite::add_to_context()` (e.g., menus, sidebar, site object).

### Environment configuration

 `WP_ENV` controls which file in `config/environments/` is loaded.

### WooCommerce + Timber Integration (`mindkomm/timber-integration-woocommerce`)

WooCommerce templates live in `views/woocommerce/` (Twig files mirror the WooCommerce PHP template hierarchy).

**Twig template selection order** (first match wins):

| Page type | Twig lookup order |
|---|---|
| Single product | `single-{post_name}.twig` → `single-product.twig` → `single.twig` |
| Taxonomy archive | `taxonomy-{tax}-{slug}.twig` → `taxonomy-{slug}.twig` → `taxonomy.twig` |
| Shop archive | `archive-product.twig` → `archive.twig` |

> `single-product-reviews.twig` **cannot** override the reviews template — use hooks instead.

**Context variables available in WooCommerce Twig templates:**
- `post` — `Timber\Product` instance on product pages; `Timber\Post` on shop/archive pages
- `product` — raw WooCommerce product object (set automatically in loops)
- `cart` — WooCommerce cart object (available on all pages)
- `term` — set when on a product taxonomy archive
- `title` — result of `woocommerce_page_title()`
- `wc` — WooCommerce globals that would normally be PHP globals are scoped here (e.g. `wc.related_products`)

### Design considerations
- The majority of the designs respect wide container.
- The post and news text would be enter a content-container.
- Onli specific sections have full wide.
- Use Tailwind, except for WooCommerce templates, because to avoid recreating full templates as much as possible, the redesign is done through strategic WooCommerce classes.

## Git flow 
When prompted to `start git feature finished` flow, do the following:

Run 
``` git add .```. Then create a commit with ```git commit -m "feat: short phrase describing the changes in the last commit"```, After that, merge from `qa` to the `feature/feature-finished` branch.
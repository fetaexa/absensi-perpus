# frontend

This template should help get you started developing with Vue 3 in Vite.

## Recommended IDE Setup

[VS Code](https://code.visualstudio.com/) + [Vue (Official)](https://marketplace.visualstudio.com/items?itemName=Vue.volar) (and disable Vetur).

## Recommended Browser Setup

- Chromium-based browsers (Chrome, Edge, Brave, etc.):
  - [Vue.js devtools](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd)
  - [Turn on Custom Object Formatter in Chrome DevTools](http://bit.ly/object-formatters)
- Firefox:
  - [Vue.js devtools](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)
  - [Turn on Custom Object Formatter in Firefox DevTools](https://fxdx.dev/firefox-devtools-custom-object-formatters/)

## Customize configuration

See [Vite Configuration Reference](https://vite.dev/config/).

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```

### Backend API

For local development, start the Laravel backend:

```sh
cd ../backend
php artisan migrate
php artisan serve
```

By default, the frontend sends API requests to `http://127.0.0.1:8000/api`.
GitHub Pages only hosts the frontend, so deploy the Laravel backend separately
to use login, profile, and attendance features.

#### Free demo deployment (Render + Neon)

Render's free web service sleeps after inactivity, so the first request can
take about a minute to wake up. Use Neon for the database: Render's free
Postgres expires after 30 days.

1. Create a free PostgreSQL project at [Neon](https://neon.com/). Copy its
   connection string and keep it private.
2. In [Render](https://render.com/), create a **Web Service** from this GitHub
   repository. Set **Root Directory** to `backend`, **Language** to **Docker**,
   and choose the **Free** instance type.
3. Add these environment variables to the Render service:
   - `APP_KEY`: generate locally with `php artisan key:generate --show` from
     `backend`; keep the generated value private.
   - `APP_URL`: the Render service URL, such as `https://your-api.onrender.com`.
   - `DB_CONNECTION`: `pgsql`.
   - `DB_URL`: the Neon connection string, including `sslmode=require`.
   - `STEMBAYO_LOGIN_PASSWORD`: `stembayo123`.
4. Wait for the Render deployment to finish. The container runs database
   migrations on startup.
5. In GitHub, open **Settings > Secrets and variables > Actions > Variables**,
   create `VITE_API_BASE_URL`, and set it to the Render URL plus `/api`, for
   example `https://your-api.onrender.com/api`.
6. Rerun **Deploy to GitHub Pages** from the repository's **Actions** tab so
   the frontend is rebuilt with the public API URL.

The scanner records attendance as soon as it reads a QR code; no room or
subject details are needed. Each signed-in student can scan the same QR once
per day, and the history shows only the attendance date and status.

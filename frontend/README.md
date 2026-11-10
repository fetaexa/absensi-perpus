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

The login and profile features require the Laravel backend to be running:

```sh
cd ../backend
php artisan migrate
php artisan serve
```

By default, the frontend sends API requests to `http://127.0.0.1:8000/api`. Set
`VITE_API_BASE_URL` to the deployed backend API URL when building for production.
For the GitHub Pages workflow, add it as a repository variable under
**Settings > Secrets and variables > Actions > Variables**. For example:
`https://api.example.com/api`.

GitHub Pages only hosts the frontend; the Laravel backend must be hosted
separately with a persistent database. Configure the backend's
`STEMBAYO_LOGIN_PASSWORD` to `stembayo123` and run `php artisan migrate --force`
after deployment.

The scanner records attendance as soon as it reads a QR code; no room or
subject details are needed. Each signed-in student can scan the same QR once
per day, and the history shows only the attendance date and status.

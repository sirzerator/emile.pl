# emile.pl - My personal website

## Developing

Start the backend and frontend dev servers:

```bash
npm run dev
```

## Deploying

- Run `composer install --no-dev` in the "api" folder to remove dev dependencies
- Send to the server while in the root folder with
  `rsync -av --delete --exclude=.env --exclude=stats --exclude=storage FOLDER USER@HOST:PATH/api` and.
  `rsync -av --delete --exclude=.env frontend/ USER@HOST:PATH/private/`.
- Run `php8.1 artisan migrate` through SSH while in the "api" directory.
- Run `npm run build` through SSH while in the "private" directory.
- Run `HOST=127.0.0.1 PORT=4123 ORIGIN=https://emile.pl nohup node build &`
  through SSH while in the "private" directory.

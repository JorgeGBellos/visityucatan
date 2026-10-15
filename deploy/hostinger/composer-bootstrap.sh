#!/bin/bash
set -e
ROOT="/home/u620697284/domains/aquamarine-cat-898212.hostingersite.com/public_html/visityucatan"
cd "$ROOT"

# Website PHP is 8.3; Hostinger cron default CLI is often 8.1.
for candidate in /opt/alt/php83/usr/bin/php /opt/alt/php84/usr/bin/php php83 php; do
  if command -v "$candidate" >/dev/null 2>&1 || [ -x "$candidate" ]; then
    PHP="$candidate"
    break
  fi
done
PHP="${PHP:-php}"

if [ ! -f .env ] && [ -f ../../laravel/.env ]; then
  cp ../../laravel/.env .env
fi

if command -v composer >/dev/null 2>&1; then
  $PHP "$(command -v composer)" install --no-dev --no-interaction --optimize-autoloader --no-scripts
else
  $PHP /usr/local/bin/composer install --no-dev --no-interaction --optimize-autoloader --no-scripts
fi

$PHP artisan package:discover --ansi || true
$PHP artisan view:clear || true
$PHP artisan config:clear || true
date > storage/logs/hostinger-composer.done
echo "PHP=$PHP done" >> storage/logs/hostinger-composer.done

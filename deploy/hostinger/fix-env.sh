#!/bin/bash
set -e
ROOT="/home/u620697284/domains/aquamarine-cat-898212.hostingersite.com"
NEW="$ROOT/public_html/visityucatan"
OLD="$ROOT/laravel"
LOG="$NEW/storage/logs/diag.txt"
PHP="/opt/alt/php83/usr/bin/php"
{
  echo "=== $(date -Is) ==="
  ls -la "$NEW/.env" "$OLD/.env" "$OLD/database/database.sqlite" "$NEW/database/database.sqlite" 2>&1 || true
  if [ -f "$OLD/.env" ]; then
    cp "$OLD/.env" "$NEW/.env"
    echo "COPIED_ENV"
  fi
  if [ -f "$OLD/database/database.sqlite" ]; then
    mkdir -p "$NEW/database"
    cp "$OLD/database/database.sqlite" "$NEW/database/database.sqlite"
    chmod ug+rw "$NEW/database/database.sqlite" 2>&1 || true
    echo "COPIED_SQLITE"
  fi
  # Absolute DB path so relative cwd never breaks sqlite
  if grep -q 'DB_CONNECTION=sqlite' "$NEW/.env" 2>/dev/null; then
    if ! grep -q '^DB_DATABASE=' "$NEW/.env"; then
      echo "DB_DATABASE=$NEW/database/database.sqlite" >> "$NEW/.env"
      echo "ADDED_DB_DATABASE"
    else
      sed -i "s|^DB_DATABASE=.*|DB_DATABASE=$NEW/database/database.sqlite|" "$NEW/.env"
      echo "SET_DB_DATABASE_ABS"
    fi
  fi
  mkdir -p "$NEW/storage/framework/"{cache/data,sessions,views} "$NEW/storage/logs" "$NEW/bootstrap/cache"
  chmod -R ug+rwx "$NEW/storage" "$NEW/bootstrap/cache" "$NEW/database" 2>&1 || true
  rm -f "$NEW/bootstrap/cache/"*.php 2>/dev/null || true
  cd "$NEW"
  $PHP artisan config:clear 2>&1 || true
  $PHP artisan view:clear 2>&1 || true
  $PHP artisan route:clear 2>&1 || true
  $PHP artisan about --only=environment 2>&1 || true
  $PHP artisan db:show 2>&1 || true
  $PHP -r '
    require "vendor/autoload.php";
    $app = require "bootstrap/app.php";
    $app->usePublicPath(dirname(__DIR__));
    echo "BOOT_OK\n";
  ' 2>&1 || true
  echo DONE
} > "$LOG" 2>&1

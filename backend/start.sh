#!/bin/sh
set -e

echo "Run db migration"
/migrate -path /var/www/zalora.testproject.onl/backend/db/migration -database "$DB_SOURCE" -verbose up

echo "start the app"
exec "$@"

#!/bin/sh

# Wait until the MySQL server is available
until docker-compose exec db mysqladmin ping -h "db" --silent; do
  echo "Waiting for the database to be ready..."
  sleep 2
done

echo "Database is ready! Starting the app..."
exec "$@"

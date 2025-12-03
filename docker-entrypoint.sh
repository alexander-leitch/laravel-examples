#!/bin/sh

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until nc -z -v -w30 mysql 3306
do
  echo "Waiting for database connection..."
  sleep 5
done

echo "MySQL is ready!"



## Execute the passed command
exec "$@"

#!/bin/sh
echo "Starting PHP on port $PORT"
exec php -S 0.0.0.0:$PORT -t public/
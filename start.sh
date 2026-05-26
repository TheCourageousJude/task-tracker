#!/bin/sh
echo "PORT value is: '$PORT'"
echo "All env vars:"
env
exec php -S 0.0.0.0:$PORT -t public/
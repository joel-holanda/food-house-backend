#!/bin/sh

if [ ! -d "vendor" ]; then
    echo "Pasta 'vendor' não encontrada. Rodando comando 'composer install' ....."
    composer install
fi

# Start Symfony local server
symfony local:server:start
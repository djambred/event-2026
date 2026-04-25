#!/bin/bash

# ============================================================
# Init Let's Encrypt untuk international-events.esaunggul.ac.id
# Jalankan sekali sebelum docker-compose up pertama kali
# ============================================================

DOMAIN="international-events.esaunggul.ac.id"
EMAIL="admin@esaunggul.ac.id"   # Ganti dengan email Anda
STAGING=0                        # Set ke 1 untuk testing (hindari rate limit)
DATA_PATH="./certbot"

# Buat direktori yang dibutuhkan
mkdir -p "$DATA_PATH/conf"
mkdir -p "$DATA_PATH/www"

# Download recommended TLS parameters dari certbot
if [ ! -e "$DATA_PATH/conf/options-ssl-nginx.conf" ] || [ ! -e "$DATA_PATH/conf/ssl-dhparams.pem" ]; then
  echo "### Downloading recommended TLS parameters ..."
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot-nginx/certbot_nginx/_internal/tls_configs/options-ssl-nginx.conf \
    -o "$DATA_PATH/conf/options-ssl-nginx.conf"
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot/certbot/ssl-dhparams.pem \
    -o "$DATA_PATH/conf/ssl-dhparams.pem"
  echo ""
fi

# Buat sertifikat dummy agar nginx bisa start pertama kali
if [ ! -d "$DATA_PATH/conf/live/$DOMAIN" ]; then
  echo "### Creating dummy certificate for $DOMAIN ..."
  mkdir -p "$DATA_PATH/conf/live/$DOMAIN"
  docker run --rm \
    -v "$PWD/$DATA_PATH/conf:/etc/letsencrypt" \
    certbot/certbot:latest \
    certonly --non-interactive \
    --standalone --preferred-challenges http \
    --agree-tos --email "$EMAIL" \
    -d "$DOMAIN" \
    2>/dev/null || \
  docker run --rm \
    -v "$PWD/$DATA_PATH/conf:/etc/letsencrypt" \
    certbot/certbot:latest \
    certificates 2>/dev/null || \
  openssl req -x509 -nodes -newkey rsa:4096 -days 1 \
    -keyout "$DATA_PATH/conf/live/$DOMAIN/privkey.pem" \
    -out "$DATA_PATH/conf/live/$DOMAIN/fullchain.pem" \
    -subj "/CN=$DOMAIN" 2>/dev/null
  echo ""
fi

# Start nginx saja dulu (tanpa certbot)
echo "### Starting nginx ..."
docker compose up --force-recreate --no-deps -d nginx
echo ""

# Minta sertifikat asli dari Let's Encrypt
echo "### Requesting Let's Encrypt certificate for $DOMAIN ..."

STAGING_ARG=""
if [ "$STAGING" != "0" ]; then
  STAGING_ARG="--staging"
fi

docker compose run --rm --entrypoint "\
  certbot certonly --webroot \
    --webroot-path /var/www/certbot \
    --email $EMAIL \
    --agree-tos \
    --no-eff-email \
    $STAGING_ARG \
    -d $DOMAIN" certbot
echo ""

# Reload nginx dengan sertifikat asli
echo "### Reloading nginx ..."
docker compose exec nginx nginx -s reload
echo ""

echo "### Selesai! Sertifikat Let's Encrypt berhasil dipasang."
echo "### Jalankan 'docker compose up -d' untuk memulai semua service."

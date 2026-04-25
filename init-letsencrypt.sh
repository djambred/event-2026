#!/bin/bash

# ============================================================
# Init Let's Encrypt untuk international-events2026.esaunggul.ac.id
# Jalankan sekali sebelum docker-compose up pertama kali
# ============================================================

DOMAIN="international-events2026.esaunggul.ac.id"
EMAIL="jefry.sunupurwa@esaunggul.ac.id"   # Ganti dengan email Anda
STAGING=0                        # Set ke 1 untuk testing (hindari rate limit)
DATA_PATH="./certbot"

# Buat direktori yang dibutuhkan
mkdir -p "$DATA_PATH/conf/live/$DOMAIN"
mkdir -p "$DATA_PATH/www"

echo "### Membuat dummy certificate untuk $DOMAIN agar nginx bisa start ..."
openssl req -x509 -nodes -newkey rsa:2048 -days 1 \
  -keyout "$DATA_PATH/conf/live/$DOMAIN/privkey.pem" \
  -out "$DATA_PATH/conf/live/$DOMAIN/fullchain.pem" \
  -subj "/CN=$DOMAIN"
echo ""

# Start nginx dengan dummy cert
echo "### Menjalankan nginx ..."
docker compose up --force-recreate --no-deps -d nginx
echo ""

# Tunggu nginx ready
sleep 3

# Minta sertifikat asli dari Let's Encrypt via webroot
echo "### Meminta sertifikat Let's Encrypt untuk $DOMAIN ..."

STAGING_ARG=""
if [ "$STAGING" != "0" ]; then
  STAGING_ARG="--staging"
fi

docker compose run --rm certbot certonly --webroot \
  --webroot-path /var/www/certbot \
  --email "$EMAIL" \
  --agree-tos \
  --no-eff-email \
  $STAGING_ARG \
  -d "$DOMAIN"
echo ""

# Reload nginx dengan sertifikat asli
echo "### Reload nginx dengan sertifikat Let's Encrypt ..."
docker compose exec nginx nginx -s reload
echo ""

echo "=== Selesai! Sertifikat Let's Encrypt berhasil dipasang untuk $DOMAIN ==="
echo "=== Jalankan 'docker compose up -d' untuk memulai semua service. ==="

echo ""

# Reload nginx dengan sertifikat asli
echo "### Reloading nginx ..."
docker compose exec nginx nginx -s reload
echo ""

echo "### Selesai! Sertifikat Let's Encrypt berhasil dipasang."
echo "### Jalankan 'docker compose up -d' untuk memulai semua service."

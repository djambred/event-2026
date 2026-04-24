FROM nginx:stable-alpine

ENV TZ="Asia/Jakarta"
ENV PS1="\u@\h:\w\\$ "

RUN apk add --no-cache bash
RUN apk add --no-cache tzdata

# Create www-data user/group with same UID/GID as PHP-FPM container (uid=33)
RUN addgroup -g 33 -S www-data 2>/dev/null || true && \
    adduser -u 33 -D -S -G www-data www-data 2>/dev/null || true && \
    sed -i 's/user  nginx;/user  www-data;/' /etc/nginx/nginx.conf
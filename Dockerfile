FROM ghcr.io/roadrunner-server/roadrunner:2023.2.1 AS roadrunner
FROM composer:2.4.4 AS composer
FROM php:8.2.8-cli-alpine
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
RUN apk add --no-cache linux-headers unzip && docker-php-ext-install -j$(nproc) sockets
WORKDIR /app
COPY . /app
RUN composer install --prefer-dist --optimize-autoloader && composer require --prefer-dist --optimize-autoloader spiral/roadrunner-http nyholm/psr7 nikic/fast-route
ENTRYPOINT rr --WorkDir /app serve
# Service starts at 8080 port in container
# So make sure use of this port
EXPOSE 8080
ENV NUM_WORKERS 4
ENV NUM_REQUESTS_BEFORE_RESET 0
ENV DEBUG false

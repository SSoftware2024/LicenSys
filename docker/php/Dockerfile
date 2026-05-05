FROM php:8.4-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP necessárias para o Laravel
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    calendar \
    zip

# Instala extensão Redis (via PECL)
RUN pecl install redis && docker-php-ext-enable redis

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o projeto para dentro do container
COPY . .

# Ajusta permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# Expõe porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
# Dockerfile para Laravel (Última versión)
FROM php:8.3-apache

# Instalar extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuración de Apache
RUN a2enmod rewrite

WORKDIR /var/www/html

# Exponer el puerto
EXPOSE 80
CMD ["apache2-foreground"]

# Establecer permisos correctos para Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

    # Configurar Apache para servir desde public/
WORKDIR /var/www/html
COPY ./src /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Apunta la raíz del servidor Apache a public/
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite


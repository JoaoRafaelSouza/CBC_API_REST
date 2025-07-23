FROM php:8.2-apache

# Instala extensões necessárias (ajuste conforme necessidade)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa mod_rewrite para URL amigável (útil se usar rotas)
RUN a2enmod rewrite

# Permite sobrescrever config padrão se quiser
# COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
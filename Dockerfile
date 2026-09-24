FROM php:8.1-cli

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Exponer puerto
EXPOSE 8080

# Comando para iniciar servidor PHP
CMD ["php", "-S", "0.0.0.0:8080"]

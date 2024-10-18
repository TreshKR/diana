FROM php:8.3.11-apache-bullseye

# Install required packages and PHP extensions
RUN apt-get update && apt-get install -y \
		libpq-dev \
	&& docker-php-ext-install pgsql pdo pdo_pgsql

# Create a non-root user and assign ownership of the web directory
RUN useradd -m -d /home/jotaerre jotaerre && \
    chown -R jotaerre:www-data /var/www/html

# Copy application files into the container and set the working directory
COPY . /var/www/html
WORKDIR /var/www/html

# Expose port 80 for the web server
EXPOSE 80

# Switch to the non-root user
USER jotaerre
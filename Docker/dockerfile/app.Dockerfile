FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/

# Download and install wkhtmltopdf dependencies.
RUN apt update && apt -y upgrade
RUN apt install -y wget
#RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.buster_amd64.deb
RUN apt install -y \
        fontconfig \
        libfreetype6 \
        libjpeg62-turbo \
        libpng16-16 \
        libx11-6 \
        libxcb1 \
        libxext6 \
        libxrender1 \
        xfonts-75dpi \
        xfonts-base

#RUN dpkg -i wkhtmltox_0.12.6-1.buster_amd64.deb
RUN apt-get install -f
#RUN curl -L https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.bionic_amd64.deb
#RUN dpkg -i wkhtmltox_0.12.6-1.bionic_amd64.deb; apt-get install -y -f
RUN ln -s /usr/local/bin/wkhtmltopdf /usr/bin
RUN ln -s /usr/local/bin/wkhtmltoimage /usr/bin
#RUN chmod +x /usr/local/bin
#RUN ln -s /usr/local/bin/wkhtmltoimage /usr/bin

# Remember to clean your package manager cache to reduce your custom image size...
RUN apt-get clean all \
    && rm -rvf /var/lib/apt/lists/*

#RUN ln -s /usr/local/bin /usr/bin/wkhtmltopdf
#RUN ln -s /usr/local/bin /usr/bin/wkhtmltoimage

# Download the wkhtmltopdf package.
#RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.bionic_amd64.deb

# Install the wkhtmltopdf package.
#RUN gdebi --n wkhtmltox_0.12.6-1.bionic_amd64.deb

# Install dependencies
RUN apt-get update && apt-get install -y \
    libmagickwand-dev \
    libfreetype6-dev \
    libpng-dev \
    libzip-dev \
    locales \
    zip \
    libonig-dev \
    jpegoptim optipng pngquant gifsicle \
    ca-certificates \
    vim \
    libfontconfig \
    unzip \
    tar \
    git \
    cron \
    supervisor \
    default-mysql-client \
    curl 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install -o -f redis &&  rm -rf /tmp/pear && docker-php-ext-enable redis

# install imagick buat generate QRCode
RUN pecl install imagick
RUN docker-php-ext-enable imagick

#RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.bionic_amd64.deb
#RUN gdebi --n wkhtmltox_0.12.6-1.bionic_amd64.deb

#RUN ln -s /usr/bin/wkhtmltopdf /usr/local/bin
#RUN ln -s /usr/bin/wkhtmltoimage /usr/local/bin

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project ke dalam container
COPY . /var/www/
COPY SourceSansPro-Regular.ttf /usr/local/share/fonts
# Copy directory project permission ke container
COPY --chown=www-data:www-data . /var/www/
RUN chown -R www-data:www-data /var/www

# Install dependency
RUN composer install

# Expose port 9000
EXPOSE 9000

# Ganti user ke www-data
USER www-data
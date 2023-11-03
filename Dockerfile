FROM ghcr.io/sebastiengdf/tamara:latest
#ENV http_proxy=http://proxy.srr.fr:880
#ENV https_proxy=http://proxy.srr.fr:880

COPY ./ServeurWEB/ /home/tamara/
COPY 000-default.conf /etc/apache2/sites-available



RUN sed -i 's/output_buffering = 4096/output_buffering = 9096/g' $PHP_INI_DIR/php.ini-development
RUN sed -i 's/memory_limit = 128M/memory_limit = 2G/g' $PHP_INI_DIR/php.ini-development
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 200M/g' $PHP_INI_DIR/php.ini-development
RUN sed -i 's/output_buffering = 4096/output_buffering = 9096/g' $PHP_INI_DIR/php.ini-production
RUN sed -i 's/memory_limit = 128M/memory_limit = 2G/g' $PHP_INI_DIR/php.ini-production
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 200M/g' $PHP_INI_DIR/php.ini-production
RUN sed -i 's/max_execution_time = 30/max_execution_time = 240/g' $PHP_INI_DIR/php.ini-production
RUN sed -i 's/max_execution_time = 30/max_execution_time = 240/g' $PHP_INI_DIR/php.ini-development

RUN cp $PHP_INI_DIR/php.ini-production /usr/local/etc/php/php.ini

chown www-data -R /data #grant write permissions to data directory

useradd staff -g www-data
usermod -aG www-data staff
chown staff:www-data -R /app/wp-content/* 
find /app -type d -exec chmod 755 {} \;  # Change directory permissions rwxr-xr-x
find /app -type f -exec chmod 644 {} \;  # Change file permissions rw-r--r--
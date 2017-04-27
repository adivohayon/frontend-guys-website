# Frontend Guys

## Getting Started
1. Install Docker v17+ (and Docker-Compose v1.1+)
2. Clone repository
3. `npm run setup:dev`
3. Make sure `data/db.sql` exists

## Development
* Start Machine: `docker-machine start dev-machine`
* Stop Machine: `docker-machine stop dev-machine`
* Set Env Variables: `docker-machine env dev-machine`
* Run in each new shell: `eval $(docker-machine env dev-machine)`
* Run Portainer: `docker run portainer`
* Sync Volumes: `docker-osx-dev`
* Watch & Compile Sass: `npm run sass:watch`
* Run App Containers: `docker-compose up -d`
* Stop App Containers: `docker-compose down`




## Web Access
* Website: `dev-machine:8080`  
* Wordpress Dashboard: `dev-machine:8080/wp-admin`
* Angular App: `dev-machine:4200`
* Username: `root`
* Password: `root` 

## Development


## Backup & Restore DB
SQL File: `data/db.sql`  
### Backup
`npm run db:backup`


### Restore
`npm run db:restore`  
* Backup file should be restored upon container start  


## Production  
1. Change `Other Pages Menu` custom links URL for `Prover` & `Contact Us`
2. Reset permissions to 755


Fix Permissions:
useradd staff -g www-data
usermod -aG www-data staff
chown docker:www-data -R /app/wp-content/*
find . -type d -exec chmod -R 775 {} \;
find . -type f -exec chmod -R 664 {} \;


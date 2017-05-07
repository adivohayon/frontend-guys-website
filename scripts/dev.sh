operation=$1;

echo $operation;

red=$'\e[1;31m'
grn=$'\e[1;32m'
yel=$'\e[1;33m'
blu=$'\e[1;34m'
mag=$'\e[1;35m'
cyn=$'\e[1;36m'
end=$'\e[0m'

# --------------------START Dev Environment--------------------
if [ $operation = "start" ]; then
	echo "Starting machine..."
	docker-machine start dev-machine
	docker-machine env dev-machine
	eval $(docker-machine env dev-machine)

	echo "Starting Utility Containers"
	docker-compose -f scripts/dev-environment/docker-compose.yml up -d

	# KIMAI
	KIMAI_PORT="$(docker ps|grep utilities_kimai|sed \
	  's/.*0.0.0.0://g'|sed 's/->.*//g')"
	# Restore DB
	cat data/kimai-backup.sql | docker exec -i utilities_db /usr/bin/mysql -u devenv --password=devenv kimai
	# cat data/kimai-backup.sql  | docker exec -i utilities_db /usr/bin/mysql -u root --password=root kimai

	echo "${grn}Kimai Time-Tracking running on ${end} ${cyn}dev-machine${end}:${yel}${KIMAI_PORT}${end}"

	# PORTAINER
	PORTAINER_PORT="$(docker ps|grep utilities_portainer|sed \
	  's/.*0.0.0.0://g'|sed 's/->.*//g')"
	echo "${grn}Portainer Docker UI running on ${end} ${cyn}dev-machine${end}:${yel}${PORTAINER_PORT}${end}"

	echo "Starting App..."
	sh scripts/app.sh start
fi
# --------------------------------------------------------------


# --------------------STOP Dev Environment--------------------
if [ $operation = "stop" ]; then
	docker-machine env dev-machine
	eval $(docker-machine env dev-machine)

	echo "Gracefully stop apps container and backup databases."
	sh scripts/app.sh stop

	# Backup
	docker exec utilities_db /usr/bin/mysqldump -u devenv --password=devenv kimai > data/kimai-backup.sql


	echo "Stop added utilities."
	docker-compose -f scripts/dev-environment/docker-compose.yml down

	echo "Remove any stopped containers and dangling volumes."
	docker rm $(docker ps -a -q)
	docker volume rm `docker volume ls -q -f dangling=true`

	echo "Stop machine."
	docker-machine stop dev-machine;
	echo "${red}The Dev-Machine and all its apps have been stopped and removed.${end}"
fi
# ------------------------------------------------------------
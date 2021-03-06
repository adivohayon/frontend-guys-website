operation=$1;

echo $operation;

red=$'\e[1;31m'
grn=$'\e[1;32m'
yel=$'\e[1;33m'
blu=$'\e[1;34m'
mag=$'\e[1;35m'
cyn=$'\e[1;36m'
end=$'\e[0m'


docker-machine env dev-machine
eval $(docker-machine env dev-machine)

if [ $operation = "start" ]; then
	docker-compose up -d
	echo "${grn}Wordpress running on${end} ${cyn}dev-machine${end}:${yel}8080${end}"
	echo "${grn}PHPMyAdmin running on${end} ${cyn}dev-machine${end}:${yel}22222${end}"
	echo "${grn}Angular App running on${end} ${cyn}dev-machine${end}:${yel}4200${end}"

	read  -n 1 -p "Once Wordpress is loaded, press any key to fix-permissions..." mainmenuinput
	npm run wordpress:fix-permissions
fi

# --------------------STOP App Containers and Backup--------------------
if [ $operation = "stop" ]; then
	sh scripts/wordpress.sh backup;
	docker-compose down
	echo "${red}All App containers have been stopped and removed.${end}"
fi




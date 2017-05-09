operation=$1;

echo $operation;

# --------------------Colors--------------------
red=$'\e[1;31m'
grn=$'\e[1;32m'
yel=$'\e[1;33m'
blu=$'\e[1;34m'
mag=$'\e[1;35m'
cyn=$'\e[1;36m'
end=$'\e[0m'

# --------------------Helper Functions--------------------
function runInBackground {

	#Check that we receive a second argument for process name
	if [ -z "$2" ]; then
		echo "${yel}runInBackground${end}: ${red}Give the process (${1}) a name as the second argument and try again${end}"
		exit
	else
		PROCESS_NAME=$2
	fi
	#-----------------------------------------------------

	#Check if process exists

	if [ -e "logs/${PROCESS_NAME}_pid.txt" ]; then
		processID=`cat logs/${PROCESS_NAME}_pid.txt`
		if ps -p $processID > /dev/null; then
			# Do something knowing the pid exists, i.e. the process with $PID is running
			echo "${yel}runInBackground${end}: ${red}Process \"${PROCESS_NAME}\" already running in background${end}"
			exit
		fi
	fi
	#-----------------------------------------------------

	echo "Starting and running ${mag}${PROCESS_NAME}${end} in background..."
	nohup $1 > logs/${PROCESS_NAME}.log 2>&1 &
	echo $! > logs/${PROCESS_NAME}_pid.txt
	echo "Logs available at ${cyn}logs/${PROCESS_NAME}.log${end}"
}

function stopBackgroundProcess {
	echo "Stoping and removing ${mag}${1}${end}"
	kill -9 `cat logs/${1}_pid.txt`
	rm logs/${1}_pid.txt
}

function setupEnv {
	docker-machine env dev-machine
	eval $(docker-machine env dev-machine)
}

function dockerCleanup {
	echo "Remove any stopped containers and dangling volumes."
	docker rm $(docker ps -a -q)
	docker volume rm `docker volume ls -q -f dangling=true`
}
# --------------------END Helper Functions--------------------

# --------------------Other Functions--------------------
	function startUtilities {
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
	}

	function stopUtilities {
		echo "Stop added utilities."
		# Backup
		docker exec utilities_db /usr/bin/mysqldump -u devenv --password=devenv kimai > data/kimai-backup.sql
		docker-compose -f scripts/dev-environment/docker-compose.yml down
	}

	function startSass {
		echo "Running SASS Watchers"
		runInBackground 'sass --watch wordpress/wp-content/themes/fe-guys/sass:wordpress/wp-content/themes/fe-guys' 'wordpress-sass'
	}

	function stopSass {
		echo 'Stopping SASS Watchers'
		stopBackgroundProcess 'wordpress-sass'
	}

	function startSync {
		echo "Syncing files..."
		runInBackground 'docker-osx-dev' 'docker-osx-dev'
	}

	function stopSync {
		echo 'Stopping Files Sync...'
		stopBackgroundProcess 'docker-osx-dev'
	}
# --------------------END Other Functions--------------------


# --------------------START Dev Environment--------------------
if [ $operation = "start" ]; then
	# Start machine only if it's not running
	MACHINE_STATUS=$(docker-machine status dev-machine)
	if [ "$MACHINE_STATUS" = "Stopped" ]; then
		echo "Starting machine..."
		docker-machine start dev-machine
	fi
	
	setupEnv

	startUtilities

	echo "Starting App..."
	#startSync
	sh scripts/app.sh start
	startSass
fi
# --------------------------------------------------------------


# --------------------STOP Dev Environment--------------------
if [ $operation = "stop" ]; then
	setupEnv
	stopSass
	stopSync

	echo "Gracefully stop apps container and backup databases."
	sh scripts/app.sh stop

	stopUtilities

	dockerCleanup

	echo "Stop machine."
	docker-machine stop dev-machine;
	echo "${red}The Dev-Machine and all its apps have been stopped and removed.${end}"
fi
# ------------------------------------------------------------


if [ $operation = "sync-start" ]; then
	startSync
fi

if [ $operation = "sync-stop" ]; then
	stopSync
fi

if [ $operation = "sass-start" ]; then
	startSass
fi

if [ $operation = "sass-stop" ]; then
	stopSass
fi




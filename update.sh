#!/bin/bash

# PATH TO PROJECTS for mac
manager_folder="/Users/sj/Projects/vue/semantechs/SEP3_adminPanel"
api_folder="/Applications/XAMPP/xamppfiles/htdocs/tracking"
client_folder="C:/Users/Taha/Desktop/Semantechs/LMS/Code/lmsOfficials_frontend"

# for windows
# manager_folder="C:/Users/Taha/Desktop/Semantechs/LMS/Code/admin"
# api_folder="C:/Users/Taha/Desktop/Semantechs/LMS/Code/backend"
# client_folder="C:/Users/Taha/Desktop/Semantechs/LMS/Code/lmsOfficials_frontend"


#MAIN SERVER
host="67.223.118.27"
username="pcllines786"
port="21"

# folder where projects are located on the server. Path without trailing slash
upload_to_folder="/home/rentbwir/digitack.rentxs.com"


# __START

# default server is main
server_user=$username
server_ip=$host
server_port=$port

project=$1

# check for options
i=1
for arg in "$@"
do
	case "$arg" in
	-s)
		server_user=$secondary_user
		server_ip=$secondary_ip
		echo "Updating secondary server: $server_ip"
	;;
	-p)
		i=$((i+1))
		path="${!i}"
		[ -z $path ] || upload_to_folder="$path"
	;;
	esac
	i=$((i+1))
done

build_zip="${project}_build.zip"

# ADMIN
if [ "$project" = "admin" ] ; then
	echo "<-- BUILDING $project -->"
	dist_folder="dist"

	cd $manager_folder
	output="$(npm run staging)"
	["$output" != *"DONE  Build complete."* ] && echo "<-- ERROR WITH BUILD -->" && exit 1

# BACKEND
elif [ "$project" = "backend" ] ; then
	dist_folder="."

	cd $api_folder;
	exclude_files=".env storage public"

# CLIENT
elif [ "$project" = "client" ] ; then
	echo "<-- BUILDING $project -->"
	dist_folder="dist"

	cd $client_folder
	output="$(npm run staging)"
	["$output" != *"DONE  Build complete."* ] && echo "<-- ERROR WITH BUILD -->" && exit 1

else
	echo "USAGE: ./update.sh backend|admin|upload [-p PATH_TO_UPLOAD_TO] [-s]"
	exit 2
fi

echo "<-- SUCCESSFUL BUILD $(date +'%H:%M') -->"

# ZIP
cd $dist_folder
[ -e $build_zip ] && rm -rf $build_zip
files=$(ls)
#remove excluded files
for file in $exclude_files
do
	files=$( echo $files | sed "s/\<$file\>//g" )
done
zip -r $build_zip $files 1> /dev/null &&
echo "<-- SUCCESSFUL ZIP $(date +'%H:%M') -->" || { echo "<-- ERROR WITH ZIP-->" && exit 3 ; }

# SCP

scp -P "$server_port" $build_zip "$server_user"@"$server_ip":$upload_to_folder/$project &&
echo "<-- SUCCESSFUL SCP $(date +'%H:%M') -->" || { echo "<-- ERROR WITH SCP-->" && exit 4; }

ssh -p "$server_port" "$server_user"@"$server_ip" "cd $upload_to_folder/$project ; rm -rf $files ; unzip -o $build_zip ; chmod -R +777 ." 1> /dev/null  &&
{
	echo "<-- SUCCESSFUL UPDATE $project $(date +'%H:%M') -->" || echo "<-- ERROR WITH BUILD $(date +'%H:%M') -->"
}

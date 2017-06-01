infectedFilesCount=$( clamscan --infected --remove --recursive quarantine/$1 | grep "Infected files: " | grep -oE "(\S)+$");
rm -rf quarantine/$1;
echo "$infectedFilesCount"
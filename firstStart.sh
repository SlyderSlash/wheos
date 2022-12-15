if [ -f firstStart.txt ]
then
rm firstStart.txt &&
sleep 2 &&
symfony console d:d:c &&
symfony console --no-interaction d:m:m
echo 'READY TO ROCK'
else
echo 'ALMOST READY TO ROCK'
fi

## About Project

Laravel Vue JS chat system private chat 
with real time

Demo https://youtu.be/ydbYk9SGO7k

This Repo made for UPWORK clone project so don't confuse from tables and columns names as lancer_id and owner_id 
as it expected to be owner of project and free lancer that do the project.
.
.
How it works ?
firstly create users 
make room and put the 2 ID of 2 users in room lancer_id and owner_id
then navigate domain.com/room/ROOM_ID
only Auth users thats Their IDs in room can navigate and listen to the events and receive messages 

## Install Project
Don't forget to npm install 
run websocket : php artisan websocket:serve
make sure it is running on port 6001

migrate tables then create users then create room for them from phpmyadmin


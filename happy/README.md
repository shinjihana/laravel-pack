#Forum

1. Thread
2. Reply
3. User

A. Thread is created by a user
B. A reply belongs to a thread, and belongs to a user

step 1 : create table
php artisan make:model Thread -mr
php artisan make:model Reply -mc

step 2 : php artisan migrate
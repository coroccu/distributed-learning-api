# distributed-learning-api
1. docker-compose up -d
2. docker exec -it ci bash

# in ci container
3. cd /var/www/html/
4. composer install
5. php vendor/kenjis/ci-phpunit-test/install.php

# database
6. Create distributed_learning database using phpadmin or other apps.
7. Create cards table with id(auto increment), question(varchar 255), answer(varchar 255) and category(varchar 255) in the database.  

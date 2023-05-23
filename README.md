# lexsynergytest-app
## Inorder to run please clone the app
## Once the code base is cloned run : composer install
 - This will install all your dependency
## Database is run on docker container, please run : docker compose up -d 
## Run 
  - symfony console make:migration
  - symfony console doctrine:migrations:migrate
  - symfony console doctrine:fixture:load
 
# Note : the controller was created to check if the data is as expected and you can use it to run the service and check and verify the data
# I have wrote the phpunit test so only 2 out of 4 runs need some more time to make it run completely.

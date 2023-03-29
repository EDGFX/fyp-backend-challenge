## Getting Started

Video Walkthrough: https://sendspark.com/share/ifdtb85nss2fbpwi2lyoydsufzhjrb18

1) .env file - 

Since the .env file I used for my project is protected and not uploaded to GitHub for security reasons, this is our first step. Thankfully we're provided with an .env.example file to use as a template. DB_DATABASE should be set to "products", and the DB_USERNAME is "root."

2) Creating local MySQL DB -

Now that the .env file is in place, we need to create a local MySQL database. I did this via Terminal, using "mysql -u root" to login as the root user, and running "CREATE DATABASE products;" to create the database that will house the incoming data from our .csv file. Then I ran "SHOW DATABASES;" to ensure that the database was created.

3) Running the app -

Pretty straightforward, "php artisan serve" in Terminal to get the application booted up into localhost.

4) Running the create_products_table migration -

One of my favorite things about Laravel is the ability to model tables for a database via migrations. All we need to do is run "php artisan migrate" so that our table structure gets appended to the MySQL database. Now we're ready to receive the data.

5) Running the ProductSeeder -

I utilized a seed class to pull the data from the .csv and add it to the database. In order to run this, we just need to execute "php artisan db:seed --class=ProductSeeder" in Terminal. This will import all of the data out of the .csv and into our products table. Refreshing the localhost page in our browser should now show all of the categories and products that were added on the front-end!


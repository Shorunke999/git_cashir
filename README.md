##About the project
Its a payment platform which both users and admin can make payment using paystack and Monny by monnniepoint.
Admin can change the or switch the Available payment platform and also make Payment.

The seeded data are
email - 
admin: admin@gmail.com 
user: shorunke99@gmail.com

password : 12345678


## Clone Repository
Clone the repository using the following command:
git clone https://github.com/username/repository-name.git


#Generate App_key for the project with setting up .env file
Copy the .env.example file, create a new file name .env and paste the copied file into the new .env file
Generate App_key using the following command:
php artisan key:generate.

Seed data:
php artisan db:seed


#Setting up some important .env variable.
Set 
DB_CONNECTION=mysql
PAYSTACK_PUBLIC_KEY= XXXXX
PAYSTACK_SECRET_KEY=XXXXX
PAYSTACK_PAYMENT_URL=XXXX

MONNY_PUBLIC_KEY=XXXX
MONNY_SECRET_KEY=XXXX
MONNY_BASE_URL=XXXXX
MONNY_CONTRACT_CODE ="XXXX" ...important

App_site =XXXX

##IMPORTANT NOTE
This project uses payment platform Paystack and Monny by Monniepoint..
The public and secret key for each payment platform should be gotten from their respectively platform 
https://monnify.com/ and https://dashboard.paystack.com/

* During development, for the payment platform to be able to send event and redirect back to the platform 
*after successfull payment..It is advise to connect the local host server to NGROK.
* Copy and Paste the VIRTUAL URL from Ngok to App_site in .env file


#Webhook Urls
In the payment system Dashboard, the webhook url must be Configured..
Paystack - virtual url/payment/webhook
Monny - virtual url//Monny/webhook
and save changes.


#Start server
php artisan serve   //Start server
npm run dev         //To start vite
Assumming npm is installed

##About the project
This project uses laravel starter kit (laravel breeze - blade) and Tailwind css
Its a payment platform which both users and admin can make payment using paystack and Monny by monnniepoint.
Admin can change the or switch the Available payment platform and also make Payment.

The seeded data are
email - 
admin: admin@gmail.com 
user: shorunke99@gmail.com

password : 12345678
to seed those data
```bash
php artisan db:seed
```


## Clone Repository
Clone the repository using the following command:
```bash
git clone https://github.com/Shorunke999/git_cashir.git
```



#Generate App_key for the project with setting up .env file
Copy the .env.example file, create a new file name .env and paste the copied file into the new .env file
Generate App_key using the following command:
```bash
php artisan key:generate.
```




#Setting up some important .env variable.
Set 
```bash
DB_CONNECTION=mysql
PAYSTACK_PUBLIC_KEY=XXXXX
PAYSTACK_SECRET_KEY=XXXXX
PAYSTACK_PAYMENT_URL=XXXX

MONNY_PUBLIC_KEY=XXXX
MONNY_SECRET_KEY=XXXX
MONNY_BASE_URL=XXXXX
MONNY_CONTRACT_CODE="XXXX" ...important

App_site=XXXX
```


##IMPORTANT NOTE
This project uses payment platform Paystack and Monny by Monniepoint..
The public and secret key for each payment platform should be gotten from their respectively platform 
https://monnify.com/ and https://dashboard.paystack.com/

* During development, for the payment platform to be able to send event and redirect back to the platform 
*after successfull payment..It is advise to connect the local host server to NGROK.
* Copy and Paste the VIRTUAL URL from Ngok to App_site in .env file


#Webhook Urls
In the payment system Dashboard, the webhook url must be Configured..
```bash
Paystack - virtual url/payment/webhook
Monny - virtual url//Monny/webhook
```
and save changes.


#Start server
```bash
php artisan serve   //Start server
php artisan queue:work   //start job to record payments data from webhook
npm run dev         //To start vite
Assumming npm is installed
```


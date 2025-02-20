<?php
require __DIR__ . "./vendor/autoload.php";
use telesign\sdk\phoneid\PhoneIdClient;

# Replace the defaults below with your Telesign authentication credentials or pull them from environment variables.
$customer_id = getenv('CUSTOMER_ID') ?? 'FFFFFFFF-EEEE-DDDD-1234-AB1234567890';
$api_key = getenv('API_KEY') ?? 'ABC12345yusumoN6BYsBVkh+yRJ5czgsnCehZaOYldPJdmFh6NeX8kunZ2zU1YWaUw/0wV6xfw==';

# Set the default below to your test phone number or pull it from an environment variable. 
# In your production code, update the phone number dynamically for each transaction.
$phone_number = getenv('PHONE_NUMBER') ?? '11234567890';

# Instantiate a Phone ID client object.
$pid = new PhoneIdClient($customer_id, $api_key);

# Make the request and capture the response.
$response = $pid->phoneid($phone_number);

# Display the response body in the console for debugging purposes. 
# In your production code, you would likely remove this.
var_dump($response->json);
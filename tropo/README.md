## Deploying your Tropo application

Create a new Tropo scripting application and use the "sms-vote.php" file as the contents of the new hosted file for the application.

Modify the CouchDB settings in the file to point to your instance of CouchDB.

Provision a telephone number for your app in order to receive SMS and phone calls.  Optionally provision user accounts for other channels (e.g., IM).

When your app is saved and propogated, sending an SMS message to your app should cause your Tropo app to insert a new document in your CouchDB instance.  

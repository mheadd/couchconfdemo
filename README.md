## CouchConf NYC Demo

This is a simple [Tropo](http://www.tropo.com/) + [CouchBase](http://www.couchbase.com/) app I demoed at [CouchConf NYC](http://www.couchbase.com/couchconf-nyc).  It's a realtime SMS voting app that was used to select the best rock song over 6 minutes in length, but it can be used as the basis for any kind of voting app you want to build.

The magic is in Tropo's ability to make HTTP requests from inside a running telephony application to a CouchDB instance running on your local machine, your server, in the cloud - anywhere!

Tropo + CouchBase == Cloud Telephony Awesomeness!

## Document Structure

To add items which can be voted on, simply insert a document with the following structure.

    {
       "_id": "2",
       "type": "selection",
       "group": "White Stripes",
       "song": "Ball & Biscuit"
    }

This structure will feed the "selections" view and render selections in HTML for voters to view and vote for. The "_id" property used is the vote selection users will send through their Tropo app, so you'll want to PUT this document into the database with a specific doc id.

In addition, you can set a phone number for display by inserting a document with this structure.

    {
       "number": "(407) 555-0000"
    } 

The doc id for this document is not important, so you can POST this document to your database and let CouchDB assign one.

## What is a CouchApp?

CouchApps are web applications which can be served directly from [CouchDB](http://couchdb.apache.org). This gives them the nice property of replicating just like any other data stored in CouchDB. They are also simple to write as they can use the built-in jQuery libraries and plugins that ship with CouchDB.

[More info about CouchApps here.](http://couchapp.org)

## Deploying this app

Assuming you just cloned this app from git, and you have changed into the app directory in your terminal, you want to push it to your CouchDB with the CouchApp command line tool, like this:

    couchapp push . http://name:password@hostname:5984/mydatabase

If you don't have a password on your CouchDB (admin party) you can do it like this (but it's a bad, idea, set a password):

    couchapp push . http://hostname:5984/mydatabase

If you get sick of typing the URL, you should setup a `.couchapprc` file in the root of your directory. Remember not to check this into version control as it will have passwords in it.

The `.couchapprc` file should have contents like this:

    {
      "env" : {
        "public" : {
          "db" : "http://name:pass@mycouch.couchone.com/mydatabase"
        },
        "default" : {
          "db" : "http://name:pass@localhost:5984/mydatabase"
        }
      }
    }

Now that you have the `.couchapprc` file set up, you can push your app to the CouchDB as simply as:

    couchapp push

This pushes to the `default` as specified. To push to the `public` you'd run:

    couchapp push public

Of course you can continue to add more deployment targets as you see fit, and give them whatever names you like.

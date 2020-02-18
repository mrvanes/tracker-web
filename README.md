# Tracker Webserver

A Zero-conf Location Tracker.

This is the Webserver that serves vehicle locations for the Android app on https://github.com/mrvanes/tracker

## Design philosophy

Tracker app and the companion webserver tracker-web were designed to facilitate a zero-conf location tracking service. This means that all device configuration is done in the webserver, which means it's a bit trickier to add and track new tracker phones to the server, but a breeze do deploy a new tracker device.

The app and server were originally developed for a Dutch company and have never been properly translated.

At the time of writing the code, there was not much harm in using unsalted md5 password hashes. I am aware this is currently frowned upon.

## Installation

There is no installaton wizard and all configuraton is manual. There needs to be a mysql database with user/pwd. The tables should be generated using ```install/create_db.sql```.

Default admin user is admin with password admin, please change as soon as the webserver is up and running.

The file ```lib/config.php``` contains all configuration and can be created by copying ```lib/config.php.sample```. Use the correct ```post_salt``` from the Android App to accept incoming location updates from the app.

## Configuration

Since the app is Zero-conf, all configuration is done in the webserver.

As soon as the app is launched it will try to get high-accuracy location (it needs location permissions to do this). As soon as the location is known and a network connection is availabel, the app will send status/location updates to the webserver location endpoint (post.php).

After the first update, there will be a device-id location update available in the database and the device-id can be assigned to a vehicle (mixer).

But first start by creating a "Centrale" (Hub) in the Admin page. Then add a new user, which i should be assigned to a hub. Optionally give this user admin or viewall rights. Admins can create new users, viewall see all vehicles independent of the hub the user is connected to.

Users are meant to operate the tracker webserver, phones are connected to mixers (vehicles) which are connected to a Hub. The operator only sees the vehicles that are connected to the same hub as the user and the mixers are connected to (unless the user has viewall rights).

After adding a Mixer, the mixer can then be assigned to any unassigned device-id that is found in the location updates database.

The Home page will now show a map and an icon showing the tracked vehicle.

## Uitlenen

This feature can (temporarily) move vehicles between hubs. They will show up on the (temporarily) assigned hub as long as the loan is effictive.

## Statuses

The app and server were developed for a Dutch company and contain 5 possible vehicle statuses:

  * Heen (going towards the site)
  * Wachten (wait, on site)
  * Lossen (deliver, on site)
  * Terug (return, to the hub)
  * Pauze (break, at hub)

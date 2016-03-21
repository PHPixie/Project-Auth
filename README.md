# Auth Project

This is a PHPixie project with some advanced user authentication already setup.
It serves as a faster starting point making rolling out your own authorization easier.

![Project Demo](http://i.imgur.com/WznceCf.gif)

There are two separate authentication domains: users and admins, stored in different
tables and entirely separated. This means you can login as a user and an admin at the same time.
In fact admins can impersonate any user with a press of the button on their dashboard.

To run, first install the project:

```
composer create-project phpixie/project-auth project
```

Then point your web server to the `web/` folder. That's it, now just visit the site and you'll
be greeted with a login/signup page. To try out the admin flow visit `/admin/` and login as `phpixie`
with password `framework`. You can also add your own admins by calling the `addAdmin.php` script
from console:

```
php addAdmin.php someUser somePassword
```


The project uses an SQLite database contained in `database.sqlite`. To recreate the same database in MySQL:

```
CREATE TABLE `users` (
    `id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE ,
    `passwordHash` VARCHAR(255) NOT NULL
);

CREATE TABLE `userTokens` (
  `series` varchar(50) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `challenge` varchar(50) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`series`)
);

CREATE TABLE `admins` (
    `id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE ,
    `passwordHash` VARCHAR(255) NOT NULL
);
```

Remember to modify the `assets/config/database.php` file with the new settings.


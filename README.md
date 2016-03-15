# Auth Project

This is a PHPixie project with some user authentication already setup.
It serves as a faster starting point making rolling out your own authorization easier.

To run, first install the project:

```
composer create-project phpixie/project-auth project
```

Then point your web server to the `web/` folder. That's it.

The project uses an SQLite database contained in `database.sqlite`. To recreate the same database in MySQL:

```
CREATE TABLE `users` (
    `id` INTEGER AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE ,
    `passwordHash` VARCHAR(255) NOT NULL
);

CREATE TABLE `tokens` (
  `series` varchar(50) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `challenge` varchar(50) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`series`)
);
```

Remember to modify the `assets/config/database.php` file with the new settings.


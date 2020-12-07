# Tema de acasa lul
Unecessary complex, but I'd like to try something new, so whatever

### API Stack:
___
- PHP 7.4
- MySQL 5.8
- Slim Framework
- Doctrine ORM

To define the configuration variables such as database credentials, please copy the contents of .env.example into .env and replace the values according to your system.

To run the dev project, please have nodemon installed:
```bash
npm i -g nodemon
```

And then run:
```bash
./dev_server.sh
```

To define the database schema, please run:
```bash
./db_update.sh
```

It will create / update the db structure for better usage.

### Front end stack
___
Same philosophy as above, complex but fun. Instead of rendering the pages from the application routes, I've created a separate front end based on Next.js which renders the content on the server. It enables quick content delivery wihtout any stutter or jitter, but requires more processing power because of the increased number of dependencies and processes running.

The instructions will lead below once I do something. Hang on ;)
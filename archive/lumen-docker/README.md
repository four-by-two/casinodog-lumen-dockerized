## Base Lumen API Features

- 2FA
- ACL
- Anti Phishing Code on email
- Audit
- CORS
- Device authorization
- Etag
- Horizon
- Laravel [8.x](https://github.com/ibrunotome/laravel-api-templates/tree/v8.x), [7.x](https://github.com/ibrunotome/laravel-api-templates/tree/v7.x), [6.x](https://github.com/ibrunotome/laravel-api-templates/tree/v6.x), [5.8](https://github.com/ibrunotome/laravel-api-templates/tree/v5.8)
- Login
- Login history
- Multiple localizations, preconfigured with en_US and pt_BR
- Password reset
- Password must not be in one of the 4 million weak passwords
- PHPCS PSR2, phpinsights and sonarqube analysis
- Register
- Swoole
- Tests
- Transactional events: Listen to events and send notifications only if the transaction is commited
- uuid

## Casino Side
Refactoring and cleaning up for API only casino games.


## Up and running

### Environment: develop
The oficial php image from Google Cloud Platform is updated once in a lifetime so I decided to manage my own php images at http://github.com/ibrunotome/php

- Set the .env variables, see .env.example that is already configured to point to pgsql and redis services
- Run the container with `docker-compose -f docker-compose.develop.yml up`.
  Alternatively, if you have an older laptop, try running remotely with
  [Blimp](https://kelda.io/blimp).
- Enter into app container with `docker exec -it default-structure-app bash`
- Run the migrations with `php artisan migrate:fresh`
- Run `php artisan db:seed` to set default keys
- Run `php artisan key:generate` to generate secret hash
- Run `php artisan jwt:secret` to set JWT auth secret
- Run `php artisan casinodog:restore-default-gameslist {provider_name} upsert` to import games for specific provider
- Run `php artisan casinodog:generate-salt` to generate random salt used in callback/casino session signing

Check config/casinodog.php for more settings, make sure to set .env properly.

And it's up and running :)

### Environment: testing

The container with xdebug is in the `Dockerfile.testing`, you can get into this container using: `docker-compose -f docker-compose.testing.yml up -d app` and then:

- Get into app container with `docker exec -it default-structure-app-testing bash` (off course, default-structure-app is for the default-structure) 
- Run tests with `composer test`
- Run "lint" (phpcs) with `composer lint`
- Run "lint and fix" (phpcbf) with `composer lint:fix`
- Run phpcpd with `composer phpcpd`
- Run php static analysis (level 5) with `composer static:analysis`
- Run nunomaduro/phpinsights with `php artisan insights`

To see sonarqube analysis, simple run `docker-compose -f docker-compose.sonarqube.yml up`, the quality profile used is PSR-2.

### Environment: production

See the contents of the `.k8s` folder :)

## Email layout

<img width="100%" alt="screenshot 2019-02-07 08 26 51" src="https://user-images.githubusercontent.com/4256471/52482466-72a5c280-2b98-11e9-9da6-35dbb791e157.png">

## Database structure

<img width="100%" alt="Screen Shot 2019-05-26 at 17 55 32" src="https://user-images.githubusercontent.com/4256471/88346965-02551780-cd20-11ea-8b35-3d4f8568ad74.png">

## Routes

<img width="100%" alt="Screen Shot 2019-05-26 at 17 56 41" src="https://user-images.githubusercontent.com/4256471/88347112-56f89280-cd20-11ea-867e-b8b11d0ee256.png">

## ZMACZOWANI!

Blog Paweł & Sandra

## PreRequisites
1. Docker
2. docker-compose-plugin

## Instalation

1. Copy `.env` and create new `env.local` file
2. Set `your_absolute_project_dir` and other variables in `env.local`
3. In project folder run `make build`
4. Next run `make up`
5. Run `make php` then `composer install`
6. Run `make php` then `php bin/console lexik:jwt:generate-keypair`
7. Run `make node` then `npm install`
8. Run `make setup`

```
Admin dev pass
zmaczowani@zmaczowani.dev
Tamto123!
```

## Tests usage

```php
# Run phpunit without coverage.
make phpunit

# Run phpunit with coverage.
make phpunit-coverage

# Run infection that show mutants.
make infection

# Run api tests.
make api-tests

# Run functional tests.
make functional-tests
```

```php
All commands run in docker `/api` folder

#Run the class tests
`vendor/bin/phpunit {{path_to_tests}}`
e.g. 'vendor/bin/phpunit ./tests/unit/Application/Command/Test/CreateTestTest.php'

#Run one unit test of class
`vendor/bin/phpunit --filter {{testName}} {{path_to_tests}}`
e.g. 'vendor/bin/phpunit --filter testShouldCreateValidObject ./tests/unit/Application/Command/Test/CreateTestTest.php'

#Run one api test of class
`vendor/bin/codecept run {{path_to_api_tests}}:{{testName}}`
e.g. 'vendor/bin/codecept run tests/codeception/api/Test/TestControllerCest.php:testShouldReturnJsonWithOneTestObject'

#Run one functional test of class 
`vendor/bin/codecept run {{path_to_functional_tests}}:{{testName}}`
e.g. 'vendor/bin/codecept run tests/codeception/functional/Infrastructure/Database/Test/Reader/TestFullDataMongoReaderCest.php:testShouldCreateNewTestRecord'

#Make infection of one file
`vendor/bin/infection --filter={{path_to_class}}`
e.g. 'vendor/bin/infection --filter=src/Application/Command/Test/CreateTestTest.php'
```

## Tests results
```php
#Coverage result
Run in browser 'app/tests/unit/.coverage/index.html'.

#Infection result
Check in 'app/tests/unit/.logs/infection'.
```











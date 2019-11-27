# Weather prediction

## Run using docker-compose
The following command will run the app on port 8080
```sh
docker-compose up -d --build
```
To stop the app just run
```sh
docker-compose down
```

> You will find a Postman collection under `postman/` directory contains the `Get weather endpoint` and example.

## Local ENV Installion
#### Install
```sh
cd {project_dir}
composer install
```
#### Run the application
```sh
php artisan serve --port=8080
```

## Thinking

We have one big domain `Weather` but the `Weather` domain contains multiple domains one of them `Temperature` domain.

### Directory structure
    .
    ├── ...
    ├── domain
    │   ├── Temperature
    |   |   |── Convertor         # Contains temperature scales convertors.
    |   |   |── Scale             # Contains temperature scales.
    │   ├── Weather
    |   |   |── Entities          # Contains DTO (Data Transfer Object).
    |   |   |── Services          # Contains domain services.
    |   |   |── Validators        # Contains domain validators.
    ├── infrastructure
    │   ├── Communicator          # Any call to 3rd party or external system (just send request and recieve response).
    │   ├── HTTPHandler           # Wrapper over http client library so we can change the library easily in the future.
    └── ...

### Add new scales or 3rd party partners

#### Add temperature scale
This will require the creation of the following files
- `domain/Temperature/Scale/{NEW_TEMPERATURE_SCALE_NAME}Scale.php` should extends `BaseTemperatureScale`
- The following steps should be repeated for each one from the older temperature scales
    - `domain/Temperature/Convertor/{NEW_TEMPERATURE_SCALE_NAME}To{OLD_TEMPERATURE_SCALE_NAME}.php` should implements `TemperatureConvertorInterface`
    - `domain/Temperature/Convertor/{OLD_TEMPERATURE_SCALE_NAME}To{NEW_TEMPERATURE_SCALE_NAME}.php` should implements `TemperatureConvertorInterface`

#### Add temperature partner
This will require the creation of the following files
- `/infrastructure/Communicator/{NEW_PARTNER}Communicator.php`
- `/domain/Weather/Services/Partners/{NEW_PARTNER}Service.php` should implements `PartnerServiceInterface`
- To make it recognized from our app you will require to add the service class in `config/temperature-partners` to `supported-partners` array
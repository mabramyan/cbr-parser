## cbr.ru parse rates
The project was tested on MacOs (13.4.1)  and Ubuntu (22.04)

This project using RabbitMq for Queues and Redis for caching


## Requirements

1. composer
2. docker
3. docker-compose

## instalation

```
git clone git@github.com:mabramyan/cbr-parser.git
```


```
cd cbr-parser
```

```
cp ./.env.example ./.env
```

```
composer install
```




## Build conteiners

```
./vendor/bin/sail up -d
```

#### Install migration

```
./vendor/bin/sail artisan migrate
```





### Usage


First of to run the project correctly you need to run queue worker. To do this run command in new terminal

```
./vendor/bin/sail artisan queue:work
```
you can run as much workers as you want each in new terminal


#### Get data for 180 days

```
./vendor/bin/sail artisan app:parse-rates
```

#### Get rate
```
./vendor/bin/sail artisan  app:rate <currency> <base_currency=RUR>
```
examples

```
./vendor/bin/sail artisan  app:rate USD 
./vendor/bin/sail artisan  app:rate RUR USD
```
the outpu is in json format
```
{
    "currency":"USD",
    "baseCurrency":"RUR",
    "nominal":1,"rate":91.2,
    "difference":0.51
}
```

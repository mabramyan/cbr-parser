

```
git clone repository
```


```
cd repository
```

```
composer install
```

```
composer install
```


```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

```
./vendor/bin/sail up -d
```

#### Install migration

```
./vendor/bin/sail artisan migrate
```


#### Get data for 180 days

```
./vendor/bin/sail artisan app:parse-rates
```




#### Get rate
```
./vendor/bin/sail artisan artisan app:rate --currency --base_currency
```

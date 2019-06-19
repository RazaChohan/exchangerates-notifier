# exchangerates-notifier

# Installation

####  1. First, clone this repository:

```bash
$ git clone https://github.com/RazaChohan/exchangerates-notifier.git
```

####  2. Next, kindly add following entry in your `/etc/hosts` file:

```bash
127.0.0.1 exchange_rates.localhost
```

- Create docker containers:

```bash
$ docker-compose up -d
```

#### 3. Confirm four running containers for php, nginx, mysql & rabbitmq:

```bash
$ docker-compose ps 
```

#### 4. Install composer packages:

```bash
$ docker-compose run php composer install 
```
#### 5. Create Database schema:

```bash
$ sudo docker-compose run php bin/console doctrine:schema:create 
```

#### 6. Confirm rabbitmq is working:

```bash
http://exchange_rates.localhost:15672
username: guest
password: guest
```
#### 7. Generate SSH keys for JWT tokens:
```bash
$ mkdir -p exchange_rates/config/jwt
```
        Note: Use Paraphrase: 82951f58f88ba0adfe73ca662b1140e4 in following steps when prompted
```bash
$ openssl genrsa -out exchange_rates/config/jwt/private.pem -aes256 4096 
$ openssl rsa -pubout -in exchange_rates/config/jwt/private.pem -out exchange_rates/config/jwt/public.pem
$ chmod -R 644 exchange_rates/config/jwt/* 
```

#### 8. Create/Register a new user for generting token:
```bash
curl -X POST -H "Content-Type: application/json" http://exchange_rates.localhost/api/register -d '{"username":"raza","password":"testing"}'
```

#### 9. Generate token using credentials provided in above step (user register):
```bash
$ curl -X POST -H "Content-Type: application/json" http://exchange_rates.localhost/api/login_check -d '{"username":"raza","password":"testing"}'
```

#### 10. Get currency exchange rates:
```bash
curl -X GET -H "Authorization: Bearer <ACCESS_TOKEN> http://exchange_rates.localhost/api/exchange-rates -d "base=EUR&date=2019-06-18"
```

#### 11.Get currency exchange rates using xmlrpc:
```bash
http://exchange_rates.localhost/xmlrpc
<methodCall>
    <methodName>getExchangeRateXmlRpc</methodName>
</methodCall>
```

For docker image I have used https://github.com/eko/docker-symfony repo and tweaked it a bit as per my requirements.


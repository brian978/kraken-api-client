# Kraken API client
Unofficial API client written in PHP for Kraken Exchange

### Documentation
- [Official REST API documentation](https://docs.kraken.com/rest/)
- [Official Websockets API documentation](https://docs.kraken.com/websockets/)

## Main features
* Compatible with any framework
* Compatible with any logger library that implements `Psr\Log\LoggerInterface`
* It provides an easy-to-use interface with the API using the *Query classes that are provided
* The API parameter documentation can be found in the PHPDoc of each query object for easy use

## Not supported (yet!)
* User trading endpoints
* User funding endpoints
* User staking endpoints


# How to contribute to the project
If we are talking about a new feature, then an issue needs to be opened in order to discuss it. And after that proceed 
to the steps below.

If it's a BUG see the steps below

## Steps to update the code
1. Write the code in a new branch (see [HERE](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow) for more info)
2. Make sure it's PSR-12 compliant and all the code and comments ar properly aligned
3. Make a PR


# Configuration examples
## Symfony

In your .env config file
```text
###> brian978/kraken-api-client ###
KRAKEN_API_KEY=<your_key>
KRAKEN_API_SECRET=<your_secret>==
###< brian978/kraken-api-client ###
```

In your services.yaml
```yaml
# KrakenApi namespace auto-wire
KrakenApi\:
  resource: '../vendor/brian978/kraken-api-client/src/'

# Kraken API client
app.krakenHttp.client:
  class: GuzzleHttp\Client
  arguments:
    - { base_uri: 'https://api.kraken.com' }

KrakenApi\Client:
  class: KrakenApi\Client
  arguments:
    $httpClient: '@app.krakenHttp.client'
    $apiKey: '%env(resolve:KRAKEN_API_KEY)%'
    $apiSecret: '%env(resolve:KRAKEN_API_SECRET)%'
  calls:
    - setLogger: [ '@logger' ]
```

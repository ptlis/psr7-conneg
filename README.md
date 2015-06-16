# PSR-7 ConNeg

A content negotiation middleware that uses the PSR-7 interfaces.

Configurable component that decorate processed requests with preferred type information. 

Built upon [ptlis/ConNeg](https://github.com/ptlis/conneg).

[![Build Status](https://travis-ci.org/ptlis/psr7-conneg.png?branch=master)](https://travis-ci.org/ptlis/psr7-conneg) [![Code Coverage](https://scrutinizer-ci.com/g/ptlis/psr7-conneg/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ptlis/psr7-conneg/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ptlis/psr7-conneg/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ptlis/psr7-conneg/?branch=master) [![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/ptlis/psr7-conneg/blob/master/licence.txt) [![Latest Stable Version](https://poser.pugx.org/ptlis/psr7-conneg/v/stable.png)](https://packagist.org/packages/ptlis/psr7-conneg)

## Install

Either from the console:

```shell
    $ composer require ptlis/psr7-conneg:~1.0
```

Or by Editing composer.json:

```javascript
    {
        "require": {
            ...
            "ptlis/conneg-psr7-conneg": "~1.0",
            ...
        }
    }
```

Followed by a composer update:

```shell
    $ composer update
```

## Usage

The package ships with a single class to provide negotiation. 

```php
    use ptlis\Psr7ConNeg\Negotiator;
    
    $negotiator = new Negotiator();
```

To opt-in to negotiation on a field use the appropriate ```with*``` method (note these methods return a new instance in the manner of the PSR-7 interfaces). 

To negotiate the preferred mime-type use the ```withMime``` method, providing it with a list of your application's type preference:

```
    $negotiator = $negotiator->withMime('application/json;q=1.0,text/xml;q=0.7');
```

With your negotiator configured you can now perform negotiation:

```
    $request = $negotiator->negotiate($request);
```

This adds attributes to the request containing the preferred type. These can be accessed with the appropriate getters, in the above example of negotiation on the Accept field this looks like:

```
    $mime = $newRequest->getAttribute(Negotiator::MIME_BEST);
```

If the Accept field of the request contained ```application/json,text/xml``` then the value returned from this lookup would be ```application/json```.


### With Zend-Stratigility

To use the zend-stratigility component configure your negotiator instance as described above and pass it to the Stratigility negotiator.
 
```
    $stratigilityNegotiator = new StratigilityNegotiator($negotiator);
```

To perform negotiation on all routes, add it with an empty route:

```
    $app->pipe('', $stratigilityNegotiator);
```

For further information please refer to the Stratigility documentation.


## Integration

* A [Zend-Stratigility](https://github.com/zendframework/zend-stratigility) middleware implementation is bundled.


## Contributing

You can contribute by submitting an Issue to the [issue tracker](https://github.com/ptlis/psr-7conneg/issues) or submitting a pull request.

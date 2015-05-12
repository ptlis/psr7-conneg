# PSR-7 ConNeg

A content negotiation middleware that uses the PSR-7 interfaces.

Based on [ptlis\ConNeg](https://github.com/ptlis/conneg).

## Install

Either from the console:

```shell
    $ composer require ptlis/psr7-conneg:~0.1
```

Or by Editing composer.json:

```javascript
    {
        "require": {
            ...
            "ptlis/conneg-psr7-conneg": "~0.1",
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

To opt-in to negotiation on a field use the appropriate ```with*``` method (note these methods return a new instance in manner of the PSR-7 interfaces). 

To negotiate the preferred mime-type use the ```withMime`` method, providing it with a list of your application's type preference:

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
 


## Contributing

You can contribute by submitting an Issue to the [issue tracker](https://github.com/ptlis/psr-7conneg/issues) or submitting a pull request.

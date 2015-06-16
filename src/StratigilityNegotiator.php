<?php

/**
 * PHP Version 5.3
 *
 * @copyright   (c) 2015 brian ridley
 * @author      brian ridley <ptlis@ptlis.net>
 * @license     http://opensource.org/licenses/MIT MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ptlis\Psr7ConNeg;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewarePipe;

/**
 * Content negotiation middleware targeting the Zend Stratigility interfaces
 */
class StratigilityNegotiator extends MiddlewarePipe
{
    /**
     * @var Negotiator
     */
    private $negotiator;


    /**
     * Constructor.
     *
     * @param Negotiator $negotiator The configured negotiator.
     */
    public function __construct(Negotiator $negotiator)
    {
        $this->negotiator = $negotiator;

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $modifiedRequest = $this->negotiator->negotiate($request);

        parent::__invoke($modifiedRequest, $response, $out);
    }
}

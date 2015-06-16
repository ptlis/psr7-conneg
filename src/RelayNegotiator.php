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

/**
 * Content negotiation middleware targeting Relay.
 */
class RelayNegotiator
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
    }

    /**
     * Performs negotiation and passes the now decorated request to the next middleware in the queue.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $newRequest = $this->negotiator->negotiate($request);

        return $next($newRequest, $response);
    }
}

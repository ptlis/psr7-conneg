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

namespace ptlis\Psr7ConNeg\Test;

use Psr\Http\Message\ServerRequestInterface;
use ptlis\Psr7ConNeg\Negotiator;
use ptlis\Psr7ConNeg\RelayNegotiator;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * Very simple test suite - all heavy lifting is done by ptlis\ConNeg which has it's own tests.
 */
class RelayNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testNegotiation()
    {
        $request = new ServerRequest();
        $request = $request->withHeader('AcceptCharset', 'utf-8;q=0.75,iso-8859-5');

        $applicationTypes = 'utf-8,iso-8859-5;q=0.5,iso-8859-1;q=0.2';

        $negotiator = new Negotiator();
        $negotiator = $negotiator->withCharset($applicationTypes);

        $relayNegotiator = new RelayNegotiator($negotiator);

        $relayNegotiator(
            $request,
            new Response(),
            function(ServerRequestInterface $newRequest) {
                $this->assertEquals(
                    'utf-8',
                    $newRequest->getAttribute(Negotiator::CHARSET_BEST)
                );
            }
        );
    }
}

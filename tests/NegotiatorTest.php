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

use Phly\Http\ServerRequest;
use ptlis\Psr7ConNeg\Negotiator;

/**
 * Very simple test suite - all heavy lifting is done by ptlis\ConNeg which has it's own tests.
 */
class NegotiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCharset()
    {
        $request = new ServerRequest();
        $request = $request->withHeader('AcceptCharset', 'utf-8;q=0.75,iso-8859-5');

        $applicationTypes = 'utf-8,iso-8859-5;q=0.5,iso-8859-1;q=0.2';

        $negotiator = new Negotiator();
        $negotiator = $negotiator->withCharset($applicationTypes);

        $newRequest = $negotiator->negotiate($request);

        $this->assertEquals(
            'utf-8',
            $newRequest->getAttribute(Negotiator::CHARSET_BEST)
        );
    }

    public function testEncoding()
    {
        $request = new ServerRequest();
        $request = $request->withHeader('AcceptEncoding', 'deflate,7zip;q=0.75');

        $applicationTypes = 'deflate;q=1,7zip;q=0.5';

        $negotiator = new Negotiator();
        $negotiator = $negotiator->withEncoding($applicationTypes);

        $newRequest = $negotiator->negotiate($request);

        $this->assertEquals(
            'deflate',
            $newRequest->getAttribute(Negotiator::ENCODING_BEST)
        );
    }

    public function testLanguage()
    {
        $request = new ServerRequest();
        $request = $request->withHeader('AcceptLanguage', 'en-gb;q=0.75,en-us,fr;q=0.3');

        $applicationTypes = 'en-us;q=0.5,en-gb';

        $negotiator = new Negotiator();
        $negotiator = $negotiator->withLanguage($applicationTypes);

        $newRequest = $negotiator->negotiate($request);

        $this->assertEquals(
            'en-gb',
            $newRequest->getAttribute(Negotiator::LANGUAGE_BEST)
        );
    }

    public function testMime()
    {
        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'text/html;q=0.9,application/xml;q=0.5,text/plain;q=0.1');

        $applicationTypes = 'text/plain;q=0.2,application/xml,text/html;q=0.5';

        $negotiator = new Negotiator();
        $negotiator = $negotiator->withMime($applicationTypes);

        $newRequest = $negotiator->negotiate($request);

        $this->assertEquals(
            'application/xml',
            $newRequest->getAttribute(Negotiator::MIME_BEST)
        );
    }
}

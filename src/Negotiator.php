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

use Psr\Http\Message\ServerRequestInterface;
use ptlis\ConNeg\Negotiate as BaseNegotiation;
use ptlis\ConNeg\Collection\TypeCollection;

/**
 * PSR-7 compliant negotiation. Adds attributes to incoming requests containing the preferred type data.
 */
class Negotiator
{
    /**
     * Name used to identify negotiated charset in the Request's attributes.
     */
    const CHARSET_BEST = 'negotiation-charset-best';

    /**
     * Name used to identify negotiated encoding in the Request's attributes.
     */
    const ENCODING_BEST = 'negotiation-encoding-best';

    /**
     * Name used to identify negotiated language in the Request's attributes.
     */
    const LANGUAGE_BEST = 'negotiation-language-best';

    /**
     * Name used to identify negotiated mime in the Request's attributes.
     */
    const MIME_BEST = 'negotiation-mime-best';

    /**
     * @var bool
     */
    private $charsetNeg = false;

    /**
     * @var string|TypeCollection
     */
    private $charsetAppTypes = '';

    /**
     * @var bool
     */
    private $encodingNeg = false;

    /**
     * @var string|TypeCollection
     */
    private $encodingAppTypes = '';

    /**
     * @var bool
     */
    private $languageNeg = false;

    /**
     * @var string|TypeCollection
     */
    private $languageAppTypes = '';

    /**
     * @var bool
     */
    private $mimeNeg = false;

    /**
     * @var string|TypeCollection
     */
    private $mimeAppTypes = '';

    /**
     * @var BaseNegotiation
     */
    private $negotiator;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->negotiator = new BaseNegotiation();
    }

    /**
     * Opt into charset negotiation, optionally specifying application preferences.
     *
     * @param string|TypeCollection $appTypes
     *
     * @return $this
     */
    public function withCharset($appTypes = '')
    {
        $clone = clone $this;

        $clone->charsetNeg = true;
        $clone->charsetAppTypes = $appTypes;

        return $clone;
    }

    /**
     * Opt into encoding negotiation, optionally specifying application preferences.
     *
     * @param string|TypeCollection $appTypes
     *
     * @return $this
     */
    public function withEncoding($appTypes = '')
    {
        $clone = clone $this;

        $clone->encodingNeg = true;
        $clone->encodingAppTypes = $appTypes;

        return $clone;
    }

    /**
     * Opt into language negotiation, optionally specifying application preferences.
     *
     * @param string|TypeCollection $appTypes
     *
     * @return $this
     */
    public function withLanguage($appTypes = '')
    {
        $clone = clone $this;

        $clone->languageNeg = true;
        $clone->languageAppTypes = $appTypes;

        return $clone;
    }

    /**
     * Opt into mime negotiation, optionally specifying application preferences.
     *
     * @param string|TypeCollection $appTypes
     *
     * @return $this
     */
    public function withMime($appTypes = '')
    {
        $clone = clone $this;

        $clone->mimeNeg = true;
        $clone->mimeAppTypes = $appTypes;

        return $clone;
    }

    /**
     * Perform negotiation on the provided request, return a request instance with attributes containing the preferred
     * types for each field handled.
     *
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    public function negotiate(ServerRequestInterface $request)
    {
        if ($this->charsetNeg) {
            $request = $request->withAttribute(
                self::CHARSET_BEST,
                $this->negotiator->charsetBest($request->getHeaderLine('Accept'), $this->charsetAppTypes)
                    ->getType()
            );
        }

        if ($this->encodingNeg) {
            $request = $request->withAttribute(
                self::ENCODING_BEST,
                $this->negotiator->encodingBest($request->getHeaderLine('Accept-Encoding'), $this->encodingAppTypes)
                    ->getType()
            );
        }

        if ($this->languageNeg) {
            $request = $request->withAttribute(
                self::LANGUAGE_BEST,
                $this->negotiator->languageBest($request->getHeaderLine('Accept-Language'), $this->languageAppTypes)
                    ->getType()
            );
        }

        if ($this->mimeNeg) {
            $request = $request->withAttribute(
                self::MIME_BEST,
                $this->negotiator->mimeBest($request->getHeaderLine('Accept'), $this->mimeAppTypes)
                    ->getType()
            );
        }

        return $request;
    }
}

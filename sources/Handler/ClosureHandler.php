<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) 2016 - Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Nia\Routing\Handler;

use Closure;
use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;

/**
 * Route handler using a closure.
 */
class ClosureHandler implements HandlerInterface
{

    /**
     * The closure to call.
     *
     * @var Closure
     */
    private $closure = null;

    /**
     * Constructor.
     *
     * @param Closure $closure
     *            The closure to call.
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Handler\HandlerInterface::handle($request, $context)
     */
    public function handle(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
    {
        $closure = $this->closure;

        return $closure($request, $context);
    }
}

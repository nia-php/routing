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
namespace Nia\Routing\Router\Exception;

use RuntimeException;

/**
 * Exception which will be thrown if no route matched for a request.
 */
class NoRouteMatchedException extends RuntimeException
{
}

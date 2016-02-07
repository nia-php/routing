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
namespace Nia\Routing\Filter\Exception;

use Exception;

/**
 * Exception which has to be throw if a request filter can be ignored.
 */
class IgnoreFilterException extends Exception
{
}

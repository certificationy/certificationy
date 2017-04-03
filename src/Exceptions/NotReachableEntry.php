<?php

namespace Certificationy\Exceptions;

/*
 * This file is part of the Certificationy library.
 *
 * (c) Vincent Composieux <vincent.composieux@gmail.com>
 * (c) Mickaël Andrieu <andrieu.travail@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class NotReachableEntry extends \Exception
{
    public static function create($key)
    {
        return new static("Element at position $key is not reachable.");
    }

}
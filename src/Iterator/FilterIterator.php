<?php

declare(strict_types=1);

namespace RusavskiyAV\RequestLogBundle\Iterator;

use RusavskiyAV\RequestLogBundle\Filter;

class FilterIterator extends \FilterIterator
{
    private Filter $filter;

    public function __construct(\Iterator $iterator, Filter $filter)
    {
        $this->filter = $filter;
        parent::__construct($iterator);
    }

    public function accept(): bool
    {
        return
            '' === $this->filter->getIp()
            || $this->getInnerIterator()->current()->getIp() === $this->filter->getIp();
    }
}

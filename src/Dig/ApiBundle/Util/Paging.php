<?php

namespace Dig\ApiBundle\Util;

class Paging
{
    /**
     * @var int
     */
    private $current;

    /**
     * @var int
     */
    private $next;

    /**
     * @var int
     */
    private $previous;

    /**
     * @var array
     */
    private $records;

    /**
     * @param int $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @param int $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

    /**
     * @param int $previous
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;
    }

    /**
     * @param array $records
     */
    public function setRecords($records)
    {
        $this->records = $records;
    }
}

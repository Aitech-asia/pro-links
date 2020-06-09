<?php

namespace ProCore\Pagination;

use ProCore\Pagination\PaginationBase;

class PaginationData extends PaginationBase
{
    // how many buttons we want to show ?
    private $range = 11;

    /**
     * Compute pagination and return array with paged buttons. The array output is array( page, selected, link )
     *
     * @return array array( array(page, selected, link ) )
     */
    public function __construct(array $argv)
    {
        $this->_page_count = $argv['page_count'];
        $this->_paged = $argv['paged'];
    }

    public function getPageIndex()
    {
        return $this->_paged;
    }
    public function getPageCount()
    {
        return $this->_page_count;
    }
    public function setPageCount($pagenum)
    {
        return $this->_page_count = $pagenum;
    }

    protected function _getItemLink($i)
    {
        return get_pagenum_link($i);
    }
}
<?php

namespace dlds\thepay\api\dataApi\parameters;

use dlds\thepay\api\dataApi\TpValueFormatter;

class TpDataApiPaginationResponse extends TpDataApiPagination
{

    /**
     * @var int|null
     */
    protected $totalPages;

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @param int|null $totalPages
     */
    public function setTotalPages($totalPages = null)
    {
        $this->totalPages = TpValueFormatter::format('int', $totalPages);
    }

}

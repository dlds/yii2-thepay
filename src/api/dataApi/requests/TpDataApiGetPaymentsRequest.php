<?php

namespace dlds\thepay\api\dataApi\requests;

use dlds\thepay\api\dataApi\parameters\TpDataApiGetPaymentsSearchParams;
use dlds\thepay\api\dataApi\parameters\TpDataApiOrdering;
use dlds\thepay\api\dataApi\parameters\TpDataApiPaginationRequest;
use dlds\thepay\api\dataApi\TpValueFormatter;

class TpDataApiGetPaymentsRequest extends TpDataApiRequest
{

    protected static $dateTimePaths = array(
        array('searchParams', 'createdOnFrom'),
        array('searchParams', 'createdOnTo'),
        array('searchParams', 'finishedOnFrom'),
        array('searchParams', 'finishedOnTo')
    );

    /**
     * @var TpDataApiGetPaymentsSearchParams|null
     */
    protected $searchParams;

    /**
     * @var TpDataApiPaginationRequest|null
     */
    protected $pagination;

    /**
     * @var TpDataApiOrdering|null
     */
    protected $ordering;

    /**
     * @return TpDataApiGetPaymentsSearchParams|null
     */
    public function getSearchParams()
    {
        return $this->searchParams;
    }

    /**
     * @param TpDataApiGetPaymentsSearchParams|null $searchParams
     */
    public function setSearchParams(TpDataApiGetPaymentsSearchParams $searchParams = null)
    {
        $this->searchParams = TpValueFormatter::format(
            'TpDataApiGetPaymentsSearchParams', $searchParams
        );
    }

    /**
     * @return TpDataApiPaginationRequest|null
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param TpDataApiPaginationRequest|null $pagination
     */
    public function setPagination(TpDataApiPaginationRequest $pagination = null)
    {
        $this->pagination = TpValueFormatter::format(
            'TpDataApiPaginationRequest', $pagination
        );
    }

    /**
     * @return TpDataApiOrdering|null
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param TpDataApiOrdering|null $ordering
     */
    public function setOrdering(TpDataApiOrdering $ordering = null)
    {
        $this->ordering = TpValueFormatter::format(
            'TpDataApiOrdering', $ordering
        );
    }

}

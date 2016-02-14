<?php

namespace dlds\thepay\api\dataApi\requests;

class TpDataApiGetPaymentsRequest extends TpDataApiRequest {

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
    public function setSearchParams(\dlds\thepay\api\dataApi\parameters\TpDataApiGetPaymentsSearchParams $searchParams = null)
    {
        $this->searchParams = \dlds\thepay\api\dataApi\TpValueFormatter::format(
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
    public function setPagination(\dlds\thepay\api\dataApi\parameters\TpDataApiPaginationRequest $pagination = null)
    {
        $this->pagination = \dlds\thepay\api\dataApi\TpValueFormatter::format(
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
    public function setOrdering(\dlds\thepay\api\dataApi\parameters\TpDataApiOrdering $ordering = null)
    {
        $this->ordering = \dlds\thepay\api\dataApi\TpValueFormatter::format(
                'TpDataApiOrdering', $ordering
        );
    }
}
<?php

namespace dlds\thepay\api\dataApi\parameters;

use dlds\thepay\api\dataApi\TpDataApiObject;
use dlds\thepay\api\dataApi\TpValueFormatter;

abstract class TpDataApiPagination extends TpDataApiObject {

	/**
	 * @var int|null
	 */
	protected $page;

	/**
	 * @var int|null
	 */
	protected $itemsOnPage;

	/**
	 * @return int|null
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * @param int|null $page
	 */
	public function setPage($page = null) {
		$this->page = TpValueFormatter::format('int', $page);
	}

	/**
	 * @return int|null
	 */
	public function getItemsOnPage() {
		return $this->itemsOnPage;
	}

	/**
	 * @param int|null $itemsOnPage
	 */
	public function setItemsOnPage($itemsOnPage = null) {
		$this->itemsOnPage = TpValueFormatter::format('int', $itemsOnPage);
	}

}

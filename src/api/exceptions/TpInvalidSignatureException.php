<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . "TpException.php";

/**
 * Exception thrown when payment signature validation failed.
 */
class TpInvalidSignatureException extends TpException {
	function __construct() {
		parent::__construct("Invalid signature");
	}
}

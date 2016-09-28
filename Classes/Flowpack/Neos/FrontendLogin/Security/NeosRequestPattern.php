<?php
namespace Flowpack\Neos\FrontendLogin\Security;

/*                                                                             *
 * This script belongs to the TYPO3 Flow package "Flowpack.Neos.FrontendLogin".*
 *                                                                             */

use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Mvc\RequestInterface;
use TYPO3\Flow\Security\RequestPatternInterface;

/**
 * A request pattern that can detect and match "frontend" and "backend" mode
 */
class NeosRequestPattern implements RequestPatternInterface {

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * Expects options in the form array('matchFrontend' => TRUE/FALSE)
	 *
	 * @param array $options
	 */
	public function __construct(array $options) {
		$this->options = $options;
	}

	/**
	 * Matches a \TYPO3\Flow\Mvc\RequestInterface against its set pattern rules
	 *
	 * @param RequestInterface $request The request that should be matched
	 * @return boolean TRUE if the pattern matched, FALSE otherwise
	 */
	public function matchRequest(RequestInterface $request) {
		if (!$request instanceof ActionRequest) {
			return FALSE;
		}
		$shouldMatchFrontend = isset($this->options['matchFrontend']) && $this->options['matchFrontend'] === true;
		$requestPath = $request->getHttpRequest()->getUri()->getPath();
		$requestPathMatchesBackend = substr($requestPath, 0, 5) === '/neos' || strpos($requestPath, '@') !== FALSE;
		return $shouldMatchFrontend !== $requestPathMatchesBackend;
	}

}
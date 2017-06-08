<?php
namespace Flowpack\Neos\FrontendLogin\Controller;

/*                                                                             *
 * This script belongs to the TYPO3 Flow package "Flowpack.Neos.FrontendLogin".*
 *                                                                             */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Error;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Security\Authentication\Controller\AbstractAuthenticationController;
use TYPO3\Flow\Security\Exception\AuthenticationRequiredException;

/**
 * Controller for displaying a login/logout form and authenticating/logging out "frontend users"
 */
class AuthenticationController extends AbstractAuthenticationController {

	/**
	 * @var \TYPO3\Flow\I18n\Translator
	 * @Flow\Inject
	 */
	protected $translator;

	/**
	 * @Flow\InjectConfiguration(package="Flowpack.Neos.FrontendLogin", path="translation.packageKey")
	 * @var string
	 */
	protected $translationPackageKey;

	/**
	 * @Flow\InjectConfiguration(package="Flowpack.Neos.FrontendLogin", path="translation.sourceName")
	 * @var string
	 */
	protected $translationSourceName;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('account', $this->securityContext->getAccount());
	}

	/**
	 * return void
	 */
	public function logoutAction() {
		parent::logoutAction();

		$uri = $this->request->getInternalArgument('__redirectAfterLogoutUri');

		if (empty($uri)) {
			$this->redirect('index');
		} else {
			$this->redirectToUri($uri);
		}
	}

	/**
	 * @param ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return string
	 */
	protected function onAuthenticationSuccess(ActionRequest $originalRequest = NULL) {
		$uri = $this->request->getInternalArgument('__redirectAfterLoginUri');

		if (empty($uri)) {
			$this->redirect('index');
		} else {
			$this->redirectToUri($uri);
		}
	}


	/**
	 * Create translated FlashMessage and add it to flashMessageContainer
	 *
	 * @param ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return string
	 */
	protected function onAuthenticationFailure(AuthenticationRequiredException $exception = null) {
		$title = $this->getTranslationById('authentication.failure.title');
		$message = $this->getTranslationById('authentication.failure.message');
		$this->flashMessageContainer->addMessage(new Error($message, ($exception === null ? 1496914553 : $exception->getCode()), array(), $title));
	}

	/**
	 * Get translation by label id for configured source name and package key
	 *
	 * @param string $labelId Key to use for finding translation
	 * @return string Translated message or NULL on failure
	 */
	protected function getTranslationById($labelId) {
		return $this->translator->translateById($labelId, array(), null, null, $this->translationSourceName, $this->translationPackageKey);
	}

	/**
	 * Disable the technical error flash message
	 *
	 * @return boolean
	 */
	protected function getErrorFlashMessage() {
		return FALSE;
	}
}
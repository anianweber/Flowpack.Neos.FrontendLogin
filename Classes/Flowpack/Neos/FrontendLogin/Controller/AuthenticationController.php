<?php
namespace Flowpack\Neos\FrontendLogin\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\ActionRequest;
use Neos\Flow\Security\Authentication\Controller\AbstractAuthenticationController;

/**
 * Controller for displaying a login/logout form and authenticating/logging out "frontend users"
 */
class AuthenticationController extends AbstractAuthenticationController {

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
	 * Disable the technical error flash message
	 *
	 * @return boolean
	 */
	protected function getErrorFlashMessage() {
		return FALSE;
	}
}
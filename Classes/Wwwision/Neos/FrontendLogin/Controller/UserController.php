<?php
namespace Wwwision\Neos\FrontendLogin\Controller;

/*                                                                             *
 * This script belongs to the TYPO3 Flow package "Wwwision.Neos.FrontendLogin".*
 *                                                                             */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Wwwision\Neos\FrontendLogin\Domain\Model\User;
use Wwwision\Neos\FrontendLogin\Domain\Service\UserService;

/**
 * Controller for displaying a simple user profile for frontend users
 */
class UserController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var UserService
	 */
	protected $userService;

	/**
	 * @return void
	 */
	public function showAction() {
		$this->view->assign('user', $this->userService->getCurrentUser());
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function updateAction(User $user) {
		$this->userService->updateUser($user);
		$this->addFlashMessage('Successfully updated user data', 'Success');

		$this->redirect('show');
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
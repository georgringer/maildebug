<?php

namespace GeorgRinger\Maildebug\Controller;

use TYPO3\CMS\Backend\View\BackendTemplateView;

class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * messageRepository
	 *
	 * @var \GeorgRinger\Maildebug\Domain\Repository\MessageRepository
	 */
	protected $messageRepository;

    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;
    /**
     * Backend Template Container
     *
     * @var BackendTemplateView
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$messages = $this->messageRepository->findAll();
		$this->view->assign('messages', $messages);
	}

	/**
	 * action show
	 *
	 * @param \GeorgRinger\Maildebug\Domain\Model\Message
	 * @return void
	 */
	public function showAction(\GeorgRinger\Maildebug\Domain\Model\Message $message) {
		$this->view->assign('message', $message);
	}

	/**
	 * injectMessageRepository
	 *
	 * @param \GeorgRinger\Maildebug\Domain\Repository\MessageRepository $messageRepository
	 * @return void
	 */
	public function injectMessageRepository(\GeorgRinger\Maildebug\Domain\Repository\MessageRepository $messageRepository) {
		$this->messageRepository = $messageRepository;
	}

}

?>

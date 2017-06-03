<?php

namespace GeorgRinger\Maildebug\Controller;

use TYPO3\CMS\Backend\View\BackendTemplateView;

class MessageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * messageRepository.
     *
     * @var \GeorgRinger\Maildebug\Domain\Repository\MessageRepository
     */
    protected $messageRepository;

    /**
     * BackendTemplateContainer.
     *
     * @var BackendTemplateView
     */
    protected $view;
    /**
     * Backend Template Container.
     *
     * @var BackendTemplateView
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * action list.
     *
     * @return void
     */
    public function listAction()
    {
        $messages = $this->messageRepository->findAll();
        $adressCollection = [
            'from' => [],
            'to' => [],
            'cc' => [],
            'bcc' => []
        ];

        
        foreach($messages as $message) {
            foreach($adressCollection as $key => $val){
                $methodNameGetField = 'get' . ucfirst($key);
                if(is_callable(array($message, $methodNameGetField))){
                    $adressArray = $this->extractEmail($message->$methodNameGetField());
                    foreach ($adressArray as $adress){
                        if(!is_null($adress) && !in_array($adress,$adressCollection[$key])){
                            array_push($adressCollection[$key],$adress);
                        }
                        $methodNameSetKey = 'set' . ucfirst($key) . 'Key';
                        $methodNameGetKey = 'get' . ucfirst($key) . 'Key';
                        if(is_callable(array($message, $methodNameSetKey)) && is_callable(array($message, $methodNameGetKey))){
                            if(is_null($message->$methodNameGetKey())){
                                $message->$methodNameSetKey(array_search ($adress, $adressCollection[$key]));
                            } else {
                                $message->$methodNameSetKey($message->$methodNameGetKey() . ',' . array_search ($adress, $adressCollection[$key]));
                            }
                        }
                    }
                }
            }

        }
        $this->view->assign('adresses', $adressCollection);
        $this->view->assign('messages', $messages);
    }

    public function extractEmail($string){
        $pattern="/(?:[A-Za-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[A-Za-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[A-Za-z0-9-]*[A-Za-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
        preg_match_all($pattern, $string, $matches);
        return $matches[0];
    }

    /**
     * action show.
     *
     * @param \GeorgRinger\Maildebug\Domain\Model\Message
     *
     * @return void
     */
    public function showAction(\GeorgRinger\Maildebug\Domain\Model\Message $message)
    {
        $this->view->assign('message', $message);
    }

    /**
     * injectMessageRepository.
     *
     * @param \GeorgRinger\Maildebug\Domain\Repository\MessageRepository $messageRepository
     *
     * @return void
     */
    public function injectMessageRepository(\GeorgRinger\Maildebug\Domain\Repository\MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }
}

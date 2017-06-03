<?php

namespace GeorgRinger\Maildebug\Transport;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DatabaseTransport implements \Swift_Transport
{
    /**
     * Create a new MailTransport.
     */
    public function __construct()
    {
    }

    /**
     * Not used.
     */
    public function isStarted()
    {
        return false;
    }

    /**
     * Not used.
     */
    public function start()
    {
    }

    /**
     * Not used.
     */
    public function stop()
    {
    }

    /**
     * Outputs the mail to a text file according to RFC 4155.
     *
     * @param \Swift_Mime_Message $message           The message to send
     * @param string[]            &$failedRecipients To collect failures by-reference, nothing will fail in our debugging case
     *
     * @return int
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->saveMailToDatabase($message);
        // Call normal stuff
        if ($this->forwardMessageWithDefaultHandler($message)) {
            $mailTransport = \Swift_MailTransport::newInstance();

            /** @var \TYPO3\CMS\Core\Mail\Mailer $mailer */
            $mailer = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\Mailer', $mailTransport);
            $mailer->send($message);
        }

        return 1;
    }

    /**
     * Check if message is allowed to be forwarded.
     *
     * @param Swift_Mime_Message $message
     *
     * @return bool
     */
    protected function forwardMessageWithDefaultHandler(\Swift_Mime_Message $message)
    {
        $sendAsEmail = true;
        foreach ($message->getTo() as $key => $value) {
            $check = true;
            if (empty($value)) {
                $check = $this->isValidDebugEmailAddress($key);
            } else {
                $check = $this->isValidDebugEmailAddress($key);
            }
            if ($check === false) {
                return false;
            }
        }

        $bcc = $message->getBcc();
        $bcc = !is_array($bcc) ? [] : $bcc;
        foreach ($bcc as $key => $value) {
            $check = true;
            if (empty($value)) {
                $check = $this->isValidDebugEmailAddress($key);
            } else {
                $check = $this->isValidDebugEmailAddress($value);
            }
            if ($check === false) {
                return false;
            }
        }
//var_dump($sendAsEmail);die;
        return $sendAsEmail;
    }

    /**
     * Check given email address against some patterns.
     *
     * @param string $email
     *
     * @return bool
     */
    protected function isValidDebugEmailAddress($email)
    {
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['maildebug']);

        if (!is_array($settings) || empty($settings['addresses'])) {
            return true;
        }
        if ($settings['logAndSendAllMails']) {
            return true;
        }
        $allowedChecks = GeneralUtility::trimExplode(',', $settings['addresses'], true);

        foreach ($allowedChecks as $singleCheck) {
            if ($email === $singleCheck || ($singleCheck === substr($email, (-1) * strlen($singleCheck)))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Swift_Mime_Message $message
     *
     * @return void
     */
    protected function saveMailToDatabase(\Swift_Mime_Message $message)
    {
        $insert = [
            'pid'               => 0,
            'body'              => (string) $message->getBody(),
            'date'              => (string) $message->getDate(),
            'subject'           => (string) $message->getSubject(),
            'tx_maildebug_from' => (string) $this->arrayToString($message->getFrom()),
            'tx_maildebug_to'   => (string) $this->arrayToString($message->getTo()),
            'bcc'               => (string) $this->arrayToString($message->getBcc()),
            'cc'                => (string) $this->arrayToString($message->getCc()),
            'content_type'      => (string) $message->getContentType(),
        ];
        if (is_object($GLOBALS['TYPO3_DB'])) {
            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_maildebug_domain_model_message', $insert);
        } else {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_maildebug_domain_model_message');
            $queryBuilder
                ->insert('tx_maildebug_domain_model_message')
                ->values(
                    $insert
                )
                ->execute();
        }
    }

    /**
     * Register a plugin in the Transport.
     *
     * @param \Swift_Events_EventListener $plugin
     *
     * @return bool
     */
    public function registerPlugin(\Swift_Events_EventListener $plugin)
    {
        return true;
    }

    /**
     * @param array $in
     *
     * @return string
     */
    protected function arrayToString(array $in)
    {
        $out = [];
        foreach ($in as $key => $value) {
            if (empty($value)) {
                $out[] = $key;
            } else {
                $out[] = $value.' ('.$key.')';
            }
        }

        return implode('|', $out);
    }
}

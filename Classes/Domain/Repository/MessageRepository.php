<?php

namespace GeorgRinger\Maildebug\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class MessageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param int $limit
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAll($limit = 100)
    {
        $query = $this->createQuery();

        $ordering = [
            'uid' => QueryInterface::ORDER_DESCENDING,
        ];

        $query->setLimit($limit);
        $query->setOrderings($ordering);
        $query->getQuerySettings()->setRespectStoragePage(false);

        return $query->execute();
    }
}

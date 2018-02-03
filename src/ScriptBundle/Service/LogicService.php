<?php
namespace ScriptBundle\Service;

use Doctrine\ORM\EntityManager;
use ScriptBundle\Entity\Line;

class LogicService
{
    /** @var EntityManager $em */
    protected $em;

    /** @var ApiHelperService $apiHelperService */
    protected $apiHelperService;

    protected $logger;

//    /**
//     * LogicService constructor.
//     * @param EntityManager $entityManager
//     * @param ApiHelperService $apiHelperService
//     */
//    public function __construct(EntityManager $entityManager, ApiHelperService $apiHelperService)
//    {
//        $this->em = $entityManager;
//        $this->apiHelperService = $apiHelperService;
//    }

    /**
     * @param Line $line
     * @return int $uniqId
     */
    public function logicBeforeSendToApi(Line $line)
    {
        // вычисления и тд
        $data = [];
        $uniqId = $this->apiHelperService->sendData($data);

        return $uniqId;
    }

    public function setLogger($logger, $entityManager, $apiHelperService)
    {
        $this->logger = $logger;
        $this->em = $entityManager;
        $this->apiHelperService = $apiHelperService;
    }
}
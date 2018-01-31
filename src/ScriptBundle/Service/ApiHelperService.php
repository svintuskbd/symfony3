<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 31.01.18
 * Time: 21:18
 */

namespace ScriptBundle\Service;

use Doctrine\ORM\EntityManager;

class ApiHelperService
{
    /** @var EntityManager $em */
    protected $em;

    /**
     * LogicService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     *
     */
    public function connect()
    {
        //...
    }

    /**
     * @param array $data
     * @return int $uniqId
     */
    public function sendData(array $data)
    {
        //....
        $uniqId = rand(1, 100);

        return $uniqId;
    }
}
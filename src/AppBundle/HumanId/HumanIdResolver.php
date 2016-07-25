<?php

namespace AppBundle\HumanId;

use AppBundle\Entity\Ticket\TicketHumanIdProvider;
use AppBundle\Entity\User\UserHumanIdProvider;
use Doctrine\ORM\EntityManager;

class HumanIdResolver
{
    const HUMAN_ID_REGEXP = '/^([A-Za-z]{3})\-([A-Za-z]{3})?\-([0-9]{1,9})$/';

    /** @var EntityHumanIdProvider[] */
    protected $entityMap = [];

    /**
     * HumanIdHelper constructor.
     */
    public function __construct()
    {
        $this->registerProviders();
    }

    /**
     * Fetches an entity type from a human id.
     *
     * @param $humanId
     * @return string
     */
    public function getEntityTypeFromHumanId($humanId)
    {
        if (($provider = $this->getProviderForHumanId($humanId)) !== null) {
            return $provider->getEntityClass();
        }

        return null;
    }

    /**
     * Return the entity ID from a human id
     *
     * @param $humanId
     * @return int
     */
    public function getEntityIdFromHumanId($humanId)
    {
        $items = explode('-', $humanId);

        return (int)$items[2];
    }

    /**
     * Returns an entity by its human id.
     *
     * @param EntityManager $em
     * @param $humanId
     * @return null|object
     */
    public function getEntityFromHumanId(EntityManager $em, $humanId)
    {
        $entity = $this->getEntityTypeFromHumanId($humanId);
        $id = $this->getEntityIdFromHumanId($humanId);

        return $em->getRepository($entity)->find($id);
    }

    /**
     * Returns whether a human id is valid.
     * 
     * @param $humanId
     * @return bool
     */
    public function isValidHumanId($humanId)
    {
        preg_match(self::HUMAN_ID_REGEXP, $humanId, $matches);

        return count($matches) === 4;
    }

    /**
     * @param $humanId
     * @return EntityHumanIdProvider|null
     */
    public function getProviderForHumanId($humanId)
    {
        $items = explode('-', $humanId);

        if(isset($this->entityMap[$items[0]])){
            return $this->entityMap[$items[0]];
        } else {
            return null;
        }
    }


    /**
     * Register entity providers.
     */
    protected function registerProviders()
    {
        $this->registerProvider(new TicketHumanIdProvider());
        $this->registerProvider(new UserHumanIdProvider());
    }

    /**
     * @param EntityHumanIdProvider $provider
     */
    protected function registerProvider(EntityHumanIdProvider $provider)
    {
        $this->entityMap[$provider->getPrefix()] = $provider;
    }
}
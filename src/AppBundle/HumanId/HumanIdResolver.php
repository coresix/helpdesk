<?php

namespace AppBundle\HumanId;

use AppBundle\Entity\Ticket\TicketHumanIdProvider;
use AppBundle\Entity\User\UserHumanIdProvider;
use AppBundle\HumanId\Exception\InvalidHumanId;
use AppBundle\HumanId\Exception\NoProvider;
use Doctrine\ORM\EntityManager;

class HumanIdResolver
{
    const HUMAN_ID_REGEXP = '/^([A-Za-z]{3})\-([A-Za-z]{3})?\-([0-9]{1,9})$/';

    /** @var EntityHumanIdProvider[] */
    protected $providers = [];

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
     * @return HumanIdEntity
     */
    public function getEntityFromHumanId(EntityManager $em, $humanId)
    {
        if (!$this->isValidHumanId($humanId)){
            throw new InvalidHumanId(sprintf(
                "'%s' is not a valid human id",
                $humanId
            ));
        }

        $entity = $this->getEntityTypeFromHumanId($humanId);
        $id = $this->getEntityIdFromHumanId($humanId);
        $provider = $this->getProviderForHumanId($humanId);

        return $em->getRepository($entity)->findOneBy([$provider->getEntityIdentityField() => $id]);
    }


    /**
     * Returns whether a human id is valid.
     * 
     * @param $humanId
     * @return bool
     */
    public function isValidHumanId($humanId)
    {
        preg_match(static::HUMAN_ID_REGEXP, $humanId, $matches);

        return count($matches) === 4;
    }

    /**
     * @param $humanId
     * @return EntityHumanIdProvider|null
     * @throws NoProvider
     */
    public function getProviderForHumanId($humanId)
    {
        if (!$this->isValidHumanId($humanId)){
            throw new InvalidHumanId(sprintf(
                "'%s' is not a valid human id",
                $humanId
            ));
        }

        $items = explode('-', $humanId);

        if(isset($this->providers[$items[0]])){
            return $this->providers[$items[0]];
        } else {
            throw new NoProvider(sprintf(
                "Human ID '%s' does not have a registered provider",
                $humanId
            ));
        }
    }


    /**
     * Register entity providers.
     * @todo: move this out of here!
     */
    protected function registerProviders()
    {
        $this->registerProvider(new TicketHumanIdProvider());
        $this->registerProvider(new UserHumanIdProvider());
    }

    /**
     * Registers Entity Providers to the local cache.
     *
     * @param EntityHumanIdProvider $provider
     */
    protected function registerProvider(EntityHumanIdProvider $provider)
    {
        $this->providers[$provider->getPrefix()] = $provider;
    }
}
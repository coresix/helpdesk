<?php

namespace AppBundle\ResourceId;

use AppBundle\Entity\Ticket\TicketResourceIdProvider;
use AppBundle\Entity\User\UserResourceIdProvider;
use AppBundle\ResourceId\Exception\InvalidResourceId;
use AppBundle\ResourceId\Exception\NoProvider;
use Doctrine\ORM\EntityManager;

class ResourceIdResolver
{
    const ID_REGEXP = '/^([A-Za-z]{3})\-([A-Za-z]{3})?\-([0-9]{1,9})$/';

    /** @var EntityResourceProvider[] */
    protected $providers = [];

    /**
     * ResourceIdResolver constructor.
     */
    public function __construct()
    {
        $this->registerProviders();
    }

    /**
     * Fetches an entity type from a resource id.
     *
     * @param $resourceId
     * @return string
     */
    public function getEntityTypeFromResourceId($resourceId)
    {
        if (($provider = $this->getProviderForResourceId($resourceId)) !== null) {
            return $provider->getEntityClass();
        }

        return null;
    }

    /**
     * Return the entity ID from a resource id
     *
     * @param $resourceId
     * @return int
     */
    public function getEntityIdFromResourceId($resourceId)
    {
        $items = explode('-', $resourceId);

        return (int)$items[2];
    }

    /**
     * Returns an entity by its resource id.
     *
     * @param EntityManager $em
     * @param $resourceId
     * @return ResourceIdEntity
     */
    public function getEntityFromResourceId(EntityManager $em, $resourceId)
    {
        if (!$this->isValidResourceId($resourceId)){
            throw new InvalidResourceId(sprintf(
                "'%s' is not a valid resource id",
                $resourceId
            ));
        }

        $entity = $this->getEntityTypeFromResourceId($resourceId);
        $id = $this->getEntityIdFromResourceId($resourceId);
        $provider = $this->getProviderForResourceId($resourceId);

        return $em->getRepository($entity)->findOneBy([$provider->getEntityIdentityField() => $id]);
    }


    /**
     * Returns whether a resource id is valid.
     * 
     * @param $resourceId
     * @return bool
     */
    public function isValidResourceId($resourceId)
    {
        preg_match(static::ID_REGEXP, $resourceId, $matches);

        return count($matches) === 4;
    }

    /**
     * @param $resourceId
     * @return EntityResourceProvider|null
     * @throws NoProvider
     */
    public function getProviderForResourceId($resourceId)
    {
        if (!$this->isValidResourceId($resourceId)){
            throw new InvalidResourceId(sprintf(
                "'%s' is not a valid Resource ID",
                $resourceId
            ));
        }

        $items = explode('-', $resourceId);

        if(isset($this->providers[$items[0]])){
            return $this->providers[$items[0]];
        } else {
            throw new NoProvider(sprintf(
                "Resource ID '%s' does not have a registered provider",
                $resourceId
            ));
        }
    }


    /**
     * Register entity providers.
     * @todo: move this out of here!
     */
    protected function registerProviders()
    {
        $this->registerProvider(new TicketResourceIdProvider());
        $this->registerProvider(new UserResourceIdProvider());
    }

    /**
     * Registers Entity Providers to the local cache.
     *
     * @param EntityResourceProvider $provider
     */
    protected function registerProvider(EntityResourceProvider $provider)
    {
        $this->providers[$provider->getPrefix()] = $provider;
    }
}
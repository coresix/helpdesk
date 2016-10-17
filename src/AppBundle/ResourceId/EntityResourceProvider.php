<?php

namespace AppBundle\ResourceId;


interface EntityResourceProvider
{

    /**
     * @return string
     */
    public function getEntityClass();

    /**
     * @return bool
     */
    public function supportsSearching();

    /**
     * @return bool
     */
    public function getPrefix();

    /**
     * @return string
     */
    public function getEntityIdentityField();
}
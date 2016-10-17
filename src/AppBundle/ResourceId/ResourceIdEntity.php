<?php

namespace AppBundle\ResourceId;


interface ResourceIdEntity
{
    /**
     * Returns a resource identifier for the entity.
     * 
     * @return string
     */
    public function getResourceId();
}
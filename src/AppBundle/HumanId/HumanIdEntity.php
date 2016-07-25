<?php

namespace AppBundle\HumanId;


interface HumanIdEntity
{
    /**
     * Returns a human identifier for the entity.
     * 
     * @return string
     */
    public function getHumanId();
}
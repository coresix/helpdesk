<?php

namespace AppBundle\Entity;


interface HumanIdEntity
{
    /**
     * @return int
     */
    public function getId();

    /**
     * Returns a human identifier for the entity.
     * 
     * @return string
     */
    public function getHumanId();
}
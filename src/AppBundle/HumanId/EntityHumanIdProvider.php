<?php

namespace AppBundle\HumanId;


interface EntityHumanIdProvider
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
}
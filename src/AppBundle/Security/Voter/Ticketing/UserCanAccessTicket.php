<?php

namespace AppBundle\Security\Voter\Ticketing;

use AppBundle\Entity\Ticket\Ticket;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class UserCanAccessTicket implements VoterInterface
{
    /**
     * @param TokenInterface $token
     * @param Ticket $subject
     * @param array $attributes
     *
     * @return bool
     */
    public function vote(TokenInterface $token, $subject, array $attributes = [])
    {
        return $token->getUser() === $subject->getCreatedUser();
    }
}
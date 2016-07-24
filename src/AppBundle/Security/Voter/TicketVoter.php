<?php

namespace AppBundle\Security\Voter;

use AppBundle\Entity\Ticket\Ticket;
use AppBundle\Entity\User\User;
use AppBundle\Security\Voter\Ticketing\UserAssignedToTicket;
use AppBundle\Security\Voter\Ticketing\UserCanAccessTicket;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TicketVoter extends Voter
{

    const VIEW = 'view';
    const EDIT = 'edit';
    const REPLY = 'reply';

    protected $attributeList = [
        self::VIEW,
        self::EDIT,
        self::REPLY,
    ];

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, $this->attributeList)) {
            return false;
        }

        if (!$subject instanceof Ticket) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Ticket $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if (!$user = $token->getUser() instanceof User) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $token);
            case self::REPLY:
                return $this->canReply($subject, $token);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Ticket $ticket
     * @param TokenInterface $token
     * @return bool
     */
    private function canView(Ticket $ticket, TokenInterface $token)
    {
        return (
                (new UserAssignedToTicket())->vote($token, $ticket, [])
            ||  (new UserCanAccessTicket())->vote($token, $ticket, [])
        );
    }

    /**
     * @param Ticket $ticket
     * @param TokenInterface $token
     * @return bool
     */
    private function canReply(Ticket $ticket, TokenInterface $token)
    {
        return (
                (new UserAssignedToTicket())->vote($token, $ticket, [])
            ||  (new UserCanAccessTicket())->vote($token, $ticket, [])
        );
    }
}
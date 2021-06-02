<?php

namespace App\Security\Voter;

use App\Entity\Quote;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class QuoteVoter extends Voter
{
    public const EDIT = 'QUOTE_EDIT';
    public const LIKE = 'QUOTE_LIKE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::LIKE])
            && $subject instanceof \App\Entity\Quote;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::LIKE:
                return $this->canLike($subject, $user);
        }

        return false;
    }

    private function canEdit(Quote $quote, User $user)
    {
        return $user === $quote->getAuthor()
            || $this->security->isGranted('ROLE_ADMIN');
    }

    private function canLike(Quote $quote, User $user)
    {
        return $user !== $quote->getAuthor();
    }
}

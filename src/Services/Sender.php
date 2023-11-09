<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }

    public function sendNewUserNotificationToAdmin(UserInterface $user)
    {
        $email = new Email();
        $email->from('no-reply@series.com')
            ->to('admin@series.com')
            ->subject('Nouveau Compte créé')
            ->html('<h1> Nouveau compte créé </h1> Utilisateur :' . $user->getUserIdentifier());
        $this->mailer->send($email);
    }
}
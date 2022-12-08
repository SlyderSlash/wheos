<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Envoie du mail
     *
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $template
     * @param array $context
     * @return void
     */
    public function send(string $from, string $to, string $subject, string $template, array $context): void
    {
        // crée le mail
        $email = (new TemplatedEmail())
        ->from('contact@devweb-chartres.me')
        ->to($to)
        ->subject($subject)
        ->htmlTemplate("emails/$template.html.twig")
        ->context($context);

        // on envoie le mail
        $this->mailer->send($email);
    }
}
<?php 
// src/Controller/InvoiceController.php
namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Notifier\Recipient\RecipientInterface;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice')]
    public function index(): Response
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
    #[Route('/invoice/create')]
    public function create(NotifierInterface $notifier)
    {
        // ...

        // Create a Notification that has to be sent
        // using the "email" channel
        $notification = (new Notification('New Invoice', ['email']))
            ->content('You got a new invoice for 15 EUR.');

        // The receiver of the Notification
        $recipient = new Recipient(
            $user= $this->getParameter('app.entity_users'),
            $user->getEmail()
        );

        // Send the notification to the recipient
        $notifier->send($notification, $recipient);

        // ...
    }
}
class InvoiceNotification extends Notification
{
    private $price;

    public function __construct(int $price)
    {
        $this->price = $price;
    }


}
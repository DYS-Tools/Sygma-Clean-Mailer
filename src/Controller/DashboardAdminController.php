<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Repository\ListMailRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
*/
class DashboardAdminController extends AbstractController
{
    /**
     * @Route("/dashboard/admin", name="app_dashboard_admin")
     */
    public function index(UserRepository $userRepository, OrderRepository $orderRepository, ListMailRepository $listMailRepository)
    {
        $ClientNumber = $userRepository->countAllUser();
        $OrderNumber = $orderRepository->countAllOrder();
        $ListMailNumber = $listMailRepository->countAllListMail();

        return $this->render('dashboard/admin/dashboardAdmin.html.twig', [
            'ClientNumber' => $ClientNumber,
            'OrderNumber' => $OrderNumber,
            'ListMailNumber' => $ListMailNumber
        ]);
    }

    /**
     * @Route("/dashboard/admin/ticket", name="app_dashboard_admin_ticket")
     */
    public function ticket()
    {
        return $this->render('dashboard/admin/ticket.html.twig', [
            'ticket' => $this->getDoctrine()->getRepository(Ticket::class)->findAllTicketOpen(),
            'countTicketOpen' => $this->getDoctrine()->getRepository(Ticket::class)->countAllTicketOpen()
        ]);
    }
}

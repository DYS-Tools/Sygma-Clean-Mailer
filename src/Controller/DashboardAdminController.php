<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Ticket;
use App\Form\TicketResponseType;
use App\Repository\ListMailRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'ListMailNumber' => $ListMailNumber,
            'Order' => $this->getDoctrine()->getRepository(Order::class)->findAllOrderAdmin()
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

    /**
     * @Route("/dashboard/admin/ticket/resolve/{id}", name="app_dashboard_admin_ticket_resolve")
     */
    public function resolve(Request $request, $id)
    {
        $editTicket = $this->getDoctrine()->getRepository(Ticket::class)->find($id);

        $form = $this->createForm(TicketResponseType::class, $editTicket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editTicket->setState(0);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vous avez répondu et fermer le ticket');

            return $this->redirectToRoute('app_dashboard_admin_ticket');
        }

        return $this->render('dashboard/admin/resolveTicket.html.twig', [
            'form' => $form->createView(),
            'ticket' => $this->getDoctrine()->getRepository(Ticket::class)->findAllTicketOpen(),
            'countTicketOpen' => $this->getDoctrine()->getRepository(Ticket::class)->countAllTicketOpen(),
            'singleTicket' => $this->getDoctrine()->getRepository(Ticket::class)->find($id)
        ]);
    }
}

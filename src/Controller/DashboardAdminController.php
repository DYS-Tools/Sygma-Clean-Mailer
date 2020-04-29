<?php

namespace App\Controller;

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
    public function index()
    {
        return $this->render('dashboard/dashboardAdmin.html.twig', [
        ]);
    }
}

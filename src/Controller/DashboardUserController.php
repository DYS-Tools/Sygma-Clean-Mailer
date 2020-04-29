<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Require ROLE_USER for *every* controller method in this class.
 * @IsGranted("ROLE_USER")
 */
class DashboardUserController extends AbstractController
{
    /**
     * @Route("/dashboard/user", name="app_dashboard_user")
     */
    public function index()
    {
        return $this->render('dashboard/dashboardUser.html.twig', [
        ]);
    }
}

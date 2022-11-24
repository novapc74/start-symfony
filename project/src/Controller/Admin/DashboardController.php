<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
	#[Route('/admin', name: 'admin')]
	public function index(): Response
	{
		return $this->render('@EasyAdmin/page/content.html.twig');
	}

	public function configureDashboard(): Dashboard
	{
		return Dashboard::new()
			->setTitle('☢ New project');
	}

	public function configureAssets(): Assets
	{
		return Assets::new()->addJsFile('/bundles/fosckeditor/ckeditor.js');
	}

	public function configureCrud(): Crud
	{
		return Crud::new()->setPaginatorPageSize(20);
	}

	public function configureMenuItems(): iterable
	{
//		yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
		yield MenuItem::section('========== 🌹🌹🌹 ===========');

		yield MenuItem::linkToCrud('Пользователи', 'fas fa-key', User::class);

		// yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
	}
}

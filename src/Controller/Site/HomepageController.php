<?php

namespace App\Controller\Site;

use App\Entity\Site\Homepage;
use App\Form\Site\HomepageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomepageController extends AbstractController {
	/**
	 * @Route("/", name="site_homepage_index", methods="GET")
	 */
	public function index(): Response{
		$this->javascripts = array(
			"themes/html5up-helios/assets/js/jquery.min.js",
			"themes/html5up-helios/assets/js/jquery.dropotron.min.js",
			"themes/html5up-helios/assets/js/jquery.scrolly.min.js",
			"themes/html5up-helios/assets/js/jquery.scrollex.min.js",
			"themes/html5up-helios/assets/js/browser.min.js",
			"themes/html5up-helios/assets/js/breakpoints.min.js",
			"themes/html5up-helios/assets/js/util.js",
			"themes/html5up-helios/assets/js/main.js",
		);

		$activeHomepage = $this->getDoctrine()
			->getRepository(Homepage::class)
			->findActiveHomepage()
		;

		$configs = array(
			'site' => [
				'theme' => 'cascade',
			],
		);

		return $this->render('site/homepage/index.html.twig', [
			'homepage' => $activeHomepage,
			'javascripts' => $this->javascripts,
			'configs' => $configs,
		]);
	}

	/**
	 * @Route("/new", name="site_homepage_new", methods="GET|POST")
	 */
	public function new (Request $request): Response{
		$homepage = new Homepage();
		$form = $this->createForm(HomepageType::class, $homepage);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($homepage);
			$em->flush();

			return $this->redirectToRoute('site_homepage_index');
		}

		return $this->render('site/homepage/new.html.twig', [
			'homepage' => $homepage,
			'form' => $form->createView(),
		]);
	}
}

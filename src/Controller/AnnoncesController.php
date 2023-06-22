<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Annonce;
use App\Entity\ImageAnnonces;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AnnonceType;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AnnoncesController extends AbstractController {

    /**
     * @Route("/", name="page_accueil")
     */
    public function accueil(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response {
        $kyword = $request->query->get("keyword");
        if ($this->isGranted('ROLE_ADMIN')) {
            $annoncesqb = $doctrine->getRepository(Annonce::class)->getAnnonces($kyword, null, null, null);
        } else {
            $annoncesqb = $doctrine->getRepository(Annonce::class)->getAnnonces($kyword, null, null, true);
        }
        $annonceQuery = $annoncesqb->getQuery();

        $annonces = $paginator->paginate(
                $annonceQuery, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                6 /* limit per page */
        );

        return $this->render('accueil.html.twig', ["annonces" => $annonces, "keyword" => $kyword]);
    }

    /**
     * @Route("/annonces/{slug}", name="page_details")
     */
    public function details($slug, ManagerRegistry $doctrine): Response {

        $annonce = $doctrine->getRepository(Annonce::class)->findOneBy(["slug" => $slug]);

        if (!$annonce) {
            $this->addFlash('danger', "Annonce non trouvée");
            return $this->redirectToRoute('page_accueil');
        }

        return $this->render('details.html.twig', ["annonce" => $annonce]);
    }

    /**
     * @Route("/admin/annonces/modifier/{slug}", name="page_Edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function Edit($slug, ManagerRegistry $doctrine, Request $request): Response {

        $annonce = $doctrine->getRepository(Annonce::class)->findOneBy(["slug" => $slug]);

        if (!$annonce) {
            $this->addFlash('danger', "Annonce non trouvée");
            return $this->redirectToRoute('page_accueil');
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $doctrine->getManager();
                $em->persist($annonce);
                $em->flush();
                $this->addFlash('success', "Votre annonce a été bien modifiée");
                return $this->redirectToRoute('page_accueil');
            }
        }

        return $this->render('edit.html.twig', ["form" => $form->createView(),]);
    }

    /**
     * @Route("/admin/annonces/delete/{slug}", name="page_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($slug, ManagerRegistry $doctrine, Request $request): Response {

        $annonce = $doctrine->getRepository(Annonce::class)->findOneBy(["slug" => $slug]);

        if (!$annonce) {
            $this->addFlash('danger', "Annonce non trouvée");
            return $this->redirectToRoute('page_accueil');
        }

        $em = $doctrine->getManager();
        $em->remove($annonce);
        $em->flush();
        $this->addFlash('success', "Votre annonce a été bien Supp");
        return $this->redirectToRoute('page_accueil');
    }

    /**
     * @Route("/admin/ajouter", name="page_ajouterAnnonce")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response {

        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce, array('validation_groups' => ['create', 'Default']));
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $doctrine->getManager();
                $annonce->setDateCreation(new \DateTime);
                $annonce->setUtilisateur($this->getUser());
                $em->persist($annonce);
                $em->flush();
                $this->addFlash('success', "Votre annonce a été bien ajoutée");
                return $this->redirectToRoute('page_accueil');
            }
        }

        return $this->render('ajouterAnnonce.html.twig', [
                    "form" => $form->createView(),
        ]);
    }

}

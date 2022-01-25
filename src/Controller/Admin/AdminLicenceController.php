<?php

namespace App\Controller\Admin;

use App\Entity\Licence;
use App\Form\LicenceType;
use App\Repository\LicenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminLicenceController extends AbstractController
{

    /**
     * @Route("admin/licences", name="admin_licence_list")
     */
    public function licenceList(LicenceRepository $licenceRepository)
    {
        $licences = $licenceRepository->findAll();

        return $this->render("admin/licences.html.twig", ['licences' => $licences]);
    }

    /**
     * @Route("admin/licence/{id}", name="admin_licence_show")
     */
    public function licenceShow(LicenceRepository $licenceRepository, $id)
    {
        $licence = $licenceRepository->find($id);

        return $this->render("admin/licence.html.twig", ['licence' => $licence]);
    }

    /**
     * @Route("admin/update/licence/{id}", name="admin_update_licence")
     */
    public function adminUpdateLicence(
        $id,
        LicenceRepository $licenceRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {

        $licence = $licenceRepository->find($id);

        $licenceForm = $this->createForm(LicenceType::class, $licence);

        $licenceForm->handleRequest($request);

        if ($licenceForm->isSubmitted() && $licenceForm->isValid()) {

            $mediaFile = $licenceForm->get('media')->getData();

            if ($mediaFile) {

                // On crée un nom unique avec le nom original de l'image pour éviter 
                // tout problème lors de l'enregistrement dans le dossier public

                // on récupère le nom original du fichier
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                // On utilise slug sur le nom original pouur avoir un nom valide
                $safeFilename = $sluggerInterface->slug($originalFilename);

                // On ajoute un id unique au nom du fichier
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                // On déplace le fichier dans le dossier public/media
                // la destination est définie dans 'images_directory'
                // du fichier config/services.yaml

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $licence->setMedia($newFilename);
            }

            $entityManagerInterface->persist($licence);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_licence_list");
        }


        return $this->render("admin/licenceform.html.twig", ['licenceForm' => $licenceForm->createView()]);
    }

    /**
     * @Route("admin/create/licence/", name="admin_licence_create")
     */
    public function adminLicenceCreate(Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $sluggerInterface)
    {
        $licence = new Licence();

        $licenceForm = $this->createForm(LicenceType::class, $licence);

        $licenceForm->handleRequest($request);

        if ($licenceForm->isSubmitted() && $licenceForm->isValid()) {

            // On récupère le fichier que l'on rentre dans le champs du formulaire
            $mediaFile = $licenceForm->get('media')->getData();

            if ($mediaFile) {

                // On crée un nom unique avec le nom original de l'image pour éviter 
                // tout problème lors de l'enregistrement dans le dossier public

                // on récupère le nom original du fichier
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                // On utilise slug sur le nom original pouur avoir un nom valide
                $safeFilename = $sluggerInterface->slug($originalFilename);

                // On ajoute un id unique au nom du fichier
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                // On déplace le fichier dans le dossier public/media
                // la destination est définie dans 'images_directory'
                // du fichier config/services.yaml

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $licence->setMedia($newFilename);
            }


            $entityManagerInterface->persist($licence);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_licence_list");
        }


        return $this->render("admin/licenceform.html.twig", ['licenceForm' => $licenceForm->createView()]);
    }

    /**
     * @Route("admin/delete/licence/{id}", name="licence_delete")
     */
    public function licenceDelete(
        $id,
        EntityManagerInterface $entityManagerInterface,
        LicenceRepository $licenceRepository
    ) {

        $licence = $licenceRepository->find($id);

        $entityManagerInterface->remove($licence);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_licence_list");
    }
}
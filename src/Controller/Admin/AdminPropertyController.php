<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     * @Route("/admin/property", name="admin.property.index")
     */
    public function index(PropertyRepository $repository)
    {
        $properties = $repository->findAll();
        return $this->render('admin/admin_property/index.html.twig',compact('properties'));
    }

    /**
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/property/create", name="admin.property.create")
     */
    public function create(Request $request, ObjectManager $manager){
        $property = new Property();
        // Generer le formulaire
        $form = $this->createForm(PropertyType::class, $property);

        //Traitement de formulaire

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($property);
            $manager->flush();

            $this->addFlash("notice", 'Un nouveau bien  à été bien créé!');
            return $this->redirectToRoute('admin.property.index');
        }


            return $this->render('admin/admin_property/create.html.twig', [
                'form' => $form->createView(),
            ]);

    }

    /**
     * @Route("/admin/{id}/edit", name="admin.property.edit")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request, ObjectManager $manager){

        //Generer le formulaire
        $form = $this->createForm(PropertyType::class, $property);

        //Traitement de formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();

            $this->addFlash("notice", 'Le bien numéro  '.$property->getId(). '  à été bien modifié!');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/admin_property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete")
     * @param Property $property
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, ObjectManager $manager, Request $request){

        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))) {

            $manager->remove($property);
            $manager->flush();
        }
        $this->addFlash("notice", 'Le bien numéro  '.$property->getId(). '  à été bien supprimé!');
        return $this->redirectToRoute('admin.property.index');
    }
}

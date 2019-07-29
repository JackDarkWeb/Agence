<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="property.index")
     * @param PropertyRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PropertyRepository $repository):Response
    {
        //$properties = $this->getDoctrine()->getRepository(Property::class);
        //dump($properties);

        $properties = $repository->findAllVisible();
        $latest = $repository->findLatest();

        return $this->render('property/index.html.twig', [
            "current_menu" => "properties",
            "properties" => $properties,
            "latest" => $latest,
        ]);
    }

    /**
     * @Route("/property/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug):Response{

        if($property->getSlug() !== $slug){

            return $this->redirectToRoute("property.show", [
                "id" => $property->getId(),
                "slug" => $property->getSlug()
            ], 301);
        }
        return $this->render("property/show.html.twig",[
            "current_menu" => "properties",
            "property" => $property,
        ]);
    }
}

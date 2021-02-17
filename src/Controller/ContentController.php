<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\ContentTranslation;
use App\Form\ContentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController
{
    /**
     * @Route("/content", name="content")
     */
    public function index(): Response
    {
        return $this->render('content/index.html.twig');
    }

    /**
     * @Route("/content/new", name="content_new")
     */
    public function new(Request $request){
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            /** @var ContentTranslation $translation */
            foreach ($content->getTranslations() as $translation){
                $manager->persist($translation);
            }

            $manager->persist($content);
            $manager->flush();

            return $this->redirectToRoute('dashboard_page');
        }

        return $this->render('content/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/content/{id}/edit", name="content_edit", requirements={"id":"\d+"})
     * @param Request $request
     * @param Content $content
     */
    public function edit(Request $request, Content $content){
        $form = $this->createForm(ContentType::class, $content);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($content);
            $manager->flush();

            return $this->redirectToRoute('content');
        }

        return $this->render('content/edit.html.twig', [
            'form' => $form->createView(),
            'content' => $content
        ]);
    }

    /**
     * @Route("/content/{id}/delete", name="content_delete", requirements={"id":"\d+"})
     */
    public function delete(Content $content){
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($content);
        $manager->flush();
        return $this->redirectToRoute('content');
    }
}

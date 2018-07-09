<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthorController extends Controller
{
    /**
     * @Route("/author", name="author")
     */
    public function index()
    {
        $authors = $this->getDoctrine()
            ->getRepository(Author::class)
            ->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/author/view/{author}", name="author_view")
     * @param Author $author
     * @return Response
     */
    public function view(Author $author) // HINT такая вот магия. Можно в методы передавать сами объекты, а не их ID. Symfony сама вытащит объект из репы.
    {
        return $this->render('author/view.html.twig', array(
            'author' => $author,
        ));
    }

    /**
     * @Route("/author/create", name="author_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $author = new Author();

        // How to use forms https://symfony.com.ua/doc/current/best_practices/forms.html
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('author_view', [
                'author' => $author->getId(),
            ]);
        }

        return $this->render('author/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/author/update/{author}", name="author_update")
     * @param Request $request
     * @param Author $author
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Author $author)
    {
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('author_view', [
                'author' => $author->getId(),
            ]);
        }

        return $this->render('author/update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // TODO для полного CRUD нуже ещё метод удаления, но его пока отложим.
}

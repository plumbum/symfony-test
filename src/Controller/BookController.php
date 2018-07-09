<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookController extends Controller
{
    /**
     * @Route("/book", name="book")
     */
    public function index()
    {
        $books = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/book/view/{book}", name="book_view")
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(Book $book)
    {
        return $this->render('book/view.html.twig', array(
            'book' => $book,
        ));
    }

    /**
     * @Route("/book/create", name="book_create")
     * @Route("/book/create/{author}", name="book_create_author")
     * @param Request $request
     * @param Author|null $author
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, Author $author = null)
    {
        $book = new Book();
        if ($author) {
            $book->getAuthors()->add($author);
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_view', [
                'book' => $book->getId(),
            ]);
        }

        return $this->render('book/create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/book/update/{book}", name="book_update")
     * @param Request $request
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Book $book)
    {

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('book_view', [
                'book' => $book->getId(),
            ]);
        }

        return $this->render('book/update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    // TODO для полного CRUD нуже ещё метод удаления, но его пока отложим.
}

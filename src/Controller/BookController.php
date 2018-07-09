<?php

namespace App\Controller;

use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
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
     * @param FileUploader $fileUploader
     * @param Author|null $author
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, FileUploader $fileUploader, Author $author = null)
    {
        $book = new Book();
        if ($author) {
            $book->getAuthors()->add($author);
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $book->getCover();
            if ($file) {
                $fileName = $fileUploader->upload($file);
                $book->setCover($fileName);
            }

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
     * @param FileUploader $fileUploader
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, FileUploader $fileUploader, Book $book)
    {

        $cover = $book->getCover();
        $cover_path = $this->getParameter('cover_directory') . '/' . $cover;
        if (file_exists($cover_path)) {
            $book->setCover(new File($cover_path));
        } else {
            $book->setCover(null);
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $book->getCover();
            if ($file) {
                $fileName = $fileUploader->upload($file);
                $book->setCover($fileName);
            } else {
                // Если изображение не было загружено при обновлении, то сохраняем старое
                $book->setCover($cover);
            }

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

    /**
     * @Route("/book/delete/{book}", name="book_delete")
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Book $book)
    {
        /* TODO по хорошему, мы не должны ничего удалять из базы, только если это действительно обоснованно.
            Вместо удаления стоит завести флаг, показывающий, что данные были "удалены".
        */

        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('book');
    }

}

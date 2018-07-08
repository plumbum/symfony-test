<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Hello world!',
            'path' => 'src/Controller/DefaultController.php',
            'date' => strftime('%F %T'),
        ]);
    }

    /**
     * @Route("/authors")
     */
    public function authors(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $authors = $em->find(Author::class);
        return $this->json($authors);

    }

    /**
     * @Route("/author/{id}")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function author(string $id, Request $request)
    {
        //  создаёт задачу и задаёт в ней фиктивные данные для этого примера
        $author = new Author();
        // $task->setTask('Write a blog post');
        // $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($author)
            ->add('last_name', TextType::class, ['label' => 'Фамилия'])
            ->add('first_name', TextType::class, ['label' => 'Имя'])
            ->add('middle_name', TextType::class, ['label' => 'Отчество'])
            ->add('save', SubmitType::class, array('label' => 'Добавить автора'))
            ->getForm();

        $form->handleRequest($request);

        /*
        var_dump($form);
        var_dump($author);
        var_dump($author->getShortName());
        var_dump($author->getFullName());
        */

        return $this->render('authors.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}

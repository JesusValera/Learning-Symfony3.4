<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);

        //return $this->render('TestAnnotationsBundle:Default:index.html.twig');
    }

    /**
     * @Route("/response", name="annoR_index")
     */
    public function indexRAction()
    {
        return new Response("<html><head><title>Response</title><body>Testing response.</body></head></html>");
    }

    /**
     * @Route("/name/{arg}", name="action_name")
     * @param string $arg
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nameAction($arg = 'Any argument.')
    {
        if ($arg == 'error') {
            throw new NotFoundHttpException("ERROR");
        }

        $names = [
            'Jesus' => [
                'name'   => 'Jesus',
                'active' => true,
            ],
            'Juan'  => [
                'name'   => 'Juan',
                'active' => false,
            ],
            'Jose'  => [
                'name'   => 'Jose',
                'active' => true,
            ],
        ];

        return $this->render('default/name.html.twig', [
            "arg"   => $arg,
            "names" => $names,
        ]);
    }

    /**
     * @Route("/example", name="action_example")
     */
    public function exampleAction()
    {
        return $this->render('default/example.html.twig');
    }

    /**
     * @Route("/redirection", name="action_redirect")
     */
    public function redirectionAction()
    {
        //return $this->redirect($this->generateUrl('homepage'));
        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/register", name="user_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_registration');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}

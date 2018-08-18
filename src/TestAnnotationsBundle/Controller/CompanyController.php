<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TestAnnotationsBundle\Entity\Company;
use TestAnnotationsBundle\Entity\Event;

class CompanyController extends Controller
{
    /**
     * @Route("/company/all", name="all_company")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allCompanyAction()
    {
        // Doctrine object.
        $manager = $this->getDoctrine()->getManager();

        $companies = $manager->getRepository(Company::class)->findAll();

        return $this->render('TestAnnotationsBundle:Company:all.html.twig', ["companies" => $companies]);
    }

    /**
     * @Route("/company/create", name="create_company")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCompanyAction()
    {
        // New company object.
        $company = new Company();
        $company->setName("Test company One");
        $company->setEmployeesNumber(100);
        $company->setCity("Murcia");

        // Doctrine object.
        $manager = $this->getDoctrine()->getManager();
        // Add object to the doctrine manager.
        $manager->persist($company);
        // Save the changes into DB.
        $manager->flush();

        return $this->render('TestAnnotationsBundle:Company:createcompany.html.twig', ["company" => $company]);
    }

    /**
     * @Route("/company/get/{id}", name="get_company")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanyAction($id = 0)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);

        if (!isset($company)) {
            throw new NotFoundHttpException("There is no company whose id is: $id");
        }

        return $this->render('TestAnnotationsBundle:Company:getcompany.html.twig', ["company" => $company]);
    }

    /**
     * @Route("/company/getname/{name}", name="get_name_company")
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanyByNameAction($name)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        // findOneBy{attribute name in CamelCase}->()
        $company = $repository->findOneByName($name);

        if (!isset($company)) {
            throw new NotFoundHttpException("There is no company whose name is: $name");
        }

        return new Response("Company with name $name has a city '{$company->getCity()}' and there are '{$company->getEmployeesNumber()}' employees.");
    }

    /**
     * @Route("/company/update/{id}/{city}", name="update_company")
     * @param $id
     * @param $city
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateCompanyAction($id, $city = "Any city")
    {
        // 1. Get object from DB.
        $manager = $this->getDoctrine()->getManager();
        $company = $manager->find(Company::class, $id);

        // 2. Check if the object exists.
        if (!isset($company)) {
            throw $this->createNotFoundException("Check out if the id and name values are valid.");
        }

        // 3. Update the object.
        /** @var $company Company */
        $company->setCity($city);

        // 4. Persist and flush.
        $manager->persist($company);
        $manager->flush();

        return $this->redirectToRoute('all_company');
    }
}

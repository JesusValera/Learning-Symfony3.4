<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/all", name="all_company")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allCompanyAction()
    {
        // Doctrine object.
        $manager = $this->getDoctrine()->getManager();

        $companies = $manager->getRepository(Company::class)->findAll();

        return $this->render('company/all.html.twig', [
            "companies" => $companies,
        ]);
    }

    /**
     * @Route("/create/{name}/{city}/{empNumber}", name="create_company",
     *  defaults={
     *     "name"="Another company",
     *     "city" = "Wonderland",
     *     "empNumber" = 1}
     *   )
     * @param string $name
     * @param string $city
     * @param int $empNumber
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCompanyAction($name = "Another company", $city = "Wonderland", $empNumber = 1)
    {
        // New company object.
        $company = new Company();
        $company->setName($name);
        $company->setCity($city);
        $company->setEmployeesNumber($empNumber);

        // Doctrine object.
        $manager = $this->getDoctrine()->getManager();
        // Add object to the doctrine manager.
        $manager->persist($company);
        // Save the changes into DB.
        $manager->flush();

        return $this->render('company/createcompany.html.twig', [
            "company" => $company,
        ]);
    }

    /**
     * @Route("/get/{id}", name="get_company", methods={"GET"})
     * @Route("/{_locale}/company/get/{id}", methods={"GET"}, name="get_company_lan",
     *     defaults={"_locale"="en"},
     *     requirements={"_locale": "en|es"})
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanyAction(Request $request, $id = 0)
    {
        // Get language.
        $locale = $request->getLocale();


        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find($id);

        if (!isset($company)) {
            throw new NotFoundHttpException("There is no company whose id is: $id");
        }

        return $this->render('company/getcompany.html.twig', [
            "locale"  => $locale,
            "company" => $company,
        ]);
    }

    /**
     * @Route("/getname/{name}", name="get_name_company")
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanyByNameAction($name)
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        /** @var Company $company */
        // findOneBy{attribute name in CamelCase}->()
        $company = $repository->findOneByName($name);

        if (!isset($company)) {
            throw new NotFoundHttpException("There is no company whose name is: $name");
        }

        return new Response("Company with name $name has a city '{$company->getCity()}' 
            and there are '{$company->getEmployeesNumber()}' employees.");
    }

    /**
     * @Route("/update/{id}/{city}", name="update_company")
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
            throw $this->createNotFoundException("Check if the id and name values are valid.");
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

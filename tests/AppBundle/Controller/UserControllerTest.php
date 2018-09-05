<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    public function testUsers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/');
        $link = $crawler->filter('a:contains("Login")')->link();

        $this->assertGreaterThan(
            0,
            $crawler->filter('h2:contains("Hello world!")')->count()
        );

        $client->click($link);

        $this->assertRegExp('/\/login$/', $client->getRequest()->getUri());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    private function createUser(): User
    {
        $username = 'user';
        $email = 'email@email.com';
        $password = 'pass123';

        return (new User())
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword($password);
    }

    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/register');

        $user = $this->createUser();

        $repository = $this->entityManager->getRepository(User::class);

        $userDoctrine = $repository->findOneByUsername($user->getUsername());

        // User exists in DB?
        if (isset($userDoctrine)) {
            self::assertEquals($user->getUsername(), $userDoctrine->getUsername());

            return;
        }

        // Fill in the form with the user data.
        $btCrawler = $crawler->selectButton('Submit');
        $form = $btCrawler->form([
            'appbundle_user[username]'              => $user->getUsername(),
            'appbundle_user[email]'                 => $user->getEmail(),
            'appbundle_user[plainPassword][first]'  => $user->getPassword(),
            'appbundle_user[plainPassword][second]' => $user->getPassword(),
            'appbundle_user[termsAccepted]'         => true,
        ]);
        $client->submit($form);

        $this->assertNotNull($repository->findOneByUsername($user->getUsername()),
            'Error - The user has not been created. BD problem?');
        $this->assertEquals(true, $client->getResponse()->isRedirect('/users/login'));

    }

    public function testRegisterWrong()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/register');

        $user = $this->createUser();

        // Fill in the form with the user data.
        $btCrawler = $crawler->selectButton('Submit');
        $form = $btCrawler->form([
            'appbundle_user[username]'              => '123',
            'appbundle_user[email]'                 => $user->getEmail(),
            'appbundle_user[plainPassword][first]'  => $user->getPassword(),
            'appbundle_user[plainPassword][second]' => $user->getPassword(),
            'appbundle_user[termsAccepted]'         => false,
        ]);
        $crawler2 = $client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler2->filter('li:contains("Username must be at least 4 characters long")')->count()
        );
    }

}

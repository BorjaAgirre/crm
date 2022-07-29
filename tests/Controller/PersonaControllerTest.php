<?php

namespace App\Test\Controller;

use App\Entity\Persona;
use App\Repository\PersonaRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PersonaRepository $repository;
    private string $path = '/persona/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Persona::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Persona index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'persona[Nombre]' => 'Testing',
            'persona[Apellidos]' => 'Testing',
            'persona[Apodo]' => 'Testing',
            'persona[Nacimiento]' => 'Testing',
            'persona[Comentarios]' => 'Testing',
            'persona[Genero]' => 'Testing',
        ]);

        self::assertResponseRedirects('/persona/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Persona();
        $fixture->setNombre('My Title');
        $fixture->setApellidos('My Title');
        $fixture->setApodo('My Title');
        $fixture->setNacimiento('My Title');
        $fixture->setComentarios('My Title');
        $fixture->setGenero('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Persona');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Persona();
        $fixture->setNombre('My Title');
        $fixture->setApellidos('My Title');
        $fixture->setApodo('My Title');
        $fixture->setNacimiento('My Title');
        $fixture->setComentarios('My Title');
        $fixture->setGenero('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'persona[Nombre]' => 'Something New',
            'persona[Apellidos]' => 'Something New',
            'persona[Apodo]' => 'Something New',
            'persona[Nacimiento]' => 'Something New',
            'persona[Comentarios]' => 'Something New',
            'persona[Genero]' => 'Something New',
        ]);

        self::assertResponseRedirects('/persona/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getApellidos());
        self::assertSame('Something New', $fixture[0]->getApodo());
        self::assertSame('Something New', $fixture[0]->getNacimiento());
        self::assertSame('Something New', $fixture[0]->getComentarios());
        self::assertSame('Something New', $fixture[0]->getGenero());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Persona();
        $fixture->setNombre('My Title');
        $fixture->setApellidos('My Title');
        $fixture->setApodo('My Title');
        $fixture->setNacimiento('My Title');
        $fixture->setComentarios('My Title');
        $fixture->setGenero('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/persona/');
    }
}

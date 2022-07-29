<?php

namespace App\Test\Controller;

use App\Entity\Relacionpersona;
use App\Repository\RelacionpersonaRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RelacionpersonaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RelacionpersonaRepository $repository;
    private string $path = '/relacionpersona/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Relacionpersona::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Relacionpersona index');

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
            'relacionpersona[Persona1]' => 'Testing',
            'relacionpersona[Persona2]' => 'Testing',
            'relacionpersona[Tiporelacion]' => 'Testing',
        ]);

        self::assertResponseRedirects('/relacionpersona/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Relacionpersona();
        $fixture->setPersona1('My Title');
        $fixture->setPersona2('My Title');
        $fixture->setTiporelacion('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Relacionpersona');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Relacionpersona();
        $fixture->setPersona1('My Title');
        $fixture->setPersona2('My Title');
        $fixture->setTiporelacion('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'relacionpersona[Persona1]' => 'Something New',
            'relacionpersona[Persona2]' => 'Something New',
            'relacionpersona[Tiporelacion]' => 'Something New',
        ]);

        self::assertResponseRedirects('/relacionpersona/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPersona1());
        self::assertSame('Something New', $fixture[0]->getPersona2());
        self::assertSame('Something New', $fixture[0]->getTiporelacion());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Relacionpersona();
        $fixture->setPersona1('My Title');
        $fixture->setPersona2('My Title');
        $fixture->setTiporelacion('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/relacionpersona/');
    }
}

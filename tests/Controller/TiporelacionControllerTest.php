<?php

namespace App\Test\Controller;

use App\Entity\Tiporelacion;
use App\Repository\TiporelacionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TiporelacionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TiporelacionRepository $repository;
    private string $path = '/tiporelacion/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Tiporelacion::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Tiporelacion index');

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
            'tiporelacion[Tipo]' => 'Testing',
            'tiporelacion[Tipocontrario]' => 'Testing',
        ]);

        self::assertResponseRedirects('/tiporelacion/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tiporelacion();
        $fixture->setTipo('My Title');
        $fixture->setTipocontrario('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Tiporelacion');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Tiporelacion();
        $fixture->setTipo('My Title');
        $fixture->setTipocontrario('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'tiporelacion[Tipo]' => 'Something New',
            'tiporelacion[Tipocontrario]' => 'Something New',
        ]);

        self::assertResponseRedirects('/tiporelacion/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTipo());
        self::assertSame('Something New', $fixture[0]->getTipocontrario());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Tiporelacion();
        $fixture->setTipo('My Title');
        $fixture->setTipocontrario('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/tiporelacion/');
    }
}

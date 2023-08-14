<?php

namespace App\Test\Controller;

use App\Entity\OrderRecord;
use App\Repository\OrderRecordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderRecordControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OrderRecordRepository $repository;
    private string $path = '/order/record/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(OrderRecord::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OrderRecord index');

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
            'order_record[productName]' => 'Testing',
            'order_record[vat]' => 'Testing',
            'order_record[priceExcl]' => 'Testing',
            'order_record[priceIncl]' => 'Testing',
            'order_record[addedTo]' => 'Testing',
        ]);

        self::assertResponseRedirects('/order/record/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new OrderRecord();
        $fixture->setProductName('My Title');
        $fixture->setVat('My Title');
        $fixture->setPriceExcl('My Title');
        $fixture->setPriceIncl('My Title');
        $fixture->setAddedTo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('OrderRecord');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new OrderRecord();
        $fixture->setProductName('My Title');
        $fixture->setVat('My Title');
        $fixture->setPriceExcl('My Title');
        $fixture->setPriceIncl('My Title');
        $fixture->setAddedTo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'order_record[productName]' => 'Something New',
            'order_record[vat]' => 'Something New',
            'order_record[priceExcl]' => 'Something New',
            'order_record[priceIncl]' => 'Something New',
            'order_record[addedTo]' => 'Something New',
        ]);

        self::assertResponseRedirects('/order/record/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getProductName());
        self::assertSame('Something New', $fixture[0]->getVat());
        self::assertSame('Something New', $fixture[0]->getPriceExcl());
        self::assertSame('Something New', $fixture[0]->getPriceIncl());
        self::assertSame('Something New', $fixture[0]->getAddedTo());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new OrderRecord();
        $fixture->setProductName('My Title');
        $fixture->setVat('My Title');
        $fixture->setPriceExcl('My Title');
        $fixture->setPriceIncl('My Title');
        $fixture->setAddedTo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/order/record/');
    }
}

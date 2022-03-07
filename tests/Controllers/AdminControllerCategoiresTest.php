<?php

namespace App\Test\Controllers;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerCategoiresTest extends WebTestCase
{
    public function setUp():void{
        parent::setUp();
        $this->client= static::createClient();
        $this->client->disableReboot();

        $this->em= $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }
    public function tearDown():void{
        parent::tearDown();
        $this->em->rollback();;
        $this->em->close();
        $this->em= null;
    }
    public function testTextOnPage(): void
    {

        $crawler = $this->client->request('GET', '/admin/categories');
        
        $this->assertSame('Categories list',$crawler->filter('h2')->text());
        // die($this->client->getResponse()->getContent());
        // $this->assertContains("Electronics",$this->client->getResponse()->getContent());
    }

    public function testNumberOfItems(){
        $crawler = $this->client->request('GET', '/admin/categories');
        $this->assertCount(18,$crawler->filter('option'));
    }

    public function testNewCategory(){
        $crawler = $this->client->request('GET', '/admin/categories');

        $form=$crawler->selectButton('Add')->form([
            'category[parent]'=>1,
            'category[name]'=> "Other Device"
        ]);

        $this->client->submit($form);

        $category=$this->em->getRepository(Category::class)->findOneBy([
            'name'=> "Other Device"
        ]);

        $this->assertNotNull($category);

        $this->assertSame('Other Device',$category->getName());
    }

}
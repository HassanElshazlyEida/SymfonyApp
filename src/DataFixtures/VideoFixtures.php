<?php

namespace App\DataFixtures;

use App\Entity\Video;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VideoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->VideoData() as [$title, $path, $category_id]){
            $duration = random_int (10,300);
            $category = $manager->getRepository(Category::class)->find($category_id);
            $video = new Video();
            $video->setTitle($title);
            $video->setPath('https://player.vimeo.com/video/'.$path);
            $video->setCategory($category);
            $video->setDuration($duration);
            $manager->persist($video);
        }
        $manager->flush();
  
    }

    private function VideoData(){
        return [
            ['Movies 1',223123123,1],
            ['Movies 2',223123123,5],
            ['Movies 3',223123123,2],
            ['Movies 4',223123123,6],
            ['Movies 5',223123123,3],
        ];
    }
}

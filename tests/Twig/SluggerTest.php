<?php
namespace App\Tests\Twig;

use App\Twig\AppExtension;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    /** 
     * @dataProvider Slugs
    */

    public function testSlugify(string $string,string $slug): void
    {
        $slugger = new AppExtension;

        $this->assertSame($slug,$slugger->slugify($string));
    }

    public function Slugs(){
        return [
            ['Lorem Ipsum', 'lorem-ipsum'],
            ['Lorem Ipsum', 'lorem-ipsum']
        ];
    }
}

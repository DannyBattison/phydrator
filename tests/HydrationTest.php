<?php

use PHPUnit\Framework\TestCase;
use PHydrator\PHydrator;
use PHydrator\Tests\Resource\Entity\Cat;
use PHydrator\Tests\Resource\Entity\Person;
use PHydrator\Tests\Resource\Hydrator\CatHydrator;
use PHydrator\Tests\Resource\Hydrator\PersonHydrator;

final class HydrationTest extends TestCase
{
    protected PHydrator $pHydrator;

    public function setUp(): void
    {
        $this->pHydrator = new PHydrator();
        $this->pHydrator->registerHydrator(PersonHydrator::class);
        $this->pHydrator->registerHydrator(CatHydrator::class);
    }

    public function testHydrateOne()
    {
        $bones = $this->pHydrator->hydrateOne(Cat::class, ['name' => 'Bones']);
        self::assertInstanceOf(Cat::class, $bones);
    }

    public function testHydrateMany()
    {
        $danny = $this->pHydrator->hydrateOne(Person::class, [
            'name' => 'Danny',
            'cats' => [
                ['name' => 'Astor'],
                ['name' => 'Azazel'],
                ['name' => 'Gary Laser Eyes'],
                ['name' => 'Ghost'],
                ['name' => 'Racoon'],
                ['name' => 'Tabby'],
            ]
        ]);

        self::assertInstanceOf(Person::class, $danny);
        self::assertCount(6, $danny->cats);
        foreach ($danny->cats as $cat) {
            self::assertInstanceOf(Cat::class, $cat);
        }
    }
}
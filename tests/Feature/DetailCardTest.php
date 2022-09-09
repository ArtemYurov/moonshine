<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Tests\Feature;

use Leeto\MoonShine\Fields\Fields;
use Leeto\MoonShine\Tests\TestCase;
use Leeto\MoonShine\ValueEntities\ModelValueEntityBuilder;
use Leeto\MoonShine\ViewComponents\DetailCard\DetailCard;

class DetailCardTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_properties(): void
    {
        $card = DetailCard::make(
            $this->testResource()->fieldsCollection()->detailFields(),
            (new ModelValueEntityBuilder($this->adminUser()))->build()
        );

        $this->assertInstanceOf(Fields::class, $card->fields());
    }
}

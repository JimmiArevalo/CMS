<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_published_scope_exists(): void
    {
        $this->assertNotNull(News::published());
    }
}

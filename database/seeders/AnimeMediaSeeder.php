<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\Media;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class AnimeMediaSeeder extends Seeder
{
    public function run(): void
    {
        $coversDir = storage_path('app/public/covers');
        $newsDir   = storage_path('app/public/news');

        File::ensureDirectoryExists($coversDir);
        File::ensureDirectoryExists($newsDir);

        // ═══════════════════════════════════════════════════════════
        // 1. CARÁTULAS DE ANIMES (28 títulos con pósters oficiales)
        // ═══════════════════════════════════════════════════════════
        $animeCovers = [
            'jujutsu-kaisen'                  => 'https://cdn.myanimelist.net/images/anime/1171/109222.jpg',
            'one-piece'                       => 'https://cdn.myanimelist.net/images/anime/1244/138851.jpg',
            'dandadan'                        => 'https://cdn.myanimelist.net/images/anime/1600/144715.jpg',
            'oshi-no-ko'                      => 'https://cdn.myanimelist.net/images/anime/1812/134736.jpg',
            'mushoku-tensei'                  => 'https://cdn.myanimelist.net/images/anime/1530/117776.jpg',
            'bleach-thousand-year-blood-war'  => 'https://cdn.myanimelist.net/images/anime/1764/126627.jpg',
            'demon-slayer'                    => 'https://cdn.myanimelist.net/images/anime/1286/99889.jpg',
            'attack-on-titan'                 => 'https://cdn.myanimelist.net/images/anime/10/47347.jpg',
            'chainsaw-man'                    => 'https://cdn.myanimelist.net/images/anime/1806/126216.jpg',
            'spy-x-family'                    => 'https://cdn.myanimelist.net/images/anime/1441/122795.jpg',
            'vinland-saga'                    => 'https://cdn.myanimelist.net/images/anime/1500/103005.jpg',
            'bocchi-the-rock'                 => 'https://cdn.myanimelist.net/images/anime/1448/127956.jpg',
            'mob-psycho-100'                  => 'https://cdn.myanimelist.net/images/anime/8/80356.jpg',
            'my-hero-academia'                => 'https://cdn.myanimelist.net/images/anime/10/78745.jpg',
            'fullmetal-alchemist-brotherhood' => 'https://cdn.myanimelist.net/images/anime/1208/94745.jpg',
            'death-note'                      => 'https://cdn.myanimelist.net/images/anime/1079/138100.jpg',
            'cowboy-bebop'                    => 'https://cdn.myanimelist.net/images/anime/4/19644.jpg',
            'neon-genesis-evangelion'         => 'https://cdn.myanimelist.net/images/anime/1314/108941.jpg',
            'steins-gate'                     => 'https://cdn.myanimelist.net/images/anime/1935/127974.jpg',
            'hunter-x-hunter-2011'            => 'https://cdn.myanimelist.net/images/anime/1337/99013.jpg',
            'code-geass'                      => 'https://cdn.myanimelist.net/images/anime/1032/135088.jpg',
            'dragon-ball-z'                   => 'https://cdn.myanimelist.net/images/anime/1607/117271.jpg',
            'naruto-shippuden'                => 'https://cdn.myanimelist.net/images/anime/1565/111305.jpg',
            'your-name'                       => 'https://cdn.myanimelist.net/images/anime/1935/127974.jpg',
            'el-viaje-de-chihiro'             => 'https://cdn.myanimelist.net/images/anime/9/26493.jpg',
            'hellsing-ultimate'               => 'https://cdn.myanimelist.net/images/anime/6/73245.jpg',
            'chainsaw-man-reze-arc'           => 'https://cdn.myanimelist.net/images/anime/1258/140926.jpg',
            'solo-leveling-season-2'          => 'https://cdn.myanimelist.net/images/anime/1839/142340.jpg',
            'frieren'                         => 'https://cdn.myanimelist.net/images/anime/1015/138075.jpg',
            'cyberpunk-edgerunners'           => 'https://cdn.myanimelist.net/images/anime/1817/127339.jpg',
            'haikyuu'                         => 'https://cdn.myanimelist.net/images/anime/7/76014.jpg',
            'blue-lock'                       => 'https://cdn.myanimelist.net/images/anime/1258/126926.jpg',
            'kuroko-no-basket'                => 'https://cdn.myanimelist.net/images/anime/11/50453.jpg',
            'tokyo-ghoul'                     => 'https://cdn.myanimelist.net/images/anime/5/64449.jpg',
            'black-clover'                    => 'https://cdn.myanimelist.net/images/anime/2/88336.jpg',
            'kaguya-sama-love-is-war'         => 'https://cdn.myanimelist.net/images/anime/3/90343.jpg',
            're-zero'                         => 'https://cdn.myanimelist.net/images/anime/1522/128039.jpg',
            'overlord'                        => 'https://cdn.myanimelist.net/images/anime/7/88019.jpg',
            'konosuba'                        => 'https://cdn.myanimelist.net/images/anime/8/77831.jpg',
            'tensei-shitara-slime-datta-ken'  => 'https://cdn.myanimelist.net/images/anime/1090/96181.jpg',
            'made-in-abyss'                   => 'https://cdn.myanimelist.net/images/anime/6/86733.jpg',
            'gurren-lagann'                   => 'https://cdn.myanimelist.net/images/anime/4/5123.jpg',
            'jojos-bizarre-adventure'         => 'https://cdn.myanimelist.net/images/anime/3/40409.jpg',
            'berserk-1997'                    => 'https://cdn.myanimelist.net/images/anime/9/51321.jpg',
            'monster'                         => 'https://cdn.myanimelist.net/images/anime/10/18740.jpg',
            'fate-zero'                       => 'https://cdn.myanimelist.net/images/anime/2/73249.jpg',
            'psycho-pass'                     => 'https://cdn.myanimelist.net/images/anime/5/42603.jpg',
            'akira'                           => 'https://cdn.myanimelist.net/images/anime/8/19531.jpg',
            'la-princesa-mononoke'            => 'https://cdn.myanimelist.net/images/anime/7/7581.jpg',
            'suzume'                          => 'https://cdn.myanimelist.net/images/anime/1711/129388.jpg',
            'a-silent-voice'                  => 'https://cdn.myanimelist.net/images/anime/1122/96481.jpg',
            'kaiju-no-8'                      => 'https://cdn.myanimelist.net/images/anime/1817/141351.jpg',
            'wind-breaker'                    => 'https://cdn.myanimelist.net/images/anime/1594/142342.jpg',
        ];

        foreach ($animeCovers as $slug => $imageUrl) {
            $anime = Anime::where('slug', $slug)->first();
            if (! $anime) {
                continue;
            }

            $localFilename = "{$slug}.jpg";
            $localPath     = "{$coversDir}/{$localFilename}";
            $relativePath  = "covers/{$localFilename}";

            if (! File::exists($localPath) || File::size($localPath) < 1500) {
                try {
                    $response = Http::withoutVerifying()->timeout(15)->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    ])->get($imageUrl);

                    if ($response->successful() && strlen($response->body()) > 1000) {
                        File::put($localPath, $response->body());
                    } else {
                        $this->createFallbackImage($localPath, $anime->title, '#f47521');
                    }
                } catch (\Throwable $e) {
                    $this->createFallbackImage($localPath, $anime->title, '#f47521');
                }
            }

            $size = File::exists($localPath) ? File::size($localPath) : 1024;

            $media = Media::updateOrCreate(
                ['path' => $relativePath],
                [
                    'name'      => $anime->title . ' Póster',
                    'mime_type' => 'image/jpeg',
                    'size'      => $size,
                    'active'    => true,
                ]
            );

            $anime->update(['media_id' => $media->id]);
        }

        // ═══════════════════════════════════════════════════════════
        // 2. IMÁGENES DE NOTICIAS (14 artículos)
        // ═══════════════════════════════════════════════════════════
        $newsList = News::with('anime')->get();

        foreach ($newsList as $index => $item) {
            $localFilename = "{$item->slug}.jpg";
            $localPath     = "{$newsDir}/{$localFilename}";
            $relativePath  = "news/{$localFilename}";

            // Si la noticia tiene un anime asociado y ese anime ya tiene póster, usamos la imagen real
            if (! File::exists($localPath) || File::size($localPath) < 1500) {
                $animeSlug = $item->anime?->slug;
                if ($animeSlug && isset($animeCovers[$animeSlug])) {
                    $coverSource = "{$coversDir}/{$animeSlug}.jpg";
                    if (File::exists($coverSource) && File::size($coverSource) > 1500) {
                        File::copy($coverSource, $localPath, true);
                    }
                }

                if (! File::exists($localPath) || File::size($localPath) < 1500) {
                    $this->createFallbackImage($localPath, $item->title, '#6366f1');
                }
            }

            $size = File::exists($localPath) ? File::size($localPath) : 1024;

            $media = Media::updateOrCreate(
                ['path' => $relativePath],
                [
                    'name'      => 'Noticia: ' . $item->title,
                    'mime_type' => 'image/jpeg',
                    'size'      => $size,
                    'active'    => true,
                ]
            );

            $item->update(['media_id' => $media->id]);
        }
    }

    private function createFallbackImage(string $path, string $text, string $bgColor): void
    {
        $shortText = mb_strimwidth($text, 0, 24, '...');
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="850" viewBox="0 0 600 850">
  <defs>
    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#181a20" />
      <stop offset="100%" stop-color="#0f1115" />
    </linearGradient>
  </defs>
  <rect width="600" height="850" fill="url(#grad)" />
  <circle cx="300" cy="360" r="120" fill="{$bgColor}" opacity="0.15" />
  <text x="300" y="380" font-family="Arial, sans-serif" font-size="72" text-anchor="middle" fill="{$bgColor}">🎬</text>
  <text x="300" y="520" font-family="Arial, sans-serif" font-size="28" font-weight="bold" text-anchor="middle" fill="#ffffff">{$shortText}</text>
  <text x="300" y="560" font-family="Arial, sans-serif" font-size="16" text-anchor="middle" fill="#a0a5b5">ANIMEVERSE PORTAL</text>
</svg>
SVG;
        File::put($path, $svg);
    }
}

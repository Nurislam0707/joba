<?php
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'slug' => 'site-launch',
                'published_at' => now()->subDays(2),
                'is_published' => true,
                'translations' => [
                    'kk' => ['title' => 'Сайт ашылды', 'excerpt' => 'Біздің жаңа сайт іске қосылды', 'body' => 'Толық қазақша мәтін...'],
                    'ru' => ['title' => 'Запуск сайта', 'excerpt' => 'Наш новый сайт запущен', 'body' => 'Полный текст на русском...'],
                    'en' => ['title' => 'Site Launched', 'excerpt' => 'Our new site is live', 'body' => 'Full English content...'],
                ],
            ],
            // қосымша 2–4 жаңалық
        ];

        foreach ($items as $data) {
            $news = News::create([
                'slug' => $data['slug'],
                'published_at' => $data['published_at'],
                'is_published' => $data['is_published'],
            ]);

            foreach ($data['translations'] as $locale => $t) {
                $news->translations()->create(array_merge($t, ['locale' => $locale]));
            }
        }
    }
}

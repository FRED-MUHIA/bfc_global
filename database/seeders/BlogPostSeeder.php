<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('site.blog_posts', []) as $post) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'category' => $post['category'],
                    'image' => $post['image'],
                    'author' => $post['author'],
                    'published_at' => $post['published_at'],
                    'date_label' => $post['date_label'],
                    'read_time' => $post['read_time'],
                    'content' => $post['content'],
                ]
            );
        }
    }
}

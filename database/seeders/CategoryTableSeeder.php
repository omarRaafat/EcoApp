<?php
    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\Category;

    class CategoryTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $main = Category::create([
                'level' => 1,
                'is_active' => 1,
                'name' => [
                    'en' => 'main categoery',
                    'ar' => 'القسم الرئيسي'
                ],
                'slug' => [
                    'en' => 'main_category_slug',
                    'ar' => 'القسم_الرئيسي'
                ]
            ]);
            $sub = Category::create([
                'level' => 2,
                'parent_id' => $main->id,
                'is_active' => 1,
                'name' => [
                    'en' => 'Sub categoery',
                    'ar' => 'القسم الفرعي اﻷول'
                ],
                'slug' => [
                    'en' => 'sub_category_slug',
                    'ar' => 'القسم_الفرعغي_اﻷول'
                ]
            ]);
            $finalSub = Category::create([
                'level' => 3,
                'parent_id' => $sub->id,
                'is_active' => 1,
                'name' => [
                    'en' => 'Final Sub categoery',
                    'ar' => 'القسم الفرعي اﻷخير'
                ],
                'slug' => [
                    'en' => 'final_sub_category_slug',
                    'ar' => 'القسم_الفرعغي_اﻷخير'
                ]
            ]);
        }
    }

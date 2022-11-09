<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


            $user = new Category();
            $user->title="Dress";

            $user->save();

            $user2 = new Category();
            $user2->title="Shirts";

            $user2->save();

            $user3 = new Category();
            $user3->title="Jeans";

            $user3->save();


            $user4 = new Category();
            $user4->title="Swimwear";

            $user4->save();



            $user5= new Category();
            $user5->title="Jacket";

            $user5->save();

            $user6= new Category();
            $user6->title="Shoes";

            $user6->save();

    }
}

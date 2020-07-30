<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $id_arr;
    protected $shuffle_id;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        //create 10 users
        $user = factory(App\User::class,4)->create();
        $this->id_arr = Arr::pluck($user , 'id'); // get user id array

        // create 2 book for each user
        $user->each(function ($user) {
            $book = $user->books()->saveMany(factory(App\Book::class,2)->make());
            $this->shuffle_id = Arr::shuffle($this->id_arr);
            $book->each(function ($book) {
                $book_id = $book->id;
                for($i=0; $i<3; $i++) {
                    $user_id = $this->shuffle_id[$i]; // get id of first 3 of suffle_id array
                    factory(App\Rating::class)->create(['user_id' => $user_id, 'book_id' => $book_id]);
                }
            });

        });
    } 
}

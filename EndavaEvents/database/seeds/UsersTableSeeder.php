<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($u) {

            $u->profile()->save(factory(App\Profile::class)->create([
                'user_id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'photo' => asset("storage/unknow.jpg"),
            ]));

        });

    }

}

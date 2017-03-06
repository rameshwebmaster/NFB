<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function ($u) {
            $bloodTypes = ['A+' , 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            $u->subscription()->save(factory(App\Subscription::class)->make());
            $u->addOrUpdateMeta('blood_type', $bloodTypes[mt_rand(0, 7)]);
            $u->addOrUpdateMeta('instagram_id', $u->username);
            //$u->healthStatuses()->save(factory(App\HealthStatus::class)->make());
        });
    }
}

<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin User',
               'email'=>'admin@itsolutionstuff.com',
               'password'=> bcrypt('123456'),
               'type'=>1,
               'phone_number'=>'083820023368',
               'gender'=>'laki-laki',
               'address'=>'gamez',
               'created_at' => now(),
              'updated_at' => now(),
            ],
            [
               'name'=>'Manager User',
               'email'=>'manager@itsolutionstuff.com',
               'password'=> bcrypt('123456'),
               'type'=> 2,
               'phone_number'=>'083820023368',
               'gender'=>'laki-laki',
               'address'=>'gamez',
            ],
            [
               'name'=>'User',
               'email'=>'user@itsolutionstuff.com',
               'password'=> bcrypt('123456'),
               'type'=>0,
               'phone_number'=>'083820023368',
               'gender'=>'laki-laki',
               'address'=>'gamez',
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
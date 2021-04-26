<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User;
        $user->name = "Admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt('admin');
        $user->is_admin = true;
        $user->save();
    }
}
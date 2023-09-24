<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Models\Presentation;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $names = ['whisky', 'vodka', 'ron', 'aguardiente', 'vino'];
        foreach($names as $name){
            $type = new Type;
            $type->name = $name;
            $type->save();
        }

        $contents = [200, 375, 750, 1000, 1500];
        foreach($contents as $content){
            $presentation = new Presentation;
            $presentation->content = $content;
            $presentation->save();
        }

        // Registrar Usuario
        $name = 'Fernando Joel Mero Travez';
        $email = 'sd.kettei@gmail.com';
        $password = '12345678';

        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password),]);

        event(new Registered($user));
    }
}

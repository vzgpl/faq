<?php

namespace Database\Seeders;

use App\Models\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $readers = config('admin-data.readers');
        foreach ($readers as $reader) {
            if (!Reader::where('login', $reader['login'])->exists()) {
                Reader::factory()->create([
                    'name' => $reader['name'],
                    'login' => $reader['login'],
                    'password' => Hash::make($reader['password']),
                    'token' => Str::random(60),
                    'remember_token' => Str::random(60),
                ]);
                $this->command->info('Читатель ' . $reader['name'] . ':' . $reader['login'] . '\\' . $reader['password']);
            } else {
                $this->command->info('Читатель ' . $reader['name'] . ':' . $reader['login'] . '\\*****');
            }
        }
    }
}
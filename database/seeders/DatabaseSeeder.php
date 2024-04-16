<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Dependency;
use App\Models\Office;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Role::factory()->create(['name' => 'superadmin', 'guard_name' => 'api' ]);
        Role::factory()->create(['name' => 'admin_oficina', 'guard_name' => 'api' ]);
        Role::factory()->create(['name' => 'kiosko', 'guard_name' => 'api' ]);
        Role::factory()->create(['name' => 'tramitador', 'guard_name' => 'api' ]);
        Role::factory()->create(['name' => 'turnera', 'guard_name' => 'api' ]);
//
        User::factory(50)->create();
        Dependency::factory(50)->create();
        Office::factory(50)->create();
//        Transaction::factory(50)->create();
        Transaction::factory()->create(['name' => 'Nacimiento']);
        Transaction::factory()->create(['name' => 'Cambio de domicilio']);
        Transaction::factory()->create(['name' => 'Cambio de email']);
        Transaction::factory()->create(['name' => 'Alta de curp']);
        Transaction::factory()->create(['name' => 'Defuncion']);
        Appointment::factory(50)->create();
    }
}

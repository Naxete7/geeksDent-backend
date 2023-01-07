<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Doctor;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user= new User;
        $user->name= 'Admin';
        $user->surname='Admin';
        $user->email='admin@admin.com';
        $user->password= bcrypt('Admin1234');
        $user->role='1';

        $user->save();

        $doctor = new Doctor;
        $doctor->name = 'Juan Pedro Quiles';
        $doctor->especialidad = 'Endodoncias';

        $doctor->save();
        $doctor = new Doctor;
        $doctor->name = 'Faustino Sala';
        $doctor->especialidad = 'Cirujano/Implantes';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Maria Castillo';
        $doctor->especialidad = 'Odontopediatra';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Javier Flor';
        $doctor->especialidad = 'Ortodoncista';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Olivia García';
        $doctor->especialidad = 'Estética dental/Prótesis';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Maite Catalá';
        $doctor->especialidad = 'Periodoncista';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Ana Campillo';
        $doctor->especialidad = 'Higienista';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Susana García';
        $doctor->especialidad = 'Higienista';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Ethel Ferrer';
        $doctor->especialidad = 'Recepción';

        $doctor->save();
    }
}

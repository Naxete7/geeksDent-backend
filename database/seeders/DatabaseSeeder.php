<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Treatment;

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
        $user->active='1';
        $user->role='1';

        $user->save();

        $user = new User;
        $user->name = 'Nacho';
        $user->surname = 'Garcia';
        $user->email = 'nacho@nacho.com';
        $user->password = bcrypt('Nacho1234');
        $user->phone='666666666';
        $user->active = '1';
        $user->role = '2';

        $user->save();


        $user = new User;
        $user->name = 'Olivia';
        $user->surname = 'Garcia';
        $user->email = 'olivia@olivia.com';
        $user->password = bcrypt('Olivia1234');
        $user->phone = '666555444';
        $user->active = '1';
        $user->role = '2';

        $user->save();

        $user = new User;
        $user->name = 'Maite';
        $user->surname = 'Catalá';
        $user->email = 'maite@maite.com';
        $user->password = bcrypt('Maite1234');
        $user->phone = '666555444';
        $user->active = '1';
        $user->role = '2';

        $user->save();

        $doctor = new Doctor;
        $doctor->name = 'Juan Pedro Quiles';
        $doctor->especialidad = 'Endodoncias';
        $doctor->active='1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Faustino Sala';
        $doctor->especialidad = 'Cirujano/Implantes';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Maria Castillo';
        $doctor->especialidad = 'Odontopediatra';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Javier Flors';
        $doctor->especialidad = 'Ortodoncista';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Olivia García';
        $doctor->especialidad = 'Estética dental/Prótesis';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Maite Catalá';
        $doctor->especialidad = 'Periodoncista';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Ana Campillo';
        $doctor->especialidad = 'Higienista';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Susana García';
        $doctor->especialidad = 'Higienista';
        $doctor->active = '1';

        $doctor->save();

        $doctor = new Doctor;
        $doctor->name = 'Ethel Ferrer';
        $doctor->especialidad = 'Recepción';
        $doctor->active = '1';

        $doctor->save();

        $treatment=new Treatment;
        $treatment->name='Endodoncia';
        $treatment->active='1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Estética dental';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Implantes';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Odontopediatria';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Ortodoncia';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Invisalign';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Periodoncia';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Prótesis';
        $treatment->active = '1';
        $treatment->save();

        $treatment = new Treatment;
        $treatment->name = 'Higiene dental';
        $treatment->active = '1';
        $treatment->save();

        $appointment= new Appointment;
        $appointment->date= '2023-01-19 11:35:00';
        $appointment->reason='caries ';
        $appointment->usersId='2';
        $appointment->doctorsId='3';
        $appointment->treatmentsId='5';
        $appointment->save();

        $appointment = new Appointment;
        $appointment->date = '2023-01-26 14:45:00';
        $appointment->reason = 'flemon';
        $appointment->usersId = '2';
        $appointment->doctorsId = '1';
        $appointment->treatmentsId = '4';
        $appointment->save();

        $appointment = new Appointment;
        $appointment->date = '2023-01-31 19:15:00';
        $appointment->reason = 'limpieza ';
        $appointment->usersId = '2';
        $appointment->doctorsId = '7';
        $appointment->treatmentsId = '6';
        $appointment->save();
    }
}

<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Services\ParkingApiService;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        // === ADMIN ===
        $admin = User::firstOrCreate(
            ['email' => '[email protected]'],
            [
                'name'     => 'Admin SmartParking',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // === GEBRUIKERS ===
        $users = [
            ['name' => 'Sjerd de Kooning',  'email' => 'sjerd@smartparking.nl'],
            ['name' => 'Big Chungus',       'email' => 'bigchungus@smartparking.nl'],
            ['name' => 'Adem Karapinar',    'email' => 'adem@smartparking.nl'],
            ['name' => 'Testgebruiker',     'email' => 'user@smartparking.nl'],
        ];

        $createdUsers = [];
        foreach ($users as $userData) {
            $createdUsers[] = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name'     => $userData['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'user',
                ]
            );
        }

        // === API PARKEERPLAATSEN ===
        $parkingService = new ParkingApiService();
        $spots = $parkingService->getRotterdamParkingSpots();
        
        if ($spots->isEmpty()) {
            $this->command->warn('Geen parkeerplaatsen gevonden via de API, seeding van reserveringen overgeslagen.');
            return;
        }

        // === RESERVERINGEN ===
        $betaalMethoden = ['ideal', 'paypal', 'tikkie', 'maestro'];

        foreach ($createdUsers as $user) {
            Reservation::where('user_id', $user->id)->delete(); // Clean up old seeds
            
            for ($r = 0; $r < rand(1, 3); $r++) {
                $spot = $spots->random();
                $datum = now()->addDays(rand(-5, 10))->format('Y-m-d');
                $startUur = rand(7, 17);
                $eindUur  = $startUur + rand(1, 4);
                $uren     = $eindUur - $startUur;
                $prijs    = $uren * ($spot['price_per_hour'] ?? 2.0);

                Reservation::create([
                    'user_id'             => $user->id,
                    'external_parking_id' => $spot['id'],
                    'datum'               => $datum,
                    'start_tijd'          => sprintf('%02d:00', $startUur),
                    'eind_tijd'           => sprintf('%02d:00', $eindUur),
                    'voertuig'            => ['Auto','Motor','Fiets','Elektrisch'][rand(0,3)],
                    'kenteken'            => strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOP'), 0, 2)) . '-' . rand(100,999) . '-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOP'), 0, 2)),
                    'totaal_prijs'        => $prijs,
                    'betaald'             => true,
                    'betaal_methode'      => $betaalMethoden[array_rand($betaalMethoden)],
                    'status'              => ['actief','voltooid'][rand(0,1)],
                ]);
            }
        }
    }
}

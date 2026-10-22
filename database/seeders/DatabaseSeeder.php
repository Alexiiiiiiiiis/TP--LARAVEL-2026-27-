<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Données de démonstration : 2 agences, 1 manager, 2 caissiers, 3 clients
// Identifiants de test (mot de passe = partie de l'email avant le @) :
//   manager  : manager@mcbbank.com  / manager
//   caissier : cashier@mcbbank.com  / cashier   (et cashier2@mcbbank.com / cashier2)
//   clients  : ali@mcbbank.com      / ali       (et fayyaz@mcbbank.com / fayyaz, sara@mcbbank.com / sara)
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Agences
        $dgk = $this->branch('Dera Ghazi Khan', '100101');
        $lahore = $this->branch('Lahore', '100102');

        // Personnel
        $this->staff('manager@mcbbank.com', 'manager', 'manager');
        $this->staff('cashier@mcbbank.com', 'cashier', 'cashier');
        $this->staff('cashier2@mcbbank.com', 'cashier2', 'cashier');

        // Clients (le solde de départ est enregistré comme un dépôt)
        $ali = $this->account('Ali khan', 'ali@mcbbank.com', 'ali', '10054777', 'saving', 16200, $dgk, 'hillary.jpg');
        $fayyaz = $this->account('Fayyaz Khan', 'fayyaz@mcbbank.com', 'fayyaz', '1513410739', 'saving', 234034, $dgk, 'kamal.png');
        $this->account('Sara Ahmed', 'sara@mcbbank.com', 'sara', '1513410837', 'current', 12121, $lahore, 'camala.jpg');

        // Une notification et un feedback pour la démo
        DB::table('notices')->insert([
            'account_id' => $ali,
            'notice' => 'Our privacy policy has been changed, please visit the nearest MCB branch for the new prospectus.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('feedbacks')->insert([
            'account_id' => $fayyaz,
            'message' => 'This is a testing message to the manager.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // crée une agence et renvoie son id
    private function branch(string $name, string $code): int
    {
        return DB::table('branches')->insertGetId([
            'branch_name' => $name,
            'branch_code' => $code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function staff(string $email, string $password, string $role): void
    {
        DB::table('staff')->insert([
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // crée un compte client et renvoie son id
    private function account(string $name, string $email, string $password, string $accountNo, string $type, float $balance, int $branchId, string $image): int
    {
        $branchName = DB::table('branches')->where('id', $branchId)->value('branch_name');

        // copie la photo du template dans le dossier des photos clients
        $source = public_path('assets/images/'.$image);
        if (file_exists($source)) {
            copy($source, public_path('assets/images/clients/'.$image));
        }

        $accountId = DB::table('accounts')->insertGetId([
            'name' => $name,
            'cnic' => '32403'.random_int(10000000, 99999999),
            'account_no' => $accountNo,
            'account_type' => $type,
            'city' => $branchName,
            'address' => 'Main Street, '.$branchName,
            'email' => $email,
            'password' => Hash::make($password),
            'balance' => $balance,
            'source' => 'Salary',
            'contact' => '0335691026'.random_int(0, 9),
            'branch_id' => $branchId,
            'image' => file_exists($source) ? $image : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('transactions')->insert([
            'account_id' => $accountId,
            'action' => 'deposit',
            'credit' => $balance,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $accountId;
    }
}

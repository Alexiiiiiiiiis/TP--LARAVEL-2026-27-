<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Feedback;
use App\Models\Notice;
use App\Models\Staff;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
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
        $dgk = new Branch();
        $dgk->branch_name = 'Dera Ghazi Khan';
        $dgk->branch_code = '100101';
        $dgk->save();

        $lahore = new Branch();
        $lahore->branch_name = 'Lahore';
        $lahore->branch_code = '100102';
        $lahore->save();

        // Personnel
        $this->staff('manager@mcbbank.com', 'manager', 'manager');
        $this->staff('cashier@mcbbank.com', 'cashier', 'cashier');
        $this->staff('cashier2@mcbbank.com', 'cashier2', 'cashier');

        // Clients (le solde de départ est enregistré comme un dépôt)
        $ali = $this->account('Ali khan', 'ali@mcbbank.com', 'ali', '10054777', 'saving', 16200, $dgk, 'hillary.jpg');
        $fayyaz = $this->account('Fayyaz Khan', 'fayyaz@mcbbank.com', 'fayyaz', '1513410739', 'saving', 234034, $dgk, 'kamal.png');
        $this->account('Sara Ahmed', 'sara@mcbbank.com', 'sara', '1513410837', 'current', 12121, $lahore, 'camala.jpg');

        // Une notification et un feedback pour la démo
        $notice = new Notice();
        $notice->account_id = $ali->id;
        $notice->notice = 'Our privacy policy has been changed, please visit the nearest MCB branch for the new prospectus.';
        $notice->save();

        $feedback = new Feedback();
        $feedback->account_id = $fayyaz->id;
        $feedback->message = 'This is a testing message to the manager.';
        $feedback->save();
    }

    private function staff(string $email, string $password, string $role): void
    {
        $staff = new Staff();
        $staff->email = $email;
        $staff->password = Hash::make($password);
        $staff->role = $role;
        $staff->save();
    }

    private function account(string $name, string $email, string $password, string $accountNo, string $type, float $balance, Branch $branch, string $image): Account
    {
        // copie la photo du template dans le dossier des photos clients
        $source = public_path('frontend/images/'.$image);
        if (file_exists($source)) {
            copy($source, public_path('frontend/images/clients/'.$image));
        }

        $account = new Account();
        $account->name = $name;
        $account->cnic = '32403'.random_int(10000000, 99999999);
        $account->account_no = $accountNo;
        $account->account_type = $type;
        $account->city = $branch->branch_name;
        $account->address = 'Main Street, '.$branch->branch_name;
        $account->email = $email;
        $account->password = Hash::make($password);
        $account->balance = $balance;
        $account->source = 'Salary';
        $account->contact = '0335691026'.random_int(0, 9);
        $account->branch_id = $branch->id;
        $account->image = file_exists($source) ? $image : null;
        $account->save();

        $transaction = new Transaction();
        $transaction->account_id = $account->id;
        $transaction->action = 'deposit';
        $transaction->credit = $balance;
        $transaction->save();

        return $account;
    }
}

<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;


class CorporateEmployeeImport implements ToModel
{
    protected $corporateId;
    protected $walletAmount;

    public function __construct($corporateId, $walletAmount = 0)
    {
        $this->corporateId = $corporateId;
        $this->walletAmount = $walletAmount ?? 0;
    }

    public function model(array $row)
    {
        if ($row[0] === 'Name' || empty($row[0])) {
            return null;
        }

        // Generate unique username
        do {
            $username = 'User' . rand(100000, 999999);
        } while (User::where('username', $username)->exists());

        // Generate unique user_id
        do {
            $user_id = $this->corporateId . 'U-' . rand(100000, 999999);
        } while (User::where('user_id', $user_id)->exists());

        $user = User::create([
            'name' => $row[0],
            'phone' => $row[1],
            'email' => $row[2] ?? $username . '@example.com',
            'user_id' => $user_id,
            'corporate_id' => auth()->user()->id,
            'role' => 1,
            'username' => $username,
            'password' => bcrypt($username),
            'show_password' => $username,
        ]);

        // Assign wallet amount
        if ($this->walletAmount > 0) {
            $user->wallet = $this->walletAmount;
            $user->save();
        }

        return $user;
    }
}

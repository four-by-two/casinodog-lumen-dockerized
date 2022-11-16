<?php

namespace Database\Seeders;

use App\Models\AuthorizedDevice;
use App\Models\LoginHistory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OperatorKeySeed extends Seeder
{
    /**
     * Used for authentication
     *
     * @return void
     */
    public function run()
    {
        /*
        $user = User::create([
            'operator_key' => md5(Str::rand(64)),
            'email' => 'default@casinoman.app',
            'password' => Hash::make('casinomanPassword'),
        ]);
        */
    }
}
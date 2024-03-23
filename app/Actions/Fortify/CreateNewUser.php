<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        
        $kecamatan = '';
        if($input['kec']==1){
            $kecamatan = "BLIMBING";
        }elseif($input['kec']==2){
            $kecamatan = "KLOJEN";
        }elseif($input['kec']==3){
            $kecamatan = "KEDUNGKANDANG";
        }elseif($input['kec']==4){
            $kecamatan = "SUKUN";
        }elseif($input['kec']==5){
            $kecamatan = "LOWOKWARU";
        }
        $v = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'nik' => [
                'required',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // $v2 = Validator::make($input, [
        //     'nik' => [
        //         'required',
        //         Rule::unique(User::class),
        //     ]
        // ]);

        // if ($v2->fails()) {
        //     return redirect(route('validasi_token.index'));
        // }

        // $role = Role::where('name', 'Website')->first();
        $role = Role::find(9); 
        $user = User::create([
            'name' => $input['name'],
            'nik' => $input['nik'],
            'email' => $input['email'],
            'phone' => $this->convert_hp_number($input['phone']),
            'kel' => $input['kel'],
            'kec' => $kecamatan,
            'status' => 'nonaktif',
            'token_user' => strtoupper(Str::random(6)),
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole($role);

        return $user;
    }

    public function convert_hp_number($no){
        if(!preg_match('/[^+0-9]/',trim($no))){
            // cek apakah no hp karakter 1-3 adalah +62
            if(substr(trim($no), 0, 3)=='+62'){
                $hp = '62'.substr(trim($no), 1);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif(substr(trim($no), 0, 1)=='0'){
                $hp = '62'.substr(trim($no), 1);
            }else{
                $hp = $no;
            }
        }
        return $hp;
    }
}

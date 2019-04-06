<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Validator;


class User extends Authenticatable
{
    use Notifiable,  HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'address',
        'tel',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function validate($request,$post)
    {
        $validator = Validator::make($post, self::rules($request));

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        }
        return ['status' => true, 'errors' => []];
    }

    public static function rules($request)
    {
        $rule =  [
            'name'     => 'required',
            'password'   => 'required',
            'address' => 'required',
            'tel'      => 'required',
            'email' =>   function ($attribute, $value, $fail) {
                if ($value !== null) {
                    $fail($attribute.' can\'t change ');
                }
            },
        ];
        
        if ($request->isMethod('POST')) {
            $rule['email'] = 'required|email|unique:users';
        }
        return $rule;
    }
}

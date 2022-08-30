<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateCode() {
        $code = rand(1000, 9999);

        UserCode::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['code' => $code]
        );

        $receiverNumber = auth()->user()->phone;
        $message = "2FA login code is " . $code;

        try {
            self::sendSms($receiverNumber, $message);
        } catch (Exception $e) {
            $this->info("Error: " . $e->getMessage());
        }
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public static function sendSms(string $tel, string $text)
    {;
        $list_tel_vn = [
            getenv("PHONE_TO_NUMBER_1"),
            getenv("PHONE_TO_NUMBER_2"),
        ];
        if (in_array($tel, $list_tel_vn)) {
            $to = "+84" . substr($tel, 1, strlen($tel));
        } else {
            $to = "+81" . substr($tel, 1, strlen($tel));
        }

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

        $client = new Client($account_sid, $auth_token);
        $message = $client->messages->create(
            $to,
            ['from' => $twilio_number, 'body' =>  $text]
        );
    }
}

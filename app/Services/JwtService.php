<?php

namespace App\Services;

use Dracarys\Jwt\Configuration;
use Dracarys\Jwt\Signer\Hmac\Sha256;
use Dracarys\Jwt\Signer\Symmetric;
use Dracarys\Jwt\Token\TokenData;

class JwtService
{
    protected $secretKey = 'secret';
    protected function config(): Configuration
    {
        return  Configuration::symmetric(new Sha256(), new Symmetric($this->secretKey));
    }
    public function createToken()
    {
        //Issuing a token
        $claims = new TokenData([
            'foo' => 'bar'
        ]);

        $headers = new TokenData([]);

        return $this->config()->createToken($claims, $headers)->toString();
    }

    public function parseToken($token)
    {
        return $this->config()->parser()->parse($token);
    }

    public function validation($parsedToken): void
    {
        $this->config()->validator($parsedToken)
        ->permittedFor('https://your-app.com')->assert();
    }
}

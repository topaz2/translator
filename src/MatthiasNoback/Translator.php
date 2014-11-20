<?php

namespace MatthiasNoback;

use Buzz\Browser;
use Buzz\Client\Curl;

class Translator
{
    public function __construct($id, $secret, $provider = 'Microsoft', $accessTokenProvider = 'MicrosoftOAuth\AccessTokenProvider')
    {
        $this->browser = new Browser(new Curl);
        $translator = sprintf('MatthiasNoback\Provider\%s\%sTranslator', $provider, $provider);
        $accessTokenProvider = sprintf('MatthiasNoback\Provider\%s\%s', $provider, $accessTokenProvider);
        $this->translator = new $translator(
            $this->browser,
            new $accessTokenProvider($this->browser, $id, $secret)
        );
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->translator, $method), $arguments);
    }
}

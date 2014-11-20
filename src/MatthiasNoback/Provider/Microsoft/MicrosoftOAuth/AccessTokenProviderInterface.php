<?php

namespace MatthiasNoback\Provider\Microsoft\MicrosoftOAuth;

interface AccessTokenProviderInterface
{
    public function getAccessToken($scope, $grantType);
}

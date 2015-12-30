<?php

$env = $app->detectEnvironment(function()
{
    return "local";
});
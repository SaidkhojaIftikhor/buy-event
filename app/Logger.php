<?php


namespace app;


class Logger
{
    public function log(string $error)
    {
        $file = fopen('errors.log', 'a');
        fwrite($file, "{$error}\n");
        fclose($file);
    }
}
<?php


namespace App\Service;


interface MailerServiceInterface
{
    public function send(string $from, string $to, string $subject, string $html, string $txt, array $params);
}

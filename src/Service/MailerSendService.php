<?php

namespace App\Service;

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Variable;

use PHPMailer\PHPMailer\PHPMailer;

class MailerSendService
{
    const SUPPORT_EMAIL = 'admin@traxxanalytics.com';
    const VERIFY_EMAIL_TEMPLATE_ID = 'z3m5jgr9vp0gdpyo';
    const RESET_PASSWORD_TEMPLATE_ID = '351ndgwrnp54zqx8';

    private MailerSend $mailerSend;
    
    public function __construct(MailerSend $mailerSend) {
        $this->mailerSend = $mailerSend;
    }

    public function sendEmail(array $variables, array $recipients, string $templateId)
    {
        $emailParams = (new EmailParams())
            ->setRecipients($recipients)
            ->setTemplateId($templateId)
            ->setVariables($variables);

        $this->mailerSend->email->send($emailParams);
    }
}
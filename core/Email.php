<?php

namespace core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 *  Class Email
 */
class Email
{
    /** @var object */
    private $data;

    /** @var PHPMailer  */
    private $mail;

    /** @var Message */
    private $message;

    /**
     *  Constructor
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->message = new Message;

        // SETUP
        $this->mail->isSMTP();
        $this->mail->setLanguage(CONF_MAIL_OPTION_LANG);
        $this->mail->isHTML(CONF_MAIL_OPTION_HMTL);
        $this->mail->SMTPAuth = CONF_MAIL_OPTION_AUTH;
        $this->mail->SMTPSecure = CONF_MAIL_OPTION_SECURE;
        $this->mail->CharSet = CONF_MAIL_OPTION_CHARSET;

        // AUTH
        $this->mail->Host = CONF_MAIL_HOST;
        $this->mail->Port = CONF_MAIL_PORT;
        $this->mail->Username = CONF_MAIL_USER;
        $this->mail->Password = CONF_MAIL_PASS;
    }

    /**
     *  PT-BR # Dados necessários para o disparo do e-mail.
     *  EN # Data required to send the email.
     *  @param string $subject
     *  @param string $message
     *  @param string $toEmail
     *  @param string $toName
     *  @return Email
     */
    public function bootstrap(string $subject, string $message, string $toEmail, string $toName): Email
    {
        $this->data = new \stdClass();
        $this->data->subject = $subject;
        $this->data->message = $message;
        $this->data->toEmail = $toEmail;
        $this->data->toName = $toName;

        return $this;
    }

    /**
     *  PT-BR # Envio de arquivo junto ao e-mail.
     *  EN # Sending file by email.
     *  @param string $filePath
     *  @param string $fileName
     *  @return Email
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }

    /**
     *  PT-BR # Envio do e-mail após a execução do boostrap.
     *  EN # Sending the email after running bootstrap.
     *  @param string $fromEmail
     *  @param string $fromName
     *  @return bool
     */
    public function send(string $fromEmail = CONF_MAIL_SENDER['adress'], string $fromName = CONF_MAIL_SENDER['name']): bool
    {   
        if (empty($this->data)) {
            $this->message->error("Erro ao enviar, verifique os dados informados");
            return false;
        }

        if (! is_email($this->data->toEmail)) {
            $this->message->warning("O e-mail do destinatário não é valido");
            return false;
        }

        if (! is_email($fromEmail)) {
            $this->message->warning("O e-mail do remetente não é valido");
            return false;
        }

        try {
            
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->message);
            $this->mail->addAddress($this->data->toEmail, $this->data->toName);
            $this->mail->setFrom($fromEmail, $fromName);

            if (! empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;

        } catch (Exception $e) {
            $this->message->error($e->getMessage());
            return false;
        }
    }

    /**
     *  PT-BR # Retorno do objeto PHPMailer.
     *  EN # PHPMailer object return.
     *  @return PHPMailer
     */
    public function mail(): PHPMailer
    {
        return $this->mail;
    }

    /**
     *  PT-BR # Retorno do objeto Message.
     *  EN # Message object return.
     *  @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
}
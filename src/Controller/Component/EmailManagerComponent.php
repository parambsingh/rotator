<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Mailer;
use Cake\Network\Exception\NotFoundException;
use Cake\Mailer\TransportFactory;

class EmailManagerComponent extends Component {

    private $emailResponse;

    public function sendEmail($options = []) {

        $this->emailResponse['error'] = true;
        $defaultOptions = [

            'template'    => 'default',
            'layout'      => 'default',
            'emailFormat' => 'both',
            'to'          => null,
            'cc'          => null,
            'bcc'         => null,
            'from'        => [SMTP_USER => SITE_TITLE],
            'sender'      => [SMTP_USER => SITE_TITLE],
            'subject'     => SITE_TITLE,
            'viewVars'    => [
                'logo'    => SITE_URL . "img/logo-aptnet.png",
                'appName' => SITE_TITLE,
                'appUrl'  => SITE_URL
            ]
        ];

        if (!empty($options['viewVars'])) {
            $options['viewVars'] = array_merge($defaultOptions['viewVars'], $options['viewVars']);
        }

        $finalOptions = array_merge($defaultOptions, $options);

        extract($finalOptions);
        $hasDestination = false;



        try {
            $email = new Mailer();
            $email->setFrom($from);
            $email->viewBuilder()->setTemplate($template);

            $email->viewBuilder()->setLayout($layout);
            //$email->setProfile($configT);
            if ($to != null) {
                if (is_array($to)) {
                    $email->setTo($to);
                    $hasDestination = true;
                } else {
                    if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
                        $email->setTo($to);
                        $hasDestination = true;
                    } else {
                        $hasDestination = false;
                    }
                }
            }

            if ($cc != null) {
                if (filter_var($cc, FILTER_VALIDATE_EMAIL)) {
                    $email->setCc($cc);
                    $hasDestination = true;
                } else {
                    if (!$hasDestination)
                        $hasDestination = false;
                }
            }

            if ($bcc != null) {
                if (is_array($bcc)) {
                    $email->setBcc($bcc);
                    $hasDestination = true;
                } else {
                    if (filter_var($bcc, FILTER_VALIDATE_EMAIL)) {
                        $email->setBcc($bcc);
                        $hasDestination = true;
                    } else {
                        $hasDestination = false;
                    }
                }
            }


            if ($sender != null) {
                $email->setSender(array_keys($sender)[0], array_Values($sender)[0]);
            }

            $email->setEmailFormat($emailFormat);
            $email->setSubject($subject);
            $email->setViewVars($viewVars);
            if ($hasDestination) {
                $this->emailResponse['error'] = false;
                $this->emailResponse['status'] = 'Email Sent';
                $email->send();
            } else {
                $this->emailResponse['status'] = 'Email did not send, destination email not found';
            }
        } catch (Exception $e) {
            throw new NotFoundException(__('Destination email not found'));
        }
        return $this->emailResponse;
    }

}

?>



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\PHPMailer;

class Setting extends Model
{
    protected $table    = 'settings';
    protected $fillable = ['company_name', 'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'company_image'];

    public function companySettings(array $data)
    {
        $setting = Setting::first();
        if (isset($data['company_image']) && !empty($data['company_image']) && !empty($setting)) {
            if (!empty($setting->company_image) && file_exists(public_path('admin/assets/img/company_settings/'.$setting->company_image))) {
                unlink(public_path('admin/assets/img/company_settings/'.$setting->company_image));
            }
            $imageName = time().rand(1,10000).'.'.$data['company_image']->extension();
            $upload_path = public_path('admin/assets/img/company_settings/');
            $data['company_image']->move($upload_path, $imageName);
        }
        if (empty($setting)) {
            $settings_data = [
                'company_name' => isset($data['company_name']) ? $data['company_name'] : null,
                'mail_driver' => isset($data['mail_driver']) ? $data['mail_driver'] : null,
                'mail_host' => isset($data['mail_host']) ? $data['mail_host'] : null,
                'mail_port' => isset($data['mail_port']) ? $data['mail_port'] : null,
                'mail_username' => isset($data['mail_username']) ? $data['mail_username'] : null,
                'mail_password' => isset($data['mail_password']) ? $data['mail_password'] : null,
                'mail_encryption' => isset($data['mail_encryption']) ? $data['mail_encryption'] : null,
                'mail_from_address' => isset($data['mail_from_address']) ? $data['mail_from_address'] : null,
            ];
            if (isset($data['company_image']) && !empty($data['company_image'])) {
                $settings_data['company_image'] = $imageName;
            }
            self::create($settings_data);
        } else {
            $setting->company_name = $data['company_name'];
            if (isset($data['company_image']) && !empty($data['company_image'])) {
                $setting->company_image = $imageName;
            }
            if (!empty($data['mail_driver'])) {
                $setting->mail_driver = $data['mail_driver'];
            }
            if (!empty($data['mail_host'])) {
                $setting->mail_host = $data['mail_host'];
            }
            if (!empty($data['mail_port'])) {
                $setting->mail_port = $data['mail_port'];
            }
            if (!empty($data['mail_username'])) {
                $setting->mail_username = $data['mail_username'];
            }
            if (!empty($data['mail_password'])) {
                $setting->mail_password = $data['mail_password'];
            }
            if (!empty($data['mail_encryption'])) {
                $setting->mail_encryption = $data['mail_encryption'];
            }
            if (!empty($data['mail_from_address'])) {
                $setting->mail_from_address = $data['mail_from_address'];
            }
            $setting->save();
        }
    }

    public function sendEmail($to, $subject, $message)
    {
        $mail = new \App\libraries\MailService();
        $data = [];
        $data = array(
            'to'      => array($to),
            'subject' => $subject,
            'content' => $message,
        );

        $emailConfig = Setting::first();

        if (isset($emailConfig->mail_driver) && ($emailConfig->mail_driver == 'smtp')) {
            $this->setupEmailConfig();
            $mail->CharSet  = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->send($data, 'emails.sendmail');
        } else {
            $emailInfo = '';
            $this->sendPhpEmail($to, $subject, $message, $emailInfo);
        }
    }

    public function sendPhpEmail($to, $subject, $message, $emailInfo, $path = null, $attachedFile = null)
    {
        require 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        $admin = User::where(['user_type' => 0])->first(['name', 'email']);
        if (!empty($admin)) {
            $mail->From     = $admin->email;
            $mail->FromName = $admin->name;
            $mail->AddAddress($to, isset($admin) ? $mail->FromName : 'N/A');
            $mail->Subject = $subject;
            $mail->Body    = $message;

            //extra - starts
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->CharSet  = 'UTF-8';
            $mail->Encoding = 'base64';
            //extra - ends

            if (!empty($attachedFile))
            {
                $mail->AddAttachment(public_path('/' . $path . '/' . $attachedFile, 'base64'));
            }
            $mail->Send();
        }
    }

    public function setupEmailConfig()
    {
        $result = Setting::first();
        \Config::set([
            'mail.driver'     => isset($result->mail_driver) ? $result->mail_driver : '',
            'mail.host'       => isset($result->mail_host) ? $result->mail_host : '',
            'mail.port'       => isset($result->mail_port) ? $result->mail_port : '',
            'mail.from'       => ['address' => isset($result->mail_from_address) ? $result->mail_from_address : '', 'name' => isset($result->company_name) ? $result->company_name : config('app.name', '')],
            'mail.encryption' => isset($result->mail_encryption) ? $result->mail_encryption : '',
            'mail.username'   => isset($result->mail_username) ? $result->mail_username : '',
            'mail.password'   => isset($result->mail_password) ? $result->mail_password : '',
        ]);
    }

}

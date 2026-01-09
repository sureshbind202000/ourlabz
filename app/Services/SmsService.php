<?php



namespace App\Services;



use App\Models\SmsTemplate;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;



class SmsService

{

    protected $apiUrl;

    protected $username;

    protected $password;

    protected $senderId;



    public function __construct()

    {

        $this->apiUrl   = config('services.smartping.url');

        $this->username = config('services.smartping.username');

        $this->password = config('services.smartping.password');

        $this->senderId = config('services.smartping.sender_id');
    }



    /**

     * Send SMS using SmartPing API

     *

     * @param string $phone

     * @param array $data — dynamic variables for message replacement (e.g. ['otp' => 1234])

     * @param string $templateName — template name (e.g. 'login_otp')

     * @return bool

     */

    public function sendSms(string $phone, ?array $data, string $templateName): bool

    {

        try {

            // Fetch the template from DB

            $template = SmsTemplate::where('name', $templateName)

                ->where('status', 1)

                ->first();



            if (!$template) {

                Log::error("SMS Template not found: {$templateName}");

                return false;
            }



            // Replace placeholders like {{otp}}, {{name}} in the message

            $message = $template->message;



            if (!empty($data)) {

                foreach ($data as $key => $value) {

                    $message = str_replace('{{' . $key . '}}', $value ?? '', $message);
                }
            }



            // Remove any unreplaced placeholders

            $message = preg_replace('/{{\w+}}/', '', $message);

            $isUnicode = (strlen($message) != strlen(utf8_decode($message)));

            $message = trim(preg_replace('/\s+/', ' ', $message));
            // Send API request

            $response = Http::get($this->apiUrl, [

                'username'     => $this->username,

                'password'     => $this->password,

                'from'         => $this->senderId,

                'to'           => $phone,

                'text'         => $message,

                'unicode'      => $isUnicode ? 'true' : 'false',

                'dltContentId' => $template->template_id,

            ]);



            if ($response->failed()) {

                Log::error('SmartPing SMS Failed', [

                    'phone'    => $phone,

                    'template' => $templateName,

                    'response' => $response->body(),

                ]);

                return false;
            }



            return true;
        } catch (\Exception $e) {

            Log::error('SmartPing SMS Exception: ' . $e->getMessage());

            return false;
        }
    }
}

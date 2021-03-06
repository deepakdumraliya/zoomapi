<?php
require_once 'jwt/BeforeValidException.php';
require_once 'jwt/ExpiredException.php';
require_once 'jwt/SignatureInvalidException.php';
require_once 'jwt/JWT.php';
require_once 'class-db.php';

use \Firebase\JWT\JWT;

class Zoom_Api
{
    private $zoom_api_key = 'I9lhxanzQ7yO6BP-fA7rFw';
    private $zoom_api_secret = 'c9suCpAbpEBQWtMnxTmhwIFp5HGh0ZNol1uU';

    protected function sendRequest($data)
    {
        $request_url = 'https://api.zoom.us/v2/users/me/meetings';
        $headers = array(
            "authorization: Bearer " . $this->generateJWTKey(),
            'content-type: application/json'
        );
        $postFields = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!$response) {
            return $err;
        }
        return json_decode($response);
    }

    //function to generate JWT
    private function generateJWTKey()
    {
        $key = $this->zoom_api_key;
        $secret = $this->zoom_api_secret;
        $token = array(
            "iss" => $key,
            "exp" => time() + 3600 //60 seconds as suggested
        );
        // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IlI1OWZNMEViUXFPcWNrU0c4dzR2MmciLCJleHAiOjE1OTA1MTM4NDUsImlhdCI6MTU5MDUwODQ0N30.4ch2OZoFM_vZFdqhoMzJX8r8GPYjKlOkV_vUa7LprFc";
        return JWT::encode($token, $secret);
    }

    public function createAMeeting($data = array())
    {
        $post_time  = $data['start_date'];
        $start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));
        $createAMeetingArray = array();
        if (!empty($data['alternative_host_ids'])) {
            if (count($data['alternative_host_ids']) > 1) {
                $alternative_host_ids = implode(",", $data['alternative_host_ids']);
            } else {
                $alternative_host_ids = $data['alternative_host_ids'][0];
            }
        }
        $createAMeetingArray['topic']      = $data['meetingTopic'];
        $createAMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
        $createAMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
        $createAMeetingArray['start_time'] = $start_time;
        $createAMeetingArray['timezone']   = $data['timezone'];
        $createAMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "";
        $createAMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;
        $createAMeetingArray['settings']   = array(
            'join_before_host'  => !empty($data['join_before_host']) ? true : false,
            'host_video'        => !empty($data['option_host_video']) ? true : false,
            'participant_video' => !empty($data['option_participants_video']) ? true : false,
            'mute_upon_entry'   => !empty($data['option_mute_participants']) ? true : false,
            'enforce_login'     => !empty($data['option_enforce_login']) ? true : false,
            'auto_recording'    => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
        );
        return $this->sendRequest($createAMeetingArray);
    }
}


if (isset($_POST['submit'])) {

    $topic = trim($_POST['topic']);
    // $password=trim($_POST['password']);

    $zoom_meeting = new Zoom_Api();
    try {
        $z = $zoom_meeting->createAMeeting(
            array(
                //   'start_date'=>date("Y-m-d h:i:s", strtotime('tomorrow')),
                'start_date' => date("Y-m-d h:i:s"),
                'meetingTopic' =>  $topic,
                'timezone' => 'Asia/kolkata'
            )
        );
        // echo "<pre>";
        // print_r($z);
        // echo "</pre>";

        $meeting_id = $z->id;
        $join_url = $z->join_url;
        $meeting_password = $z->password;
        $start_url = $z->start_url;
        $db = new DB();
        $db->add_new_meeting($meeting_id, $meeting_password, $topic, $join_url, $start_url);
        if ($db) {
            header("location:main.php");
        } else {
            echo "failed";
        }
    } catch (Exception $ex) {
        echo $ex;
    }
}

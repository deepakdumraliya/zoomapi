<?php
require_once "config.php";
class DB
{
    private $dbHost     = HOST;
    private $dbUsername = USERNAME;
    private $dbPassword = PASSWORD;
    private $dbName     = DB_NAME;

    public function __construct()
    {
        if (!isset($this->db)) {
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if ($conn->connect_error) {
                die("Failed to connect with MySQL: " . $conn->connect_error);
            } else {
                $this->db = $conn;
            }
        }
    }

    public function is_table_empty()
    {
        $result = $this->db->query("SELECT id FROM token");
        if ($result->num_rows) {
            return false;
        }

        return true;
    }

    public function get_access_token()
    {
        $sql = $this->db->query("SELECT access_token FROM token");
        $result = $sql->fetch_assoc();
        return json_decode($result['access_token']);
    }

    public function get_refersh_token()
    {
        $result = $this->get_access_token();
        return $result->refresh_token;
    }

    public function update_access_token($token)
    {
        if ($this->is_table_empty()) {
            $this->db->query("INSERT INTO token(access_token) VALUES('$token')");
        } else {
            $this->db->query("UPDATE token SET access_token = '$token' WHERE id = (SELECT id FROM token)");
        }
    }

    public function add_new_meeting($meeting_id, $passcode, $topic, $join_url, $start_url)
    {
        $sql =  $this->db->query("INSERT INTO tblmeetings(meeting_id,passcode,topic,join_url,start_url) VALUES('$meeting_id','$passcode','$topic','$join_url','$start_url')");
    }
    public function get_meeting()
    {
        $sql =  $this->db->query("SELECT * FROM tblmeetings");
        return $sql;
    }
    public function get_meeting_by_id($id)
    {
        $sql =  $this->db->query("SELECT * FROM tblmeetings where id={$id}");
        return $sql;
    }
    public function login($username, $passcode)
    {
        $sql =  $this->db->query("SELECT * FROM tbl_users where username='{$username}' and password='{$passcode}' ");

        return $sql;
    }
    public function getuserbyid($id)
    {
        $sql =  $this->db->query("SELECT * FROM tbl_users where id='{$id}'");
        return $sql;
    }
}

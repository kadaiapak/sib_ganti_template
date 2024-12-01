<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->api_h2hurl = "https://wsvc.unp.ac.id/api/";
        $this->api_h2hid = 119009;
        $this->api_h2hkey = 'FpY6qZ3S';//'f5j8SwdG';
        $this->api_h2hunicode = 'nIowYLmcNdMjWHfAgQTlrJqeSpVEsOXvGbzDPaFyuki';//
    }

   /* public function curl_init($field=array(),$ws='')
    {
        $curl = curl_init();
        if ($ws=='') {
            $ws=$this->session->userdata('ws');
        }
        curl_setopt_array($curl, array(
          CURLOPT_URL => $ws,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>json_encode($field),
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //return $response;
        $cek=json_decode($response);
        return $cek;
    }
*/
    public function curl_post($act='',$field=array())
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->api_h2hurl.$act,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($field),
          CURLOPT_HTTPHEADER => array(
            "h2hid: ".$this->api_h2hid,
            "h2hkey: ".$this->api_h2hkey,
            "h2hunicode: ".$this->api_h2hunicode,
            'Content-Type: application/json'
        ),
        ));
        $str['query'] = json_encode($field);
       // save_query($str);
        $response = curl_exec($curl);

        curl_close($curl);
        //return $response;
        $cek=json_decode($response);
        return $cek;

    }

    public function curl_get($act='',$field=array())
    {
        /*$arr = array_merge($field,array(
            'h2hid: '.$this->api_h2hid,
            'h2hkey: '.$this->api_h2hkey,
            'h2hunicode: '.$this->api_h2hunicode));*/
        //print_r($arr);die();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->api_h2hurl.$act,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          //CURLOPT_POSTFIELDS => json_encode($field),
          CURLOPT_HTTPHEADER => array_merge($field,array(
            'h2hid: '.$this->api_h2hid,
            'h2hkey: '.$this->api_h2hkey,
            'h2hunicode: '.$this->api_h2hunicode)
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // return $response;
        $cek=json_decode($response);
        return $cek;
    }

    public function gettoken()
    {
        $field=array(
            'act' => 'GetToken',
            'username' => $this->session->userdata('username'),
            'password' => $this->session->userdata('password'),
        );
        $cek=$this->api_model->curl_init($field);
        if ($cek->error_code==0) {
            return $cek->data->token;
        } else {
            return 0;
        }
    }

    public function getDataMhsCek($mhsniu='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->api_url.'cekmhs',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "h2hid: ".$this->api_h2hid,
            "h2hkey: ".$this->api_h2hkey,
            "h2hunicode: ".$this->api_h2hunicode,
            "mhsniu: ".$mhsniu
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //return $response;
        $cek=json_decode($response);
        return $cek;
        /*if ($cek->message=='berhasil') {
            return $cek->data;
        } else {
            return array();
        }*/

    }

    public function MhsCekAktif($mhsniu='',$idsem='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->api_url.'cekmhsaktif',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "h2hid: ".$this->api_h2hid,
            "h2hkey: ".$this->api_h2hkey,
            "h2hunicode: ".$this->api_h2hunicode,
            "mhsniu: ".$mhsniu,
            "semid: ".$idsem
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //return $response;
        $cek=json_decode($response);
        return $cek;
    }

    public function user_portal($username='',$password='')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->api_h2hurl.'akademik/portal/usrportal',
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "h2hid: ".$this->api_h2hid,
            "h2hkey: ".$this->api_h2hkey,
            "h2hunicode: ".$this->api_h2hunicode,
            "username: ".$username,
            "password: ".$password
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
        //$cek=json_decode($response);
        //return $cek;

    }
}

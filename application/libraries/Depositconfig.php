<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Depositconfig class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * depositconfig table 을 관리하는 class 입니다.
 */
class Depositconfig extends CI_Controller
{

    private $CI;
    private $cfg;

    function __construct()
    {
        $this->CI = & get_instance();
    }


    /**
     * cmall config table 에서 정보를 얻습니다
     */
    public function get_config()
    {
        $this->CI->load->model('Deposit_config_model');
        $this->cfg = $this->CI->Deposit_config_model->get_all_meta();
    }


    /**
     * cmall config table 의 item 을 얻습니다
     */
    public function item($column = '')
    {
        if (empty($column)) {
            return false;
        }
        if (empty($this->cfg)) {
            $this->get_config();
        }
        if (empty($this->cfg)) {
            return false;
        }
        $config = $this->cfg;

        return isset($config[$column]) ? $config[$column] : false;
    }
}

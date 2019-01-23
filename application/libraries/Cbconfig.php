<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cbconfig class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * config table 을 관리하는 class 입니다.
 */
class Cbconfig extends CI_Controller
{

    private $CI;
    private $cfg;
    private $device_view_type;
    private $device_type;

    function __construct()
    {
        $this->CI = & get_instance();
    }


    /**
     * config table 에서 정보를 얻습니다
     */
    public function get_config($return=false)
    {
        $this->CI->load->model('Config_model');
        $this->cfg = $this->CI->Config_model->get_all_meta();

        // 이 부분에 현재 버전과 패치 버전이 틀릴시 db업그레이드 하는 부분을 넣습니다.

        if( !isset( $this->cfg['cb_version'] ) ){
            
            $sql = "ALTER TABLE ".$this->CI->db->dbprefix."session CHANGE COLUMN `id` `id` VARCHAR(120) NOT NULL DEFAULT ''";
            $this->CI->db->query($sql);
            
            try {
                
                $this->CI->load->model(array('Payment_order_data_model', 'Payment_inicis_log_model'));

                if ($this->CI->db->table_exists($this->CI->db->dbprefix.'payment_order_data') ) {
                    $row = $this->CI->Payment_order_data_model->get_one();

                    if( !isset($row['mem_id']) ){
                        $sql = "ALTER TABLE ".$this->CI->db->dbprefix."payment_order_data ADD COLUMN `mem_id` INT(11) NOT NULL DEFAULT 0 AFTER `pod_ip`, ADD COLUMN `cart_id` VARCHAR(255) NOT NULL DEFAULT '' AFTER `mem_id` ";
                        $this->CI->db->query($sql);
                    }
                }
                
                if ($this->CI->db->table_exists($this->CI->db->dbprefix.'payment_inicis_log') ) {
                    $row = $this->CI->Payment_inicis_log_model->get_one();

                    if( !isset($row['P_AUTH_NO']) ){
                        $sql = "ALTER TABLE ".$this->CI->db->dbprefix."payment_inicis_log ADD COLUMN `P_AUTH_NO` VARCHAR(255) NOT NULL DEFAULT '' AFTER `P_AMT` ";
                        $this->CI->db->query($sql);
                    }
                }

            } catch (Exception $e) {

            }

            //로그 파일이 있으면 삭제합니다.
            $checks_paths = array(
                FCPATH . '/plugin/pg/inicis/log/',
                FCPATH . '/plugin/kcp/inicis/log/',
                FCPATH . '/plugin/lg/inicis/log/',
                );
            
            foreach( $checks_paths as $path ){
                if( is_dir($path) ){
                    $files = glob($path.'/*');
                    
                    foreach ((array) $files as $file) {
                        if( $file && ! preg_match('/\.htaccess$/i', $file) ){
                            unlink($file);
                        }
                    }
                    
                }
            }

            $savedata = array(
                'cb_version' => CB_VERSION
                );

            $this->CI->Config_model->save($savedata);

        }
        
        if( version_compare($this->cfg['cb_version'], '2.0.1', '<') ){

           try {

                $this->CI->load->model(array('Cmall_order_model', 'Deposit_model', 'Cmall_order_detail_model'));

                if ($this->CI->db->table_exists($this->CI->db->dbprefix.'cmall_order') ) {
                    $row = $this->CI->Cmall_order_model->get_one();
                    
                    if( !array_key_exists('cor_vbank_expire', $row) ){
                        $sql = "ALTER TABLE ".$this->CI->db->dbprefix."cmall_order ADD COLUMN `cor_vbank_expire` DATETIME NULL DEFAULT NULL AFTER `cor_status`, ADD COLUMN `is_test` CHAR(1) NOT NULL DEFAULT '' AFTER `cor_vbank_expire`,
                        ADD COLUMN `status` varchar(255) NOT NULL DEFAULT '' AFTER `is_test`,
                        ADD COLUMN `cor_refund_price` INT(11) NOT NULL DEFAULT '0' AFTER `status`,
                        ADD COLUMN `cor_order_history` TEXT NULL DEFAULT '' AFTER `cor_refund_price` ";
                        $this->CI->db->query($sql);
                    }
                }

                if ($this->CI->db->table_exists($this->CI->db->dbprefix.'deposit') ) {
                    $row = $this->CI->Deposit_model->get_one();
                    
                    if( !array_key_exists('dep_vbank_expire', $row) ){
                        $sql = "ALTER TABLE ".$this->CI->db->dbprefix."deposit ADD COLUMN `dep_vbank_expire` DATETIME NULL DEFAULT NULL AFTER `dep_status`, ADD COLUMN `is_test` CHAR(1) NOT NULL DEFAULT '' AFTER `dep_vbank_expire`,
                        ADD COLUMN `status` varchar(255) NOT NULL DEFAULT '' AFTER `is_test`, 
                        ADD COLUMN `dep_refund_price` INT(11) NOT NULL DEFAULT '0' AFTER `status`, 
                        ADD COLUMN `dep_order_history` TEXT NULL DEFAULT '' AFTER `dep_refund_price` ";
                        $this->CI->db->query($sql);
                    }
                }

                if ($this->CI->db->table_exists($this->CI->db->dbprefix.'cmall_order_detail') ) {

                    $row = $this->CI->Cmall_order_detail_model->get_one();
                    
                    if( !isset($row['cod_status']) ){
                        $sql = "ALTER TABLE ".$this->CI->db->dbprefix."cmall_order_detail ADD COLUMN `cod_status` VARCHAR(50) NOT NULL DEFAULT '' AFTER `cod_count` ";

                        $this->CI->db->query($sql);
                    }

                }

            } catch (Exception $e) {

            }

        }

        if( $this->cfg['cb_version'] != CB_VERSION ){

            $savedata = array(
                'cb_version' => CB_VERSION
                );

            $this->CI->Config_model->save($savedata);

        }

    
        if( $return ){
            return $this->cfg;
        }
    }   //end function

    /**
     * config table 의 item 을 얻습니다
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


    /**
     * 모바일버전보기/PC버전보기 설정 저장합니다
     */
    public function set_device_view_type($device_view_type)
    {
        $this->device_view_type = $device_view_type;
    }


    /**
     * 모바일버전보기/PC버전보기 설정 불러옵니다
     */
    public function get_device_view_type()
    {
        return $this->device_view_type;
    }


    /**
     * 현재 접속한 디바이스가 PC인지 mobile 인지를 저장합니다
     */
    public function set_device_type($device_type)
    {
        $this->device_type = $device_type;
    }


    /**
     * 현재 접속한 디바이스가 PC인지 mobile 인지를 불러옵니다
     */
    public function get_device_type()
    {
        return $this->device_type;
    }
}

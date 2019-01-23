<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Deposit config model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Deposit_config_model extends CB_Model
{

    /**
     * 테이블명
     */
    public $_table = 'deposit_config';

    /**
     * 사용되는 테이블의 프라이머리키
     */
    public $meta_key = 'dcf_key';

    public $meta_value = 'dcf_value';

    public $cache_name= 'deposit-config-model-get'; // 캐시 사용시 프리픽스

    public $cache_time = 86400; // 캐시 저장시간

    function __construct()
    {
        parent::__construct();
    }


    public function get_all_meta()
    {
        $cachename = $this->cache_name;
        $data = array();
        if ( ! $data = $this->cache->get($cachename)) {
            $result = array();
            $res = $this->get();
            if ($res && is_array($res)) {
                foreach ($res as $val) {
                    $result[$val[$this->meta_key]] = $val[$this->meta_value];
                }
            }
            $data['result'] = $result;
            $data['cached'] = '1';
            $this->cache->save($cachename, $data, $this->cache_time);
        }
        return isset($data['result']) ? $data['result'] : false;
    }


    public function save($savedata = '')
    {
        if ($savedata && is_array($savedata)) {
            foreach ($savedata as $column => $value) {
                $this->meta_update($column, $value);
            }
        }
        $this->cache->delete($this->cache_name);
    }


    public function meta_update($column = '', $value = false)
    {
        $column = trim($column);
        if (empty($column)) {
            return false;
        }

        $old_value = $this->item($column);
        if (empty($value)) {
            $value = '';
        }
        if ($value === $old_value) {
            return false;
        }

        if (false === $old_value) {
            return $this->add_meta($column, $value);
        }

        return $this->update_meta($column, $value);
    }


    public function item($column = '')
    {
        if (empty($column)) {
            return false;
        }
        $result = $this->get_all_meta();

        return isset($result[ $column ]) ? $result[ $column ] : false;
    }


    public function add_meta($column = '', $value = '')
    {
        $column = trim($column);
        if (empty($column)) {
            return false;
        }

        $updatedata = array(
            'dcf_key' => $column,
            'dcf_value' => $value,
        );
        $this->db->replace($this->_table, $updatedata);

        return true;
    }


    public function update_meta($column = '', $value = '')
    {
        $column = trim($column);
        if (empty($column)) {
            return false;
        }

        $this->db->where($this->meta_key, $column);
        $data = array($this->meta_value => $value);
        $this->db->update($this->_table, $data);

        return true;
    }
}

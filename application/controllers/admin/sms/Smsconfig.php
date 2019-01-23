<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Smsconfig class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>SMS 설정>SMS 환경설정 controller 입니다.
 */
class Smsconfig extends CB_Controller
{

    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'sms/smsconfig';

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Config');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Config_model';

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring'));
    }


    /**
     * SMS 설정>SMS 환경설정 페이지입니다
     */
    public function index()
    {

        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_sms_smsconfig_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * Validation 라이브러리를 가져옵니다
         */
        $this->load->library('form_validation');

        /**
         * 전송된 데이터의 유효성을 체크합니다
         */
        $config = array(
            array(
                'field' => 'is_submit',
                'label' => '전송',
                'rules' => 'trim|numeric',
            ),
            array(
                'field' => 'use_sms',
                'label' => 'SMS 사용',
                'rules' => 'trim|numeric',
            ),
            array(
                'field' => 'sms_icode_id',
                'label' => '아이코드 아이디',
                'rules' => 'trim',
            ),
            array(
                'field' => 'sms_icode_pw',
                'label' => '아이코드 비밀번호',
                'rules' => 'trim|callback__sms_icode_check',
            ),
            array(
                'field' => 'sms_admin_phone',
                'label' => '회신번호',
                'rules' => 'trim',
            ),
        );
        $this->form_validation->set_rules($config);

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        if ($this->form_validation->run() === false) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

        } else {
            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $array = array('use_sms', 'sms_icode_id', 'sms_icode_pw', 'sms_admin_phone',);

            foreach ($array as $value) {
                $savedata[$value] = $this->input->post($value, null, '');
            }
            if ($this->input->post('sms_icode_id') && $this->input->post('sms_icode_pw')) {
                $this->load->library('smslib');
                $smsinfo = $this->smslib->get_icode_info($this->input->post('sms_icode_id'), $this->input->post('sms_icode_pw'));
                if (element('payment', $smsinfo) === 'C') {
                    $savedata['sms_icode_port'] = '7296';
                } else {
                    $savedata['sms_icode_port'] = '7295';
                }
            }

            $this->Config_model->save($savedata);
            $view['view']['alert_message'] = 'SMS 설정이 저장되었습니다';
        }

        $getdata = $this->Config_model->get_all_meta();
        if (element('sms_icode_id', $getdata) && element('sms_icode_pw', $getdata)) {
            $this->load->library('smslib');
            $getdata['smsinfo'] = $this->smslib->get_icode_info(element('sms_icode_id', $getdata), element('sms_icode_pw', $getdata));
        }
        $view['view']['data'] = $getdata;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'index');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    /**
     * 아이코드 아이디와 패스워드가 맞는지 체크합니다
     */
    public function _sms_icode_check($pw = '')
    {
        $id = $this->input->post('sms_icode_id');

        if (empty($id) && empty($pw)) {
            return true;
        }
        $this->load->library('smslib');
        $result = $this->smslib->get_icode_info($id, $pw);
        if (element('code', $result) === '202') {
            $this->form_validation->set_message(
                '_sms_icode_check',
                '아이코드 아이디와 패스워드가 맞지 않습니다'
            );
            return false;
        }
        return true;
    }
}

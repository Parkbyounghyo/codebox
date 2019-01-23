<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Levelup class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 설문조사 담당하는 controller 입니다.
 */
class Poll extends CB_Controller
{

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Post_poll');

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
        $this->load->library(array('pagination', 'querystring'));
    }


    /**
     * 설문조사 페이지입니다
     */
    public function index()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_poll_index';
        $this->load->event($eventname);

        if ( ! $this->cbconfig->item('use_poll_list')) {
            alert('이 웹사이트는 설문조사모음 페이지 기능을 사용하지 않습니다');
        }

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
        $findex = $this->Post_poll_model->primary_key;
        $forder = 'desc';
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');

        $this->Post_poll_model->allow_search_field = array('post_title', 'post_content', 'ppo_title'); // 검색이 가능한 필드
        $this->Post_poll_model->search_field_equal = array(); // 검색중 like 가 아닌 = 검색을 하는 필드

        $per_page = $this->cbconfig->item('list_count') ? (int) $this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $result = $this->Post_poll_model
            ->get_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['post_url'] = post_url(element('brd_key', $val), element('post_id', $val));
                $result['list'][$key]['num'] = $list_num--;
                $result['list'][$key]['period'] = '';
                $result['list'][$key]['brd_name'] = $this->board->item_id('brd_name', element('brd_id', $val));
                if (element('ppo_end_datetime', $val) > cdate('Y-m-d H:i:s')
                    OR empty($val['ppo_end_datetime'])
                    OR element('ppo_end_datetime', $val) === '0000-00-00 00:00:00') {
                    $result['list'][$key]['period'] = '진행중';
                } elseif (element('ppo_start_datetime', $val) > cdate('Y-m-d H:i:s')) {
                    $result['list'][$key]['period'] = '진행전';
                } else {
                    $result['list'][$key]['period'] = '설문완료';
                }

            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('poll') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        $view['view']['canonical'] = site_url('poll');
        if ($this->input->get('page')) {
            $view['view']['canonical'] .= '?page=' . $this->input->get('page');
        }

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_poll');
        $meta_description = $this->cbconfig->item('site_meta_description_poll');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_poll');
        $meta_author = $this->cbconfig->item('site_meta_author_poll');
        $page_name = $this->cbconfig->item('site_page_name_poll');

        $layoutconfig = array(
            'path' => 'poll',
            'layout' => 'layout',
            'skin' => 'poll',
            'layout_dir' => $this->cbconfig->item('layout_poll'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_poll'),
            'use_sidebar' => $this->cbconfig->item('sidebar_poll'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_poll'),
            'skin_dir' => $this->cbconfig->item('skin_poll'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_poll'),
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );
        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }
}

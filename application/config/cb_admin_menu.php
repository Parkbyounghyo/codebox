<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *--------------------------------------------------------------------------
 *Admin Page 에 보일 메뉴를 정의합니다.
 *--------------------------------------------------------------------------
 *
 * Admin Page 에 새로운 메뉴 추가시 이곳에서 수정해주시면 됩니다.
 *
 */


$config['admin_page_menu'] = array(
	'config'                                   => array(
		'__config'                           => array('환경설정', 'fa-gears'), // 1차 메뉴, 순서대로 (메뉴명, 아이콘클래스(font-awesome))
		'menu'                                => array(
			'cbconfigs'                     => array('기본환경설정', ''), // 2차 메뉴, 순서대로 (메뉴명, a태그에 속성 부여)
			'layoutskin'                    => array('레이아웃/메타태그', ''),
			'memberconfig'            => array('회원가입설정', ''),
			'emailform'                    => array('메일/쪽지발송양식', ''),
			'rssconfig'                       => array('RSS 피드 / 사이트맵', ''),
			'testemail'                      => array('메일발송테스트', ''),
			'scheduler'                     => array('스케쥴러 관리', ''),
			'cbversion'                      => array('버전정보', ''),
			'dbupgrade'                   => array('DB 업그레이드', ''),
			'browscapupdate'         => array('Browscap 업데이트', ''),
			'optimize'                      => array('복구/최적화', ''),
			'cleanlog'                       => array('오래된로그삭제', ''),
			'phpinfo'                        => array('phpinfo', 'target="_blank"'),
		),
	),
	'page'                                     => array(
		'__config'                           => array('페이지설정', 'fa-laptop'),
		'menu'                                => array(
			'pagemenu'                   => array('메뉴관리', ''),
			'document'                    => array('일반페이지', ''),
			'popup'                          => array('팝업관리', ''),
			'faqgroup'                      => array('FAQ관리', ''),
			'faq'                                => array('FAQ 내용', '', 'hide'),
			'banner'                          => array('배너관리', ''),
			'bannerclick'                  => array('배너클릭로그', ''),
		),
	),
	'member'                               => array(
		'__config'                           => array('회원설정', 'fa-users'),
		'menu'                                => array(
			'members'                      => array('회원관리', ''),
			'membergroup'             => array('회원그룹관리', ''),
			'points'                           => array('포인트관리', ''),
			'memberfollow'            => array('팔로우현황', ''),
			'nickname'                     => array('닉네임변경이력', ''),
			'memberlevelhistory'    => array('레벨히스토리', ''),
			'loginlog'                       => array('로그인현황', ''),
			'dormant'                      => array('휴면계정관리', ''),
		),
	),
	'board'                                   => array(
		'__config'                          => array('게시판설정', 'fa-pencil-square-o'),
		'menu'                               => array(
			'boards'                          => array('게시판관리', ''),
			'boardgroup'                 => array('게시판그룹관리', ''),
			'trash'                             => array('휴지통', ''),
			'trash_comment'          => array('휴지통', '', 'hide'),
			'posthistory'                  => array('게시물변경로그', ''),
			'naversyndilog'             => array('네이버신디케이션로그', ''),
			'post'                             => array('게시물관리', ''),
			'comment'                    => array('댓글관리', ''),
			'tag'                               => array('태그 관리', ''),
			'fileupload'                   => array('파일업로드', ''),
			'filedownload'              => array('파일다운로드', ''),
			'editorimage'                => array('에디터이미지', ''),
			'linkclick'                       => array('링크클릭', ''),
			'like'                               => array('추천/비추', ''),
			'blame'                          => array('신고', ''),
		),
	),
	'stat' => array(
		'__config'                           => array('통계관리', 'fa-bar-chart-o'),
		'menu'                                => array(
			'statcounter'                   => array('접속자통계', ''),
			'boardcounter'               => array('게시판별접속자', ''),
			'registercounter'             => array('회원가입통계', ''),
			'searchkeyword'            => array('인기검색어현황', ''),
			'currentvisitor'                => array('현재접속자', ''),
			'registerlog'                    => array('회원가입경로', ''),
		),
	),
	'sms'                                       => array(
		'__config'                           => array('SMS 설정', 'fa-phone'),
		'menu'                                => array(
			'smsconfig'                     => array('SMS 환경설정', ''),
			'memberupdate'            => array('회원정보 업데이트', ''),
			'smssend'                       => array('문자발송하기', ''),
			'smshistory'                    => array('전송내역(건별)', ''),
			'smshistorynum'            => array('전송내역(번호별)', ''),
			'smsfavorite'                   => array('자주보내는 문자관리', ''),
			'phonegroup'                => array('휴대폰번호그룹', ''),
			'phonelist'                      => array('휴대폰번호관리', ''),
		),
	),
	'cmall'                                    => array(
		'__config'                           => array('컨텐츠몰관리', 'fa-shopping-cart'),
		'menu'                                => array(
			'cmallconfig'                  => array('컨텐츠몰환경설정', ''),
			'emailform'                    => array('메일/쪽지발송양식', ''),
            'cmallorder'                    => array('주문내역', ''),
			'pendingbank'               => array('무통장입금알림', ''),
			'orderlist'                        => array('구매내역', ''),
			'cmallcategory'              => array('분류관리', ''),
			'cmallitem'                     => array('상품관리', ''),
			'qna'                               => array('상품문의', ''),
			'review'                          => array('상품사용후기', ''),
			'wishlist'                         => array('보관함현황', ''),
			'cmallcart'                      => array('장바구니현황', ''),
			'itemdownload'            => array('상품다운로드로그', ''),
			'itemhistory'                  => array('상품내용변경로그', ''),
			'linkclick'                        => array('상품데모링크클릭', ''),
			'cmallstat'                      => array('구매통계', ''),
		),
	),
	'deposit'                                 => array(
		'__config'                           => array('예치금관리', 'fa-money'),
		'menu'                                => array(
			'depositconfig'               => array('예치금환경설정', ''),
			'emailform'                    => array('메일/쪽지발송양식', ''),
			'pendingbank'               => array('무통장입금알림', ''),
			'depositlist'                    => array('예치금변동내역', ''),
			'depositstat'                   => array('예치금통계', ''),
		),
	),
	'service'                                  => array(
		'__config'                          => array('기타기능', 'fa-plug'),
		'menu'                               => array(
			'levelupconfig'              => array('레벨업 설정', ''),
			'pointrankingconfig'    => array('포인트 랭킹', ''),
			'pollconfig'                   => array('설문조사', ''),
			'attendanceconfig'       => array('출석체크', ''),
		),
	),
);

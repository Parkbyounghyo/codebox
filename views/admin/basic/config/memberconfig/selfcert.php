<div class="box">
    <div class="box-header">
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir); ?>" onclick="return check_form_changed();">기본정보</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/registerform'); ?>" onclick="return check_form_changed();">가입폼관리</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/membermodify'); ?>" onclick="return check_form_changed();">정보수정시</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/login'); ?>" onclick="return check_form_changed();">로그인</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/alarm'); ?>" onclick="return check_form_changed();">알림 설정</a></li>
            <li role="presentation"><a href="<?php echo admin_url($this->pagedir . '/sociallogin'); ?>" onclick="return check_form_changed();">소셜로그인</a></li>
            <li role="presentation" class="active"><a href="<?php echo admin_url($this->pagedir . '/selfcert'); ?>" onclick="return check_form_changed();">본인 확인 서비스</a></li>
        </ul>
    </div>
    <div class="box-table">
        <?php
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('alert_message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'fadminwrite', 'id' => 'fadminwrite');
            echo form_open(current_full_url(), $attributes);
        ?>
                <input type="hidden" name="is_submit" value="1" />
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">본인확인 서비스 기능</label>
                        <div class="col-sm-10">
                            <label for="use_selfcert" class="checkbox-inline">
                                <input type="checkbox" name="use_selfcert" id="use_selfcert" value="1" <?php echo set_checkbox('use_selfcert', '1', (element('use_selfcert', element('data', $view)) ? true : false)); ?> /> 사용합니다
                            </label>
                            <div class="help-block">회원 가입시 본인확인 서비스를 사용하기 원하시는 경우 체크합니다</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">회원가입시 본인확인 필수</label>
                        <div class="col-sm-10">
                            <label for="use_selfcert_required" class="checkbox-inline">
                                <input type="checkbox" name="use_selfcert_required" id="use_selfcert_required" value="1" <?php echo set_checkbox('use_selfcert_required', '1', (element('use_selfcert_required', element('data', $view)) ? true : false)); ?> /> 사용합니다
                            </label>
                            <div class="help-block">회원가입시 본인확인을 하지 않은 회원은 회원가입이 불가능합니다. 선택하지 않으면 본인확인을 하지 않아도 회원가입이 가능합니다</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">본인확인 회수 제한</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="selfcert_try_limit" id="selfcert_try_limit" value="<?php echo set_value('selfcert_try_limit', element('selfcert_try_limit', element('data', $view)) + 0); ?>" />회, <span class="help-inline"> 하루 동안 한 회원이 시도할 수 있는 회수를 제한할 수 있습니다. 0 으로 설정하시면 제한하지 않습니다</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">테스트 여부</label>
                        <div class="col-sm-10">
                            <label for="use_selfcert_test" class="checkbox-inline">
                                <input type="checkbox" name="use_selfcert_test" id="use_selfcert_test" value="1" <?php echo set_checkbox('use_selfcert_test', '1', (element('use_selfcert_test', element('data', $view)) ? true : false)); ?> /> 테스트합니다
                            </label>
                            <div class="help-block">개발시에는 테스트하기로 체크 후 사용하시면 개발에 용이합니다</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">아이핀 본인확인</label>
                        <div class="col-sm-10 form-inline">
                            <select name="use_selfcert_ipin" class="form-control" id="use_selfcert_ipin">
                                <option value="" <?php echo set_select('use_selfcert_ipin', '', ( ! element('use_selfcert_ipin', element('data', $view)) ? true : false)); ?> >사용하지 않음</option>
                                <option value="kcb" <?php echo set_select('use_selfcert_ipin', 'kcb', (element('use_selfcert_ipin', element('data', $view)) === 'kcb' ? true : false)); ?> >코리아크레딧뷰로(KCB) 아이핀</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">휴대폰 본인확인</label>
                        <div class="col-sm-10 form-inline">
                            <select name="use_selfcert_phone" class="form-control" id="use_selfcert_phone">
                                <option value="" <?php echo set_select('use_selfcert_phone', '', ( ! element('use_selfcert_phone', element('data', $view)) ? true : false)); ?> >사용하지 않음</option>
                                <option value="kcb" <?php echo set_select('use_selfcert_phone', 'kcb', (element('use_selfcert_phone', element('data', $view)) === 'kcb' ? true : false)); ?> >코리아크레딧뷰로(KCB) 휴대폰 본인확인</option>
                                <option value="kcp" <?php echo set_select('use_selfcert_phone', 'kcp', (element('use_selfcert_phone', element('data', $view)) === 'kcp' ? true : false)); ?> >한국사이버결제(KCP) 휴대폰 본인확인</option>
                                <!--option value="lg" <?php echo set_select('use_selfcert_phone', 'lg', (element('use_selfcert_phone', element('data', $view)) === 'lg' ? true : false)); ?> >LG유플러스 휴대폰 본인확인</option-->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">코리아크레딧뷰로<br />KCB 회원사ID</label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" class="form-control" name="selfcert_kcb_mid" id="selfcert_kcb_mid" value="<?php echo set_value('selfcert_kcb_mid', element('selfcert_kcb_mid', element('data', $view))); ?>" />
                            <div class="help-block">KCB 에서 받은 회원 ID 를 입력해주세요</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">한국사이버결제<br />KCP 사이트코드</label>
                        <div class="col-sm-10 form-inline">
                            <input type="text" class="form-control" name="selfcert_kcp_mid" id="selfcert_kcp_mid" value="<?php echo set_value('selfcert_kcp_mid', element('selfcert_kcp_mid', element('data', $view))); ?>" />
                            <div class="help-block">KCP 에서 받은 SITE CODE 를 입력해주세요</div>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="col-sm-2 control-label">LG유플러스 상점아이디</label>
                        <div class="col-sm-10 form-inline">
                            상점아이디 <input type="text" class="form-control" name="selfcert_lg_mid" id="selfcert_lg_mid" value="<?php echo set_value('selfcert_lg_mid', element('selfcert_lg_mid', element('data', $view))); ?>" />
                            MERT KEY <input type="text" class="form-control" name="selfcert_lg_key" id="selfcert_lg_key" value="<?php echo set_value('selfcert_lg_key', element('selfcert_lg_key', element('data', $view))); ?>" />
                            <div class="help-block">LG유플러스 에서 받은 상점아이디와 와 MERT KEY 를 입력해주세요</div>
                        </div>
                    </div-->
                    <div class="btn-group pull-right" role="group" aria-label="...">
                        <button type="submit" class="btn btn-success btn-sm">저장하기</button>
                    </div>
                </div>
        <?php
            echo form_close();
        ?>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
var form_original_data = $('#fadminwrite').serialize();
function check_form_changed() {
    if ($('#fadminwrite').serialize() !== form_original_data) {
        if (confirm('저장하지 않은 정보가 있습니다. 저장하지 않은 상태로 이동하시겠습니까?')) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}
//]]>
</script>

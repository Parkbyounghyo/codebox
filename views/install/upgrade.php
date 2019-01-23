<div class="contents">
    <h2>업그레이드</h2>
<?php if ($need_install_ip) { ?>
    <div class="cont">
        <p style="font-size:14px;height:200px;">
            업그레이드를 진행하기 위해서는 현재 접속하고 계신 IP를 application/config/cb_config.php 파일에 &dollar;config&lsqb;&apos;install_ip&apos;&rsqb; 변수에 등록해주십시오. <br />
            현재 접속하고 계신 IP는 <strong><?php echo $this->input->ip_address(); ?></strong> 로 확인되고 있습니다.
        </p>
    </div>
<?php } elseif ($already_installed) { ?>
    <div class="cont">
        <p style="font-size:14px;height:200px;">
            social 테이블이 발견되는 것으로 보아, 이미 프리미엄 버전이 설치된 듯 합니다. <br />
            이 페이지는 베이직용 디비 테이블을 프리미엄용 디비 테이블로 업그레이드하는 페이지입니다.
        </p>
    </div>
<?php } elseif ($done) { ?>
    <div class="cont">
        <p style="font-size:14px;height:200px;">
            업그레이드가 완료되었습니다. 감사합니다
        </p>
    </div>
<?php } else { ?>
    <div class="cont">
        <p style="font-size:14px;height:200px;">
            이 페이지는 베이직 버전용 데이터베이스를 프리미엄 버전용 데이터베이스로 업그레이드 하는 페이지입니다. <br />
            기존 베이직 버전으로 운영하던 디비 데이터는 손실되지 않으며, 프리미엄 버전에서 사용할 수 있는 데이터베이스로 테이블 구조를 업그레이드합니다. <br />
            업그레이드를 진행하실려면 아래에 '업그레이드 하기' 버튼을 클릭하여 주세요
        </p>
    </div>
<?php } ?>
</div>

<?php
if ($do_upgrade) {
    $attributes = array('name' => 'fcheck', 'id' => 'fcheck');
    echo form_open(site_url('install/upgrade/process'), $attributes);
?>
<!-- footer start -->
<div class="footer">
    <button type="submit" class="btn btn-default btn-xs pull-right">업그레이드 하기 <i class="glyphicon glyphicon-chevron-right"></i></button>
</div>
<?php
    echo form_close();
}

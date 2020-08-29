<?php
include __DIR__ . '/Form.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>表单美化组件</title>
	<link rel="stylesheet" href="./css.css">
	<script src="https://www.jq22.com/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	<script language="javascript">
		$(function() {
			function test(func) {
				var start = new Date().getTime();
				func();
				var end = new Date().getTime();
				return (end - start) + "ms";
			}
			$('.form').inform();

		});
	</script>
</head>

<body>
	<div class="form">
		<form action="" method="get">
			<div class="item">
				<span>用户名：</span>
				<label>
					<?= \form\FormBuilder::text('named') ?>
				</label>
			</div>
			<div class="item">
				<span>密　码：</span>
				<label>
					<?= \form\FormBuilder::password('password') ?>
				</label>
			</div>
			<div class="item">
				<span>性　别：</span>
				<?= \form\FormBuilder::radio('rado', ['1' => '下课', '2' => '上课'], '2', ['data-id' => 1]) ?>

			</div>
			<div class="item">
				<span>学　历：</span>
				<label>
				<?= \form\FormBuilder::select('rado', ['1' => '下课', '2' => '上课'], '', ['data-id' => 1]) ?>

				</label>
			</div>
			<div class="item">
				<span>学　历：</span>
				<label>
				<?= \form\FormBuilder::selects('rado', ['1'=>['label'=>'高学历','child'=>['2'=>'高中','9'=>'大学']],'3'=>'北京','4'=>'上海','5'=>'广州' ], '9', ['data-id' => 1]) ?>
				</label>
			</div>
		
			<div class="item">
				<span>爱　好：</span>
				<?= \form\FormBuilder::checkbox('rado', ['1' => '下课', '2' => '上课'], [], ['data-id' => 1]) ?>
			</div>
			<div class="item">
				<span>备　注：</span>
				<label>
				<?= \form\FormBuilder::textarea('named',"",['class'=>'width']) ?>
				</label>
			</div>
			<div class="item">
				<span></span>
				<label><button type="submit">提交</button></label>
				<label><button type="reset">重置</button></label>
			</div>
		</form>
	</div>
</body>

</html>
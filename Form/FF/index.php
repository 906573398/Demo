<?php
include __DIR__ . '/Form.php';
$list  = [['id' => 1, 'name' => '芝加哥公牛', 'desc' => 1], ['id' => 2, 'name' => '克里夫兰', 'desc' => 2], ['id' => 3, 'name' => '底特律活塞', 'desc' => 3]];


// $se = json_encode($se);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
	<script src="./js/jQuery.upload.min.js"></script>
	<link rel="stylesheet" href="./css/upload.css">
	<link rel="stylesheet" href="./css/btn.css">
	<script type="text/javascript" src="js/jquery.form.js?id=2"></script>
	<script type="text/javascript" src="js/EZView.js?id=1"></script>
	<script type="text/javascript" src="js/draggable.js?id=1"></script>
	<link rel="stylesheet" href="./css.css">
	<link rel="stylesheet" href="./SelectPage/selectpage.css" type="text/css">
	<script type="text/javascript" src="./SelectPage/selectpage.min.js?id=4"></script>


</head>

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

<body>


	<div class="form">
		<form action="" method="get">

			<div class="item">
				<span>用户名1：</span>
				<label>

					<?= \form\FormBuilder::selectPage('selectPage1', '1,2', ['width' => '20em']) ?>

				</label>
			</div>

			<br /><br /><br />

			<div class="item">
				<span>用户名：</span>
				<label>
					<?= \form\FormBuilder::text('name', '', ['width' => '20em']) ?>
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
				<?= \form\FormBuilder::radio('radio', ['1' => '下课', '2' => '上课'], '2', ['data-id' => 1]) ?>

			</div>
			<div class="item">
				<span>学　历：</span>
				<label>
					<?= \form\FormBuilder::select('select', ['1' => '下课', '2' => '上课'], '', ['data-id' => 1]) ?>

				</label>
			</div>
			<div class="item">
				<span>学　历：</span>
				<label>
					<?= \form\FormBuilder::selects('selects', ['1' => ['label' => '高学历', 'child' => ['2' => '高中', '9' => '大学']], '3' => '北京', '4' => '上海', '5' => '广州'], '9', ['data-id' => 1]) ?>
				</label>
			</div>

			<div class="item">
				<span>爱　好：</span>
				<?= \form\FormBuilder::checkbox('checkbox', ['1' => '下课', '2' => '上课'], [], ['data-id' => 1]) ?>
			</div>
			<div class="item">
				<span>备　注：</span>
				<label>
					<?= \form\FormBuilder::textarea('textarea', "", ['class' => 'width']) ?>
				</label>
			</div>


			<div class="item">
				<span>备　注：</span>
				<?= \form\FormBuilder::images('images', "./images/1.png,./images/2.png", ['data-type' => 'jpg,png,mp4']) ?>
			</div>



			<div class="container">
				<button type="button" class='btn'>提交</button>

			</div>

		</form>




	</div>

</body>


<script>
	$(function() {


		var tag_datas = {};

		$.ajax({
			type: "post",
			url: './dd.php',

			async: false, //重点
			dataType: 'json',
			success: function(res) {
				tag_datas = res;
			}
		});



		$('#selectPage').selectPage({
			showField: 'name',
			keyField: 'id',
			data: tag_datas,
			multiple: true,
			//selected item callback
			//data: item raw data
			eSelect: function(data) {
				$('#callbackLog').append(data.name);
			},
			//removed item callback
			//data: items raw data(Array)
			eTagRemove: function(datas) {
				if (datas && datas.length) {
					for (var i = 0; i < datas.length; i++) {
						$('#callbackLog').append(datas[i].name);
					}
				}
			}
		});




		$("#case3").upload(
			function(_this, data) {
				alert(data);
				// $(_this).EZView();
			}
		)

		$('.btn').click(function() {


			$('#selectPage_text').remove(); //implode
			let d = {};
			let t = $('form').serializeArray();
			$.each(t, function() {

				var str = "";
				d[this.name] = this.value;
				if (this.name == 'row[checkbox]') {

					$("input[name='row[checkbox]']:checked").each(function(index, item) {
						if ($("input[name='row[checkbox]']:checked").length - 1 == index) {
							str += $(this).val();
						} else {
							str += $(this).val() + ",";
						}
					});

					d['row[checkbox]'] = str;
					// 	if(d['row[selectPage]_text'] == "row[selectPage]_text" ){
					// 	delete d['row[selectPage]_text'];
					// }


				}




			})

			console.log(d);
		})

	})
</script>

</html>
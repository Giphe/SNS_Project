<?php

?>
<!DOCTYPE html>　<!-- HTML5のDOCTYPE宣言 -->
<html lang="ja">　<!-- lang属性 日本語であることを宣言 -->
<head>
	<meta charset="UTF-8">　<!-- 文字コードをUTF-8にする -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">　<!-- ビューポートを指定 -->

	<!-- タイトル -->
	<title>文字ジェネレーター</title>
    <!-- bootstrap4 CDN CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
	<div class="container">
	<button type="button" onclick="history.back()">戻る</button>
		<div class="row">
			<div class="col-12">
				<!-- ------------------------------------------------------------------------- -->
				<!-- SVG要素 -->
				<!-- SVGフォントに源ノ角ゴシック（https://github.com/adobe-fonts/source-han-sans）を使用しています -->
				<!-- Licensed under SIL Open Font License 1.1 (http://scripts.sil.org/OFL) -->
				<!-- ------------------------------------------------------------------------- -->
				<div class="form-group mt-5 text-center" >

					<!--xml version="1.0" encoding="utf-8"?>-->
					<!-- Generator: Adobe Illustrator 23.0.4, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
					<svg version="1.1" id="svg-generator" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
							y="0px" viewBox="0 0 506 253" style="enable-background:new 0 0 506 253;" xml:space="preserve" width="506" height="253">
						<style type="text/css">
							@font-face {font-family:SourceHanSansJP-Heavy-83pv-RKSJ-H;src:url("data:application/x-font-woff;base64,d09GRk9UVE8AEp4wAAkAAAAY...")}
							.st0{fill:#FFFFFF;}
							.st1{font-family:'SourceHanSansJP-Heavy-83pv-RKSJ-H';}
							.st2{font-size:90px;}
							.st3{fill:#FF0000;}
						</style>
						<rect width="506" height="253"/>
						<text transform="matrix(1 0 0 1 28 163.7373)"><tspan x="0" y="0" class="st0 st1 st2" id="text-1">文字の</tspan><tspan x="270" y="0" class="st3 st1 st2" id="text-2">生成</tspan></text>
					</svg>

				</div>
				<!-- ------------------------------------------------------------------------- -->
				<!-- テキスト入力・画像取得ボタン -->
				<!-- ------------------------------------------------------------------------- -->
				<div class="form-group mt-5 row">
					<div class="col-sm-6">
						<input type="text" class="form-control svg-text" data-target="#text-1" value="文字の" placeholder="文字を入力してください">
					</div>
					<div class="col-sm-6">
						<input type="text" class="form-control svg-text" data-target="#text-2" value="生成" placeholder="文字を入力してください">
					</div>
				</div>

				<div class="form-group mt-5 text-center">
					<button class="btn btn-info" id="create-image">画像を取得</button>
				</div>

			</div>
		</div>
	</div>

	<!-- ------------------------------------------------------------------------- -->
	<!-- モーダルダイアログ -->
	<!-- ------------------------------------------------------------------------- -->
	<div class="modal fade" id="svg-box">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">右クリック・長押しで保存</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<img src="" id="svg-image" style="width:100%;">
				</div>
			</div>
		</div>
	</div>



	<!-- ------------------------------------------------------------------------- -->
	<!-- JavaScript -->
	<!-- ------------------------------------------------------------------------- -->

	<!-- jQueryの読み込みを宣言 -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
	<!-- bootstrap4のJavascript読み込みを宣言 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script>

		//テキスト入力時のイベント　入力文字をSVGのTEXT要素に反映
		$('.svg-text').on('input',function(e) {
			let targetTspan=$(this).data('target');
			$(targetTspan).text($(this).val());
		});
		//画像取得ボタンクリック時のイベント　SVG要素を画像に変換し表示する
		$('#create-image').on('click',function(e) {
			//SVG要素をbase64エンコードしDataURI形式に変換
			let svgElem = document.getElementById('svg-generator');
			let svgStr = new XMLSerializer().serializeToString(svgElem);
			let svgBase64 = "data:image/svg+xml;base64,"
				+ btoa(unescape(encodeURIComponent(svgStr)));

			// HTMLCanvasElement オブジェクトを作成する
			let canvas = document.createElement("canvas");
			// CanvasRenderingContext2D オブジェクトを取得する
			let ctx = canvas.getContext("2d");

			// 新たな img 要素を作成
			let image = new Image();
			image.onload = function(){
				//Retina対応しているブラウザだと画像がぼやけるため2倍にする
				canvas.width = image.width*2;
				canvas.height = image.height*2;

				//SVG画像をCanvasに描画
				ctx.drawImage( image,0,0,image.width,image.height,0,0,canvas.width,canvas.height);

				//Canvasに描画されている画像をBase64にエンコードしDataURI形式でsrc属性に設定
				$('#svg-image').attr('src',canvas.toDataURL("image/png"));

				//bootstrap4のモーダルを表示
				$('#svg-box').modal();
			}
			// Base64にエンコードしたSVG画像を設定
			image.src = svgBase64;
		});

	</script>
</body>
</html>
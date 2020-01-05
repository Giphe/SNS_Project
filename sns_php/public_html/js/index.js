$(function() {
  'use strict';

  //followタブ表示・非表示
//  $('.follow').on('click', function() {
//	  id++;
//    	if (id % 2 === 0) {
//	        $('li').find('.follow').addClass('done');
//    	} else {
//	        $('li').find('.follow').removeClass('done');
//    	}
//
//  });
//
//  //followerタブ表示・非表示
//  $('.follower').on('click', function() {
//	  id++;
//    	if (id % 2 === 0) {
//	        $('li').find('.follower').addClass('done');
//    	} else {
//	        $('li').find('.follower').removeClass('done');
//    	}
//
//  });


    // ①タブをクリックしたら発動
    $('.tab li').click(function() {

      // ②クリックされたタブの順番を変数に格納
      var index = $('.tab li').index(this);

      // ③画像を一旦非クリックの状態にリセットするためのループ処理
      $('.tab li img').each(function() {

        // ④_onのファイル名を_offに書き換え、変数に格納
        var file = $(this).attr('src').replace(/_on/g, '_off');

        // ⑤書き換えたファイル名をimg要素に適用する
        $(this).attr('src', file);
      });

      // ⑥改めてクリックされた画像のファイル名を_onに書き換え、変数に格納
      var file2 = $(this).children('img').attr('src').replace(/_off/g, '_on');

      // ⑦書き換えたファイル名をimg要素に適用する
      $(this).children('img').attr('src', file2);

      // ⑧コンテンツを一旦非表示にし、クリックされた順番のコンテンツのみを表示
      $('.area ul').removeClass('show').eq(index).addClass('show');

    });


  /* 単一更新update
   * @param id,mode,token
   */
  $('#users').on('click', '.update_user', function() {
    // idを取得
    var id = $(this).parents('li').data('id');
    // ajax処理
    $.post('_ajax.php', {
      id: id,
      mode: 'update',
      token: $('#token').val()
    }).done (function(res) {
      if (res.state === '1') {
        $('#user_' + id).find('.title').addClass('done');
        $('#user_' + id).find('.body').addClass('done');
        $('#user_' + id).find('.comment').addClass('done');
      } else {
        $('#user_' + id).find('.title').removeClass('done');
        $('#user_' + id).find('.body').removeClass('done');
        $('#user_' + id).find('.comment').removeClass('done');
      }
    }).fail (function(res) {
      alert('failed!');
    });
  });

  /* 単一物理削除delete
   * @param id,mode,token
   *
   */
  $('#users').on('click', '.delete_user', function() {
    // idを取得
    var id = $(this).parents('li').data('id');
    // ajax処理
    if (confirm('are you sure?')) {
      $.post('_ajax.php', {
        id: id,
        mode: 'delete',
        token: $('#token').val()
      }, function() {
        $('#user_' + id).fadeOut(800);
      });
    }
  });

  /* 全物理削除 all_delete, 一括物理削除 mole_delete
   * @param id,mode,token
   *
   */
  $('#users').on('click', '.all_delete', function() {
    // all_check項目の真偽を取得
    var check = $('.all_check').prop('checked');
    // all_deleteするかしないか。
    if (check) {
	    if (confirm('are you sure? [delete_all]')) {
	      $.post('_ajax.php', {
	        check: check,
	        mode: 'all_delete',
	        token: $('#token').val()
	      }, function() {
	        $('li').fadeOut(800);
	      });
	    }
	    alert('No [delete]');
	    return false;
    } else {
    	//all_deleteしないならばmole_deleteを実行
    	//
    	if (confirm('are you sure? [delete_mole]')) {
   	      $.post('_ajax.php', {
   	        check: check,
   	        mode: 'mole_delete',
   	        token: $('#token').val()
   	      }, function() {
   	        //liの子要素のinputにcheckedのついたものを順にfadeOutさせる
   	    	 $("input[type='checkbox']:checked").closest('li').fadeOut(800);
   	      });
   	    }

    }
  });


  /*
   * user新規作成 create
   * @param title, body, mode, token
   */
  $('#new_user_form').on('submit', function() {

    // title,bodyを取得
    var title = $('input[id="new_user"]').val();
    var body = $('textarea').val();
    // ajax処理
    $.post('_ajax.php', {
      title: title,
      body: body,
      mode: 'create',
      token: $('#token').val(),
    }).done (function(res) {
    	  console.log("ajax通信に成功しました");
	      // liを追加
	      var $li = $('li[id = user_template]').clone();
	      var $div = $('div[id = user_template]').clone();
	      $li
	        .attr('id', 'user_')
	        .data('id', res.user_id)
	        .find('.title').text(title);

	      $('#users').prepend($li.fadeIn());
	      $('#new_user').val('').focus();
	      $div
	      .attr('id', 'user_')
	      .data('id', res.user_id)
	      .find('.body').text(body);
	    $('#users').prepend($li.fadeIn());
	    $('#new_user').val('').focus();

      }).fail(function(res){
    	  return;
      });
    });

//    // logout
//    $('#logout').on('click',  function() {
//      // idを取得
//      if (confirm('are you sure?')) {
//        $.post('_ajax.php', {
//        	mode: 'logout',
//        	token: $('#token').val()
//        });
//      }
//    });

    return false;


});
$ = KISSY.all;
$.log = function(msg) {
	if(console)
		console.log(msg);
}
KISSY.ready(loadAllSlides);

function loadAllSlides() {
	var row_per = $('#row-add');
	$('#table-body').html('');
	for(var i = 0; i < UED_SLIDES.length; i++) {
		var s = UED_SLIDES[i];
		s.id = i;
		insertSlide(s);
	}
	$('#table-body').append(row_per);
}

function insertSlide(slide) {
	$('<tr id="row-' + slide.id + '" class="row">')
	.append($('<td>').html('<div><span id="row-url-' + slide.id + '">' + slide.url + '</span><input id="edit-url-' + slide.id + '" class="edit row-edit" value="' + slide.url + '"/></div>'))
	.append($('<td>').html('<div><span id="row-link-' + slide.id + '">' + (slide.link==null? '&nbsp':slide.link) + '</span><input id="edit-link-' + slide.id + '" class="edit row-edit" value="' +slide.link + '"/></div>'))
	.append($('<td>').html('<div><span id="row-alt-' + slide.id + '">' + (slide.alt==null? '&nbsp':slide.alt) + '</span><input id="edit-alt-' + slide.id + '" class="edit row-edit" value="' +slide.alt + '"/></div>'))
	.append($('<td>').html('<div><span id="row-desc-' + slide.id + '">' + (slide.describe == null ? '&nbsp' : slide.describe) + '</span><input id="edit-desc-' + slide.id + '" class="edit row-edit" value="' + (slide.describe == null ? '' : slide.describe) + '"/></div>'))
	.append($('<td class="cell-extra">').html('<a id="edit-' + slide.id + '" href="javascript:editRow(' + slide.id + ');">编辑</a>')).append($('<td class="cell-extra">').html('<a id="del-' + slide.id + '" href="javascript:delRow(' + slide.id + ');">删除</a>')).appendTo($('#table-body')).on('mouseover', function() {
		$(this).addClass('row-hover');
	}).on('mouseleave', function() {
		$(this).removeClass('row-hover');
	});

	$('#row-' + slide.id + " .edit").on('focus', function() {
		$(this).css({
			'border-color' : '#ff6600'
		});
		this.select();
	}).on('blur', function() {
		$(this).css({
			'border-color' : 'green'
		});
	});
}

function addRow() {
	var url = KISSY.trim($('#edit-add-url').val());
	var alt = $('#edit-add-alt').val();
	var link = $('#edit-add-link').val();
	var describe = $('#edit-add-desc').val();
	if(url == '') {
		alert("图片路径不能为空.");
		return;
	}
	UED_SLIDES.push({
		"id" : UED_SLIDES.length,
		"url" : url,
		"alt" : alt,
		"describe" : describe
	});
	updateSlides(function() {
		$('#edit-add-url').val('');
		$('#edit-add-link').val('');
		$('#edit-add-alt').val('');
		$('#edit-add-desc').val('');
	});
}

function editRow(id) {
	if($('#edit-url-' + id).css('display') != 'none') {
		var url = KISSY.trim($('#edit-url-' + id).val());
		var link=$('#edit-link-'+id).val();
		var alt = $('#edit-alt-' + id).val();
		var describe = $('#edit-desc-' + id).val();
		if(url == '') {
			alert("图片路径不能为空");
			return;
		}
		for(var i = 0; i < UED_SLIDES.length; i++) {
			var s = UED_SLIDES[i];
			if(s.id == id) {
				s.url = url;
				s.alt = alt;
				s.link=link;
				s.describe = describe;
				updateSlides();
				break;
			}
		}
	} else {
		$('#edit-url-' + id).show();
		$('#edit-link-' + id).show();
		$('#edit-alt-' + id).show();
		$('#edit-desc-' + id).show();
		$('#edit-' + id).html("保存");
		$('#del-' + id).html("取消");
	}
}

function delRow(id) {
	if($('#edit-url-' + id).css('display') != 'none') {
		$('#edit-url-' + id).hide();
		$('#edit-link-' + id).hide();
		$('#edit-alt-' + id).hide();
		$('#edit-desc-' + id).hide();
		$('#edit-' + id).html("编辑");
		$('#del-' + id).html("删除");
	} else {
		if(confirm("确定删除?") == false)
			return;
		for(var i = 0; i < UED_SLIDES.length; i++) {
			if(UED_SLIDES[i].id == id) {
				UED_SLIDES.splice(i, 1);
				break;
			}
		}
		updateSlides();
	}
}

function updateSlides(callBack) {
	for(var i = 0; i < UED_SLIDES.length; i++) {
		delete UED_SLIDES[i].id;
	}
	var data = KISSY.JSON.stringify(UED_SLIDES);

	KISSY.io.post(ajaxurl, {
		'action' : 'ued_update_slide',
		'type' : UED_SLIDE_TYPE,
		'data' : data
	}, function(rtn) {
		if(rtn.state == "success") {
			UED_SLIDES = KISSY.JSON.parse(rtn.data);
			loadAllSlides();
			if( typeof callBack === 'function')
				callBack();
		}
	}, "json");
}
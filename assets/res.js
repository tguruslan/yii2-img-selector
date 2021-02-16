/*
 кол-бек когда выбирается файл в списке у менеджера файлов
 */
function ImageSelectorCallBack(fieldId) {
	if (fieldId) {
		var obj, url;
		obj = $('#' + fieldId);
		url = obj.val();
		obj.val(url);
		setPreviewBoxImg(fieldId, url);
		$('.fancybox-close').trigger('click');
	}
}

/*
 обнуление картнки в поле
 */
$(document).on('click', '.js_RemoveImg', function (e) {
	var self, fieldId;
	self = $(this);
	fieldId = self.attr('data-img-id');
	$('#' + fieldId).val('');
	setPreviewBoxImg(fieldId, '');
});

/*
 на нужных ссылках инициализируем фанси-бокс
 */
function initImageSelectorPopups() {
	$('.iframe-btn').fancybox({
		'width': 900,
		'height': 600,
		'type': 'iframe',
		'autoSize': false
	});
}

/**
 * очищаем див с превьюшкой
 *
 * @param fieldId
 * @param url
 * @returns {*|jQuery}
 */
function setPreviewBoxImg(fieldId, url) {
	return $('#' + 'preview__' + fieldId).css('background-image', 'url("' + url + '")');
}

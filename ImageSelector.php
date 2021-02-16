<?php

namespace tguruslan\yii2\imgSelector;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use yii\base\ErrorException;

class ImageSelector extends InputWidget {
	/** @var string путь к Responsive File Manager */
	public $fileManagerPathTpl;

	// например: '/admin/plugins/responsivefilemanager/filemanager/dialog.php?type=1&field_id=%s&relative_url=0&callback=ImageSelectorCallBack'

	public function run() {
		// если не настроен путь - говорим про это
		if (!$this->fileManagerPathTpl) {
			throw new ErrorException('Укажите fileManagerPathTpl в bootstrap.php для tguruslan\yii2\imgSelector\ImageSelector');
		}
		// иначе начинаем конфигурироваться
		if (!array_key_exists('class', $this->options)) {
			$this->options['class'] = 'form-control';
		}
		$this->options = array_merge($this->options, ['readonly' => true]);
		$input         = Html::textInput($this->name, $this->value, $this->options);
		if ($this->hasModel()) {
			$input = Html::activeTextInput($this->model, $this->attribute, $this->options);
		}
		$url          = sprintf($this->fileManagerPathTpl, $this->options['id']);
		$selectImgBtn = Html::a("<i class='glyphicon glyphicon-folder-open' aria-hidden='true'></i>", $url, [
			'class' => 'btn iframe-btn btn-default input-group-addon',
			'type'  => 'button',
		]);
		$removeImgBtn = Html::tag('span', "<i class='glyphicon glyphicon-remove' aria-hidden='true'></i>", [
			'class'       => 'btn btn-default js_RemoveImg input-group-addon',
			'type'        => 'button',
			'data-img-id' => $this->options['id'],
		]);
		$imgPreview   = Html::tag('div', '&nbsp;', [
			'id'    => 'preview__' . $this->options['id'],
			'class' => 'imgSelectorPreview',
			'style' => 'background-image:url("' . $this->model->{$this->attribute} . '");',
		]);
		echo '
			<div class="row">
				<span class="col-sm-12"><div class="input-group">' . $input . $selectImgBtn . $removeImgBtn . '</div></span>
				<span class="col-sm-6 col-sm-offset-3">' . $imgPreview . '</span>
			</div>
		';

		$this->registerClientScript();
	}

	private function registerClientScript() {

		$view = $this->getView();

		static $init = null;
		if (is_null($init)) {
			$init = true;
			$view->registerJs('$( document ).ready(function() { initImageSelectorPopups(); });', \yii\web\View::POS_READY);
		}

		ImageSelectorAsset::register($view);

	}
}

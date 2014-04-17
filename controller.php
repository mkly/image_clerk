<?php
defined('C5_EXECUTE') or die('Access Denied.');

class ImageClerkPackage extends Package {

	protected $pkgHandle = "image_clerk";
	protected $appVersionRequired = "5.6";
	protected $pkgVersion = "0.1";

	public function getPackageName() {
		return t('Image Clerk');
	}

	public function getPackageDescription() {
		return t('Create permanent thumbnails');
	}

	public function install() {
		SinglePage::add('image_clerk', parent::install());
	}
}

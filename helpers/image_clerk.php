<?php
defined('C5_EXECUTE') or die('Access Denied.');

class ImageClerkHelper {

	public function __construct() {
		$this->valt = Loader::helper('validation/token');
		$this->img = Loader::helper('image');
	}

	public function getThumbnail($fID, $width, $height, $crop = 0) {
		$img = new StdClass;
		$img->src = $this->getSource($fID, $width, $height, (int) $crop);
		return $img;
	}

	public function outputThumbnail($fID, $width, $height, $crop = 0) {
	}

	public function validateToken($fID, $width, $height, $crop, $token) {
		return $this->valt->validate($this->buildTokenString($fID, $width, $height, $crop), $token);
	}

	public function buildTokenString($fID, $width, $height, $crop) {
		return implode(':', array($fID, $width, $height, $crop));
	}
	public function generateToken($fID, $width, $height, $crop) {
		return $this->valt->generate($this->buildTokenString($fID, $width, $height, $crop));
	}

	public function getSource($fID, $width, $height, $crop = 0) {
		$token = $this->generateToken($fID, $width, $height, $crop);
		return View::url('image_clerk', $fID, $width, $height, $crop, $token);
	}
}

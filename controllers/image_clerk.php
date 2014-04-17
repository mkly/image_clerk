<?php
defined('C5_EXECUTE') or die('Access Denied.');

class ImageClerkController extends Controller {

	public function view($fID, $width, $height, $crop, $token) {
		if (!Loader::helper('image_clerk', 'image_clerk')->validateToken($fID, $width, $height, $crop, $token)) {
			$this->redirect('/page_not_found');
		}
		$file = File::getByID($fID);
		if ($file->isError()) {
			$this->redirect('/page_not_found');
		}
		$img = Loader::helper('image')->getThumbnail($file, $width, $heigh, $crop);
		if (!isset($img->src)) {
			$this->redirect('/page_not_found');
		}
		$path = DIR_BASE . DIR_REL . $img->src;
		header('Content-Type: ' . $file->getMimeType());
		header('Content-Length: ' . filesize($path));
		readfile($path);
		exit;
	}
}

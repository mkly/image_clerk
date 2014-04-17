<?php
defined('C5_EXECUTE') or die('Access Denied.');

class ImageClerkHelper {

	public function __construct() {
		$this->valt = Loader::helper('validation/token');
		$this->img = Loader::helper('image');
	}

	/**
	 * @param File|int $fID File ID or File object
	 * @param int $width
	 * @param int $height
	 * @param int|bool $crop
	 */
	public function getThumbnail($fID, $width, $height, $crop = false) {
		$file = is_object($fID) ? $fID : File::getByID($fID);
		$img = $this->img->getThumbnail($file, $width, $height, $crop);
		$img->src = $this->getSource($fID, $width, $height, $crop);
		return $img;
	}

	/**
	 * @param File|int $fID File ID or File object
	 * @param int $width
	 * @param int $height
	 * @param string $alt
	 * @param bool $return
	 * @param bool $crop
	 * @return string|null
	 */
	public function outputThumbnail($fID, $width, $height, $alt = '', $return = false, $crop = false) {
		$img = $this->getThumbnail($fID, $width, $height, $crop);
		$html = '<img class="ccm-output-thumbnail" alt="' . $alt . '" src="' . $img->src . '" width="' . $img->width . '" height="' . $img->height . '" />';
		if ($return) {
			return $html;
		}
		echo $html;
	}

	/**
	 * @param File|int $fID File ID or File object
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @param string $token
	 * @return string
	 */
	public function validateToken($fID, $width, $height, $crop, $token) {
		return $this->valt->validate($this->buildTokenString($fID, $width, $height, $crop), $token);
	}

	/**
	 * @param File|int $fID File ID or File object
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @return string
	 */
	public function buildTokenString($fID, $width, $height, $crop) {
		return implode(':', array($fID, $width, $height, $crop));
	}

	/**
	 * @param File|int $fID File ID or File object
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @param string
	 */
	public function generateToken($fID, $width, $height, $crop) {
		return $this->valt->generate($this->buildTokenString($fID, $width, $height, $crop));
	}

	/**
	 * @param File|int $fID File ID or File object
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 * @param string
	 */
	public function getSource($fID, $width, $height, $crop = false) {
		$token = $this->generateToken($fID, $width, $height, $crop);
		return View::url('image_clerk', $fID, $width, $height, (int) $crop, urlencode($token));
	}
}

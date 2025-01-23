<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/**
 *  Cloudinary Helper
 */
class CloudinaryHelper
{
	protected static $dir;

	protected static function initialize()
	{
		if (is_null(self::$dir)) {
			self::$dir = env('CLOUDINARY_FOLDER', '');
		}
	}

	/**
	 * 	@param Illuminate\Http\UploadedFile $file
	 */
	public static function store(UploadedFile $file)
	{
		self::initialize();

		return Cloudinary::upload($file->getRealPath(), [
			"folder" => self::$dir,
		]);
	}


	/**
	 * 	@param Illuminate\Http\UploadedFile $newFile
	 * 	@param string $oldPublicId
	 */
	public static function update(UploadedFile $newFile, string $oldPublicId)
	{
		self::initialize();
		self::destroy($oldPublicId);

		return Cloudinary::upload($newFile->getRealPath(), [
			"folder" => self::$dir,
		]);
	}

	public static function destroy(string $publicId)
	{
		$exists = Storage::disk('cloudinary')->fileExists($publicId);

		if ($exists) {
			Cloudinary::destroy($publicId);
		}
	}
}

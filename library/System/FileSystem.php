<?php

namespace Illustrator\System;

use SplObjectStorage;
use FilesystemIterator;

class FileSystem
{
	protected $mimeTypes =
	[
		'aac'        => 'audio/aac',
		'atom'       => 'application/atom+xml',
		'avi'        => 'video/avi',
		'bmp'        => 'image/x-ms-bmp',
		'c'          => 'text/x-c',
		'class'      => 'application/octet-stream',
		'css'        => 'text/css',
		'csv'        => 'text/csv',
		'deb'        => 'application/x-deb',
		'dll'        => 'application/x-msdownload',
		'dmg'        => 'application/x-apple-diskimage',
		'doc'        => 'application/msword',
		'docx'       => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'exe'        => 'application/octet-stream',
		'flv'        => 'video/x-flv',
		'gif'        => 'image/gif',
		'gz'         => 'application/x-gzip',
		'h'          => 'text/x-c',
		'htm'        => 'text/htmlTemplate',
		'htmlTemplate'       => 'text/htmlTemplate',
		'ics'        => 'text/calendar',
		'ical'       => 'text/calendar',
		'ini'        => 'text/plain',
		'jar'        => 'application/java-archive',
		'java'       => 'text/x-java',
		'jpeg'       => 'image/jpeg',
		'jpg'        => 'image/jpeg',
		'js'         => 'text/javascript',
		'json'       => 'application/json',
		'jp2'        => 'image/jp2',
		'mid'        => 'audio/midi',
		'midi'       => 'audio/midi',
		'mka'        => 'audio/x-matroska',
		'mkv'        => 'video/x-matroska',
		'mp3'        => 'audio/mpeg',
		'mp4'        => 'video/mp4',
		'mpeg'       => 'video/mpeg',
		'mpg'        => 'video/mpeg',
		'm4a'        => 'video/mp4',
		'm4v'        => 'video/mp4',
		'odt'        => 'application/vnd.oasis.opendocument.text',
		'ogg'        => 'audio/ogg',
		'pdf'        => 'application/pdf',
		'php'        => 'text/x-php',
		'png'        => 'image/png',
		'psd'        => 'image/vnd.adobe.photoshop',
		'py'         => 'application/x-python',
		'ra'         => 'audio/vnd.rn-realaudio',
		'ram'        => 'audio/vnd.rn-realaudio',
		'rar'        => 'application/x-rar-compressed',
		'rss'        => 'application/rss+xml',
		'safariextz' => 'application/x-safari-extension',
		'sh'         => 'text/x-shellscript',
		'shtml'      => 'text/htmlTemplate',
		'swf'        => 'application/x-shockwave-flash',
		'tar'        => 'application/x-tar',
		'tif'        => 'image/tiff',
		'tiff'       => 'image/tiff',
		'torrent'    => 'application/x-bittorrent',
		'txt'        => 'text/plain',
		'wav'        => 'audio/wav',
		'webp'       => 'image/webp',
		'wma'        => 'audio/x-ms-wma',
		'xls'        => 'application/vnd.ms-excel',
		'xml'        => 'text/xml',
		'zip'        => 'application/zip',
		'3gp'        => 'video/3gpp',
		'3g2'        => 'video/3gpp2',
	];
	
	public function exists($file)
	{
		return file_exists($file);
	}
	
	public function isFile($file)
	{
		return is_file($file);
	}
	
	public function isWritable($file)
	{
		return is_writable($file);
	}
	
	public function isReadable($file)
	{
		return is_readable($file);
	}
	
	public function isUploaded($file)
	{
		return is_uploaded_file($file);
	}
	
	public function delete($file)
	{
		return unlink($file);
	}
	
	public function getContent($file)
	{
		return file_get_contents($file);
	}
	
	public function putContent($file, $write, $lock = null)
	{
		if(is_null($lock)) {
			return file_put_contents($file, $write, 0);
		}elseif(isset($lock)) {
			return file_put_contents($file, $write, $lock);
		}
		return null;
	}
	
	public function size($file)
	{
		return filesize($file);
	}
	
	public function getFiles($dir)
	{
		$scan = scandir($dir);
		foreach($scan as $file){
			if(!emptyt($file) && !strpos($file, '.') && !strpos($file, '..')) {
				return $file;
			}
		}
		
		return 'empty';
	}
	
	public function glob($pattern, $flag)
	{
		return glob($pattern, $flag);
	}
	
	public function modified($file)
	{
		return filemtime($file);
	}
	
	public function extension($file)
	{
		return pathinfo($file, PATHINFO_EXTENSION);
	}
	
	public function mime($mime)
	{
		return isset($this->mimeTypes[$mime]) ? $this->mimeTypes[$mime] : false;
	}
	
	public function isDir($dir)
	{
		return is_dir($dir);
	}
	
	public function storage($file)
	{
		return new SplObjectStorage($file);
	}
}
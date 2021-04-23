<?php
namespace App\Plugin;
use App\System\Plugins as Plugin_Core;
use League\Csv\Reader;
use League\Csv\Writer;

class Csv extends Plugin_Core {

	/**
	 * @var mixed
	 */
	protected $file;

	/**
	 * @param $file
	 */
	public function __construct() {

		// if (!is_readable($file)) {
		// 	exit("The file <code>'$file'</code> does not exist or cannot be opened.");
		// }

		// If your CSV document was created or is read on a Macintosh computer,
		// uncomment the following lines before using the library
		// to help PHP detect line ending in Mac OS X.

		# if (!ini_get("auto_detect_line_endings")) {
		#     ini_set("auto_detect_line_endings", '1');
		# }
	}

	/**
	 * @param $file
	 */
	public function read(string $file, $delimiter = ',', $escape = '') {
		$csv = Reader::createFromPath($file, 'r');
		$csv->setDelimiter($delimiter);
		$csv->setEscape($escape);
	}

	/**
	 * @param $file
	 */
	public function write(string $file) {
		$csv = Writer::createFromPath($file, 'w');
	}

	/**
	 * @param $file
	 * @return mixed
	 */
	public function download(string $file) {
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="' . $file . '"');

		$reader = Reader::createFromPath($file, 'r');
		$reader->output();
		exit;
	}

	/**
	 * @param string $file
	 * @param int $length
	 */
	public function chunk(string $file, int $length = 1024) {

		header('Transfer-Encoding: chunked');
		header('Content-Encoding: none');
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="$file"');

		$reader = Reader::createFromPath($file, 'r');
		foreach ($reader->chunk($length) as $chunk) {
			echo dechex(strlen($chunk)) . "\r\n$chunk\r\n";
		}
		echo "0\r\n\r\n";
	}

	/**
	 * @param string $file
	 * @param $delimiter
	 * @param $escape
	 * @return mixed
	 */
	public function outputFullContent(string $file, $delimiter = ',', $escape = '') {
		$csv = Reader::createFromPath($file, 'r');
		$csv->setDelimiter($delimiter);
		$csv->setEscape($escape);

		return $csv->toString();
	}

}
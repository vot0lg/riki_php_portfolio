<?php

namespace MyApp\Exception;

class InvalidFileType extends \Exception {

  protected $message = 'GIF, PNG, JPEG 形式のファイルを選択してください。';
}
<?php

namespace MyApp\Exception;

class InvalidEmail extends \Exception {

  protected $message = '正しいメールアドレスを記入してください';
}
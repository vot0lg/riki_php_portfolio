<?php

namespace MyApp\Exception;

class TooShortPassword extends \Exception {

  protected $message = '６文字以上のパスワードを記入してください';
}
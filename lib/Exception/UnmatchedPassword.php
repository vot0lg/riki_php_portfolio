<?php

namespace MyApp\Exception;

class UnmatchedPassword extends \Exception {

  protected $message = '正しいパスワードを入力してください';
}
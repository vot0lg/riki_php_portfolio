<?php

namespace MyApp\Exception;

class UnmatchedEmail extends \Exception {

  protected $message = '正しいメールアドレスを入力してください';
}
<?php

namespace MyApp\Exception;

class DuplicateEmail extends \Exception {

  protected $message = 'このメールアドレスはすでに登録されています';
}
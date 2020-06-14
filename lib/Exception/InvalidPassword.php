<?php

namespace MyApp\Exception;

class InvalidPassword extends \Exception {

  protected $message = '英数字で記入してください';
}
<?php

 namespace MyApp\Exception;

 class EmptyPost extends \Exception {
   protected $message = 'Please enter Email/password!';
 }

<?php
require_once 'autoload.php';

class DetectError
{
      public static function detectError(array $errors)
      {
            if (count($errors) > 0) {
                  echo '<div class="alert alert-danger"><ul>';
                  foreach ($errors as $error) {
                        echo '<li>' . $error . '</li>';
                  }
                  echo '</ul></div>';
            }
      }
}

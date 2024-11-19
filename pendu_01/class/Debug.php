<?php
require_once 'autoload.php';

class Debug extends DetectError
{
      /**
       * Constantes de classe
       * pour définir les classes CSS
       * @var string
       */
      const NAMECLASSWARNING = 'alert alert-warning';
      const NAMECLASSDANGER = 'alert alert-danger';

      /**
       * Méthode magique __set
       * @param string $name
       * @param string $value
       * @return void
       */
      public function __set(string $name, string $value): void
      {
            echo '<div class="' . self::NAMECLASSWARNING . '">La propriété <i>' . $name . '</i> n\'existe pas ou est privée. <b>' .  $value . '</b> ne peut être exploité.</div>';
      }

      /**
       * Méthode magique __get
       * @param string $name
       * @return void
       */
      public function __get(string $name): void
      {
            echo '<div class="' . self::NAMECLASSWARNING . '">La propriété <i>' . $name . '</i> n\'existe pas ou est privée.</div>';
      }

      /**
       * Méthode magique __call
       * @param string $name
       * @param array $arguments
       * @return void
       */
      public function __call(string $name, array $arguments): void
      {
            echo '<div class="' . self::NAMECLASSWARNING . '">La méthode <i>' . $name . '</i> n\'existe pas ou est privée. <b>' .  implode(', ', $arguments) . '</b> ne peut être exploité.</div>';
      }

      /**
       * Méthode de débug print_r ou var_dump
       * @param string $name
       * @param array $arguments
       * @return void
       */
      protected static function printDebug(array $element, int $mode = 0): void
      {
            echo '<pre>';
            if ($mode === 0) {
                  print_r($element);
            } else {

                  var_dump($element);
            }
            echo '</pre>';
      }
}

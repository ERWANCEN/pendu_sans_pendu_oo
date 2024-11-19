<?php

spl_autoload_register(function ($nomDeLaClasse) {
      require 'class/' . $nomDeLaClasse . '.php';
});

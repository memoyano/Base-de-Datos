<?php
// Config database params
return [
  'db' => [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '', // colocar su contraseña aqui
    'name' => 'ventas',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ]
];

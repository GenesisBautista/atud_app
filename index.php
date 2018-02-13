<?php
require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/View.php';
require 'libs/Model.php';
require 'libs/Database.php';
require 'libs/ImportExtended.php';
require 'libs/Session.php';
require 'libs/PHPExcel/IOFactory.php';

require 'config/db.php';
require 'config/path.php';
Session::init();
$app = new Bootstrap();

<?php

require_once('./Controllers/ViewsController.php');
require_once('./config/APP.php');

$vista = new ViewsControllers();

$vista->getTemplateController();
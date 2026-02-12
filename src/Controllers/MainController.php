<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;

class MainController extends MotherController
{
    
    public function home()
    {
        $this->_display("home");
    }
}

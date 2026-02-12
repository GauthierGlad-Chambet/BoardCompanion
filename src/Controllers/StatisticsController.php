<?php

namespace GauthierGladchambet\BoardCompanion\Controllers;

use GauthierGladchambet\BoardCompanion\Controllers\MotherController;

class StatisticsController extends MotherController
{

    public function dashboard()
    {
       $this->_display("statistics/dashboard");
    }
}

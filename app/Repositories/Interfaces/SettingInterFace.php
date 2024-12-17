<?php
namespace App\Http\Repositories\Interfaces;

use App\Http\Repositories\Interfaces\RepositoryInterface;

interface SettingInterFace extends RepositoryInterface
{
   public function loadSettingData();
}

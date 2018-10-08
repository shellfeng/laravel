<?php
//namespace AntBackup\Writer;
namespace App\Http\Utils\backup\Writer;
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-2-7
 * Time: 下午5:19
 */
interface Writer
{
    public function setConfig($datas);

    public function run($data);
}
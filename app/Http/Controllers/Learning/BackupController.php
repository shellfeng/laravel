<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/6/20
 * Time: 17:45
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use App\Http\Utils\backup\AntBackup;

class BackupController extends Controller
{

    /*********************备份数据库***********************/
    public function backup()
    {
        $data = [
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host'     => '127.0.0.1',
            'db_name'     => 'groupof',
            'file_name'   => '',
            'db_charset'  => 'utf8',
            'writer_type' => 'file',
            'file_path'   => 'backupdatabase/',
            'gz_write'    => true  // 是否开启gzip压缩,需gzip拓展
        ];
        $db = new AntBackup($data);
        $dt = $db->dbBackup();
        dump($dt);

        /*$data = [
            'writer_type' => 'file', // 目前只支持file
            'db_type'     => 'mysql',
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host'     => '127.0.0.1',
            'db_name'     => 'ctbms_db',
            'db_port'     => '3306',
            'db_charset'  => 'UTF-8',
            'file_path'   => '/phpstudy/www/BMS_3.0/data/backup', // 需读写权限
            'file_name'   => '', // 可为空
            'gz_write'    => true  // 是否开启gzip压缩,需gzip拓展
        ];
        $BC = new AntBackup($data);

        // 备份
        $rs = $BC->dbBackup();
        print_r($rs);

        // 获取备份列表
        $list = $BC->getBackupList();
        print_r($list);

        // 恢复指定文件
        $rs = $BC->dbRecover('20170208162648_backup.gz');
        var_dump($rs);*/
    }

    /**
     * 获取备份列表
     */
    public function getBackupList()
    {
        $data = [
            'db_username' => 'root',
            'db_password' => 'root',
            'db_host'     => '127.0.0.1',
            'db_name'     => 'groupof',
            'file_name'   => '',
            'db_charset'  => 'utf8',
            'writer_type' => 'file',
            'file_path'   => 'backupdatabase/',
            'gz_write'    => true  // 是否开启gzip压缩,需gzip拓展
        ];
        $db = new AntBackup($data);
        $list = $db->getBackupList();
        dump($list);
    }
}
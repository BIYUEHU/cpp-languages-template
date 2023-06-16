<?php
/**
 *
 * HULICore框架 - 入口
 *
 * @author   Biyuehu <biyuehu@gmail.com>
 * @link     https://github.com/BIYUEHU/hulicore
 * @version  1.0.0
 * @license  GPL-2.0
 */


/* 引入入口文件 */
require(__DIR__ . '../../Hulicore.php');

/* 运行 */
(new HuliMain\Hulicore())->run();

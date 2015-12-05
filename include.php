<?php

$xhprof_data = xhprof_disable();
$XHPROF_ROOT = __DIR__;
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_bench");
echo "http://xhprof.weibo.com/index.php?run=$run_id&source=xhprof_bench\n";

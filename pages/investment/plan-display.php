<?php $min = '';
        if ($data['plan_name'] != "") {
            $min = $data['plan_name'] . ": ";
        }
        $min .= currency . number_format((float)$data['min_amount'], 2,);
        $max = currency . number_format((float)$data['max_amount'], 2,);
        $retrun = $data['return_range_to'] . "%";
        $retrun_interval = $data['retrun_interval'];
       ?>
        <a href='?p=investment&action=new&planid= <?= $data['ID']; ?>' class='card shadow-md p-3 col-12 col-md-5 m-1 zoom $class'>
                <h6 class='mr-auto p-2 m-0'><?= $min .'-'. $max ?></h6>
                <div class='ps-2 ml-auto text-right '>Retun up to <b class='text-success'><?= $retrun .' '. $retrun_interval ?></b></div>
            </a>
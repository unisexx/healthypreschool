<?php
    $xAxis='';
    $series = '';
    $series_idx = 0;
    $desease = New Desease_watch_name();    
    $desease->get();
    if(@$_GET['area_id']=='' && @$_GET['province_id']==''){
        $area = new Area();
        $area->get();
    }else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
        $province = new V_Province();
        $province->where('area_id = '.$_GET['area_id'])->get();
    }else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
        $amphur = new Amphur();
        $amphur->where('province_id = '.$_GET['province_id'])->get();
    }else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
        $district = new District();
        $district->where('amphur_id = '.$_GET['amphur_id'])->get();
    }else if(@$_GET['district_id']!=''){
        $nursery = new V_Nursery();
        $nursery->where('district_id = '.$_GET['district_id'])->get();
    }
?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="outer"> 
  <div class="inner">
<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th style="height:100px;background:#fff !important;border-left:none;">
                
            </th>
            <td colspan="4" class="th_datatable" >
                รวม
            </td>
            
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    $xAxis .= $xAxis == '' ? "'".$area_row->area_name."'" : ",'".$area_row->area_name."'";
                    echo '<td colspan="4"  class="th_datatable" >'.$area_row->area_name.'</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    $xAxis .= $xAxis == '' ? "'".$province_row->name."'" : ",'".$province_row->name."'";
                    echo '<td colspan="4"  class="th_datatable" >'.$province_row->name.'</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    $xAxis .= $xAxis == '' ? "'".$amphur_row->amphur_name."'" : ",'".$amphur_row->amphur_name."'";
                    echo '<td colspan="4"  class="th_datatable" >'.$amphur_row->amphur_name.'</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    $xAxis .= $xAxis == '' ? "'".$district_row->district_name."'" : ",'".$district_row->district_name."'";
                    echo '<td colspan="4"  class="th_datatable" >'.$district_row->district_name.'</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    $xAxis .= $xAxis == '' ? "'".$nursery_row->name."'" : ",'".$nursery_row->name."'";
                    echo '<td colspan="4"  class="th_datatable" >'.$nursery_row->name.'</td>';
                endforeach;
            }
            ?>
            
        </tr>
        <tr>    
            <th>
                โรค
            </th>
            <td class="th_datatable" style="">
                จำนวนอีเว้น
            </td>
            <td class="th_datatable" style="">
                จำนวนผู้ป่วย
            </td>
            <td class="th_datatable" style="">
                ชาย
            </td>
            <td class="th_datatable" style="">
                หญิง
            </td>   
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
                endforeach;
            }
            ?>
        </tr>   
    </thead>
    <tbody>
        <?php
            $start_date = @$_GET['start_date']!='' ? @$_GET['start_date'] : '';
            $end_date = @$_GET['end_date']!='' ? @$_GET['end_date'] : '';
            if($start_date!='' && $end_date != ''){
                $time_condition = " AND date(start_date) BETWEEN '".Date2DB($start_date)."' AND '".Date2DB($end_date)."' ";
            }else if($start_date!='' && $end_date==''){
                $time_condition = " AND date(start_date) >= '".Date2DB($start_date)."' ";
            }else if($start_date=='' && $end_date!=''){
                $time_condition = " AND date(start_date) <= '".Date2DB($start_date)."' ";
            }else{
                $time_condition = '';
            }
            foreach($desease as $desease_row):          
            $series_idx++;        
            $condition = " AND disease = ".$desease_row->id;
            $condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND v_nurseries.area_id = ".$_GET['area_id'] : '';
            $condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND v_nurseries.province_id = ".@$_GET['province_id'] : '';
            $condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND v_nurseries.amphur_id = ".@$_GET['amphur_id'] : '';
            $condition.= @$_GET['district_id']!='' ? " AND v_nurseries.district_id = ".@$_GET['district_id'] : '';
            $sql = " SELECT
                        disease,
                        age_duration_start age_start,
                        age_duration_end age_end,
                        CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
                        COUNT(disease_watch.id)n_event,
                        SUM(total_amount)total_amount,
                        SUM(boy_amount)boy_amount,
                        SUM(girl_amount)girl_amount
                    FROM
                        disease_watch
                        LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                    WHERE
                        1=1 ".$time_condition.$condition;                   
            $desease_age = $this->db->query($sql)->result();
        ?>
        <tr class="desease_total">
            <th>
                <?php echo $desease_row->desease_name;?>
                <?php $series[$series_idx]['name'] = $desease_row->desease_name;?>
            </th>
            <?php
            echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
            echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
            echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
            echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
            ?>      
            <?php 
                $sql = " SELECT
                                disease,
                                age_duration_start age_start,
                                age_duration_end age_end,
                                CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
                                COUNT(disease_watch.id)n_event,
                                SUM(total_amount)total_amount,
                                SUM(boy_amount)boy_amount,
                                SUM(girl_amount)girl_amount
                            FROM
                                disease_watch
                                LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                            WHERE
                                1=1 ".$time_condition;
                $condition = " AND disease = ".$desease_row->id;                                
                if(@$_GET['area_id']=='' && @@$_GET['province_id']==''){
                    foreach($area as $area_row):                
                        $ex_condition = " AND area_id = ".$area_row->id;                        
                        $desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
                        @$series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';           
                    endforeach;
                }else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
                    foreach($province as $province_row):                
                        $ex_condition = " AND province_id = ".@$province_row->id;                       
                        $desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
                        @$series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                    endforeach;
                }else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
                    foreach($amphur as $amphur_row):                
                        $ex_condition = " AND amphur_id = ".@$amphur_row->id;                       
                        $desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
                        @$series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                    endforeach;
                }else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
                    foreach($district as $district_row):                
                        $ex_condition = " AND district_id = ".@$district_row->id;                       
                        $desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
                        @$series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                    endforeach;
                }else if(@$_GET['district_id']!=''){
                    foreach($nursery as $nursery_row):              
                        $ex_condition = " AND nurseries_id = ".@$nursery_row->id;                       
                        $desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
                        @$series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                        echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                    endforeach;
                }
            ?>
        </tr>
            <?php
                $condition = " AND disease = ".$desease_row->id;
                $condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
                $condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND province_id = ".$_GET['province_id'] : '';
                $condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND amphur_id = ".$_GET['amphur_id'] : '';
                $condition.= @$_GET['district_id'] != '' ? " AND district_id = ".$_GET['district_id'] : '';
                $sql = " SELECT
                            disease,
                            age_duration_start age_start,
                            age_duration_end age_end,
                            CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range                         
                        FROM
                            disease_watch
                            LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                        WHERE
                            1=1 ".$time_condition.$condition."
                        group by age_duration_start, age_duration_end
                        order by age_duration_start
                        ";
                $desease_age = $this->db->query($sql)->result();
                foreach($desease_age as $age):
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
                    $condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
                    $condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND province_id = ".$_GET['province_id'] : '';
                    $condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND amphur_id = ".$_GET['amphur_id'] : '';
                    $condition.= @$_GET['district_id'] != '' ? " AND district_id = ".$_GET['district_id'] : ''; 
                    $sql = " SELECT
                                disease,
                                age_duration_start age_start,
                                age_duration_end age_end,
                                CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
                                COUNT(disease_watch.id)n_event,
                                SUM(total_amount)total_amount,
                                SUM(boy_amount)boy_amount,
                                SUM(girl_amount)girl_amount                         
                            FROM
                                disease_watch
                                LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                            WHERE
                                1=1 ".$time_condition.$condition;
                    $value = $this->db->query($sql)->result();                          
            ?>
                <tr class="desease_age_range">
                    <th>
                        <?php echo $age->age_range;?>
                    </th>
                    <?php
                    echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                    echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                    echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                    echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                    ?>
                    <?php 
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;                  
                    $sql = " SELECT
                                disease,
                                age_duration_start age_start,
                                age_duration_end age_end,
                                CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
                                COUNT(disease_watch.id)n_event,
                                SUM(total_amount)total_amount,
                                SUM(boy_amount)boy_amount,
                                SUM(girl_amount)girl_amount                         
                            FROM
                                disease_watch
                                LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                            WHERE
                                1=1 ".$time_condition;
                    if(@$_GET['area_id']==''&&@ $_GET['province_id']==''){
                        foreach($area as $area_row):
                            $ex_condition = " AND area_id = ".$area_row->id;                                        
                            $value = $this->db->query($sql.$condition.$ex_condition)->result();
                            //if($area_row->id == 3) echo $sql.$condition.';';
                            echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                        endforeach;
                    }else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
                        foreach($province as $province_row):
                            $ex_condition = " AND province_id = ".$province_row->id;            
                            $value = $this->db->query($sql.$condition.$ex_condition)->result();
                            echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                        endforeach;
                    }else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
                        foreach($amphur as $amphur_row):
                            $ex_condition = " AND amphur_id = ".$amphur_row->id;            
                            $value = $this->db->query($sql.$condition.$ex_condition)->result();
                            echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                        endforeach;
                    }else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
                        foreach($district as $district_row):
                            $ex_condition = " AND district_id = ".$district_row->id;            
                            $value = $this->db->query($sql.$condition.$ex_condition)->result();
                            echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                        endforeach;
                    }else if(@$_GET['district_id']!=''){
                        foreach($nursery as $nursery_row):
                            $ex_condition = " AND nurseries_id = ".$nursery_row->id;            
                            $value = $this->db->query($sql.$condition.$ex_condition)->result();
                            echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
                            echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
                        endforeach;
                    }
                    ?>
                </tr>
            <?php endforeach; //end desease_age_row?>
        <?php endforeach; //end desease?>
    </tbody>
</table>
</div>
</div>
<script type="text/javascript">
$(function(){
    $(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [<?php echo $xAxis;?>]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'สัดส่วนจำนวนของเหตุการณ์'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + ' เหตุการณ์ <br/>' +
                    ' จากทั้งหมด: ' + this.point.stackTotal+ ' เหตุการณ์ ';
            }
        },
        plotOptions: {
            column: {
                stacking: 'percent',
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage*100)/100 + ' %';
                    },
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                }
            }
        },
        series: [
            <?php 
            $series_txt = '';
            for($i=1;$i<=$series_idx;$i++):
                $series_txt.= $series_txt !='' ? ',' : '';
                $series_txt.="{name: '".$series[$i]['name']."', data: [".$series[$i]['data']."]}";
            endfor;
            echo $series_txt;
            ?>
        ]
    });
});
    
});
</script>
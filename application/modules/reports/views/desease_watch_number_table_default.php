<?php
    $xAxis='';
    $series = '';
    $series_idx = 0;
    $desease = New Desease_watch_name();    
    if(@$_GET['disease']>0)$desease->where('id',@$_GET['disease'])->get(); else $desease->get();
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
    switch (@$_GET['place_type']) {
        case 'school':
            $display_mode = 'school';
            break;
        case 'community':
            $display_mode = 'community';
            break; 
        default:
            $display_mode = 'all';
            break;
    }
?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="outer"> 
  <div class="inner">
<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th style="background:#fff !important;border-left:none;">
                
            </th>
            <td colspan="4" style="width:650px;" class="th_datatable col_total" >
                                            รวม
            </td>
            
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    $xAxis .= $xAxis == '' ? "'".$area_row->area_name."'" : ",'".$area_row->area_name."'";
                    echo '<td colspan="4"  class="th_datatable col_area col_area_'.$area_row->id.'" >'.$area_row->area_name.'</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    $xAxis .= $xAxis == '' ? "'".$province_row->name."'" : ",'".$province_row->name."'";
                    echo '<td colspan="4"  class="th_datatable col_province col_province_'.$province_row->id.'" >'.$province_row->name.'</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    $xAxis .= $xAxis == '' ? "'".$amphur_row->amphur_name."'" : ",'".$amphur_row->amphur_name."'";
                    echo '<td colspan="4"  class="th_datatable col_amphur col_amphur_'.$amphur_row->id.'">'.$amphur_row->amphur_name.'</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    $xAxis .= $xAxis == '' ? "'".$district_row->district_name."'" : ",'".$district_row->district_name."'";
                    echo '<td colspan="4"  class="th_datatable col_district col_district_'.$district_row->id.'" >'.$district_row->district_name.'</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                $xAxis .= $xAxis == '' ? "'พื้นที่ชุมชุน'" : ",'พื้นที่ชุมชุน'";
                foreach($nursery as $nursery_row):
                    $xAxis .= $xAxis == '' ? "'".$nursery_row->name."'" : ",'".$nursery_row->name."'";
                    echo '<td colspan="4"  class="th_datatable col_nursery col_nursery_'.$nursery_row->id.'" >'.$nursery_row->name.'</td>';
                endforeach;
            }
            ?>
        </tr>
        <tr>    
            <th style="height: 60px;">
                                        โรค
            </th>
            <?php 
            echo $head_column = '
            <td class="th_datatable th_total" style="col_total">จำนวนเหตุการณ์</td>
            <td class="th_datatable th_total" style="col_total">จำนวนผู้ป่วย</td>
            <td class="th_datatable th_total" style="col_total">ชาย</td>
            <td class="th_datatable th_total" style="col_total">หญิง</td>';   
                        
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):          
                    $col_style_name = 'col_area col_area_'.$area_row->id;         
                    echo $head_column = '
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนเหตุการณ์</td>
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนผู้ป่วย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">ชาย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">หญิง</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    $col_style_name = 'col_province col_province_'.$province_row->id;         
                    echo $head_column = '
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนเหตุการณ์</td>
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนผู้ป่วย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">ชาย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">หญิง</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    $col_style_name = 'col_amphur col_amphur_'.$amphur_row->id;         
                    echo $head_column = '
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนเหตุการณ์</td>
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนผู้ป่วย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">ชาย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">หญิง</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    $col_style_name = 'col_district col_district_'.$district_row->id;         
                    echo $head_column = '
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนเหตุการณ์</td>
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนผู้ป่วย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">ชาย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">หญิง</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    $col_style_name = 'col_nusery col_nursery_'.$nursery_row->id;         
                    echo $head_column = '
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนเหตุการณ์</td>
                    <td class="th_datatable th_total '.$col_style_name.'">จำนวนผู้ป่วย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">ชาย</td>
                    <td class="th_datatable th_total '.$col_style_name.'">หญิง</td>';
                endforeach;
            }
            ?>
        </tr>           
    </thead>
    <tbody>
        <?php
            foreach($desease as $desease_row): 
            $series_idx++;                    
            $condition = " AND disease = ".$desease_row->id;
            $condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
            $condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND province_id = ".@$_GET['province_id'] : '';
            $condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND amphur_id = ".@$_GET['amphur_id'] : '';
            $condition.= @$_GET['district_id']!='' ? " AND district_id = ".@$_GET['district_id'] : '';
            $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
            $sql = get_desease_watch_sql($condition);                
            $desease_age = $this->db->query($sql)->result();       
            
            $sql = " SELECT count(*)nrec FROM v_disease_watch WHERE 1=1 ".$condition;
            $exist = $this->db->query($sql)->result();     
        ?>
        <tr class="desease_total">
            <th >
                <?php if($exist[0]->nrec > 0){?>
                <span id="desease_<?php echo $desease_row->id;?>" class="desease_name" style="cursor:hand;cursor:pointer;">
                    <?php echo $desease_row->desease_name;?>                                                       
                </span>
                <div style="float:right;padding-top:8px;">
                    <span class="caret"></span>
                </div>
                <?php }else{ ?>
                    <?php echo $desease_row->desease_name;?>
                <?php } ?>
                <?php $series[$series_idx]['name'] = $desease_row->desease_name;?>
            </th>
            <?php
                report_desease_watch_report_column($desease_age,$display_mode,'col_total');            
            ?>      
            <?php                 
                $condition = " AND disease = ".$desease_row->id;       
                //$condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
                @$series[$series_idx]['data'] = '';                         
                if(@$_GET['area_id']=='' && @@$_GET['province_id']==''){
                    foreach($area as $area_row):                
                        $ex_condition = " AND area_id = ".$area_row->id;   
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age,$display_mode,'col_area col_area_'.$area_row->id);           
                    endforeach;
                }else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
                    foreach($province as $province_row):                
                        $ex_condition = " AND province_id = ".@$province_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age,$display_mode,'col_province col_province_'.$province_row->id);
                    endforeach;
                }else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
                    foreach($amphur as $amphur_row):                
                        $ex_condition = " AND amphur_id = ".@$amphur_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age,$display_mode,'col_amphur col_amphur_'.$amphur_row->id);
                    endforeach;
                }else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
                    foreach($district as $district_row):                
                        $ex_condition = " AND district_id = ".@$district_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age,$display_mode,'col_district col_district_'.$district_row->id);
                    endforeach;
                }else if(@$_GET['district_id']!=''){
                    
                    $ex_condition = " AND district_id = ".@$_GET['district_id'];                       
                    $sql = get_desease_watch_sql($condition.$ex_condition);                     
                    $desease_age = $this->db->query($sql)->result();
                    $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                    $series[$series_idx]['data'].= number_format($desease_age[0]->n_event_community,0);
                    
                    foreach($nursery as $nursery_row):              
                        $ex_condition = " AND nurseries_id = ".@$nursery_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age,$display_mode,'col_area col_area_'.$nursery_row->id);
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
                            v_disease_watch                            
                        WHERE
                            1=1 ".$condition."
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
                    $sql = get_desease_watch_sql($condition);
                    $value = $this->db->query($sql)->result();                          
            ?>
                <tr class="desease_age_range <?php echo 'tr_desease_'.$desease_row->id;?>">
                    <th>
                        <?php echo $age->age_range;?>
                    </th>
                    <?php
                    report_desease_watch_report_column($desease_age,$display_mode,'col_total');        
                    ?>
                    <?php 
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
                    //$condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';                                                          
                    if(@$_GET['area_id']==''&&@ $_GET['province_id']==''){
                        foreach($area as $area_row):
                            $ex_condition = " AND area_id = ".$area_row->id;                                        
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_area col_area_'.$area_row->id);
                        endforeach;
                    }else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
                        foreach($province as $province_row):
                            $ex_condition = " AND province_id = ".$province_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_province col_province_'.$province_row->id);
                        endforeach;
                    }else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
                        foreach($amphur as $amphur_row):
                            $ex_condition = " AND amphur_id = ".$amphur_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_amphur col_amphur_'.$amphur_row->id);
                        endforeach;
                    }else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
                        foreach($district as $district_row):
                            $ex_condition = " AND district_id = ".$district_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_district col_district_'.$district_row->id);
                        endforeach;
                    }else if(@$_GET['district_id']!=''){
                        foreach($nursery as $nursery_row):
                            $ex_condition = " AND nurseries_id = ".$nursery_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_nursery col_nursery_'.$nursery_row->id);
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
    $('.desease_age_range').hide();
    $('.col_area').hide();
    $('.col_province').hide();
    $('.col_amphur').hide();
    $('.col_district').hide();
    $(".desease_name").live('click',function(){
        var tr = "tr_" + $(this).attr('id');
        $('.'+tr).toggle();
    })
    
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
            allowDecimals: false,
            <?php if(@$_GET['disease']==''){?>
                title: {
                text: 'สัดส่วนจำนวนของเหตุการณ์'
            },
            <?php }else{ ?>
            title: {
                text: 'จำนวนของเหตุการณ์'
            },
            <?php } ?>
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
                <?php if(@$_GET['disease']==''){?>
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
                <?php }else{ ?>
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y;
                <?php } ?>
            }
        },
        plotOptions: {
            column: {
                <?php if(@$_GET['disease']==''){?>
                stacking: 'percent',
                dataLabels: {
                    enabled: true,
                    formatter: function() {
                        return Math.round(this.percentage*100)/100 + ' %';
                    },
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                }
                <?php } ?>
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
</script>
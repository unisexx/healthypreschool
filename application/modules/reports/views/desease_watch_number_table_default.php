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
?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="outer"> 
  <div class="inner">
<table id="datatable" class="table table-bordered">
    <thead>
        <tr>
            <th style="background:#fff !important;border-left:none;">
                
            </th>
            <td colspan="12" style="width:650px;" class="th_datatable" >
                                            รวม
            </td>
            
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    $xAxis .= $xAxis == '' ? "'".$area_row->area_name."'" : ",'".$area_row->area_name."'";
                    echo '<td colspan="12"  class="th_datatable" >'.$area_row->area_name.'</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    $xAxis .= $xAxis == '' ? "'".$province_row->name."'" : ",'".$province_row->name."'";
                    echo '<td colspan="12"  class="th_datatable" >'.$province_row->name.'</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    $xAxis .= $xAxis == '' ? "'".$amphur_row->amphur_name."'" : ",'".$amphur_row->amphur_name."'";
                    echo '<td colspan="12"  class="th_datatable" >'.$amphur_row->amphur_name.'</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    $xAxis .= $xAxis == '' ? "'".$district_row->district_name."'" : ",'".$district_row->district_name."'";
                    echo '<td colspan="12"  class="th_datatable" >'.$district_row->district_name.'</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                $xAxis .= $xAxis == '' ? "'พื้นที่ชุมชุน'" : ",'พื้นที่ชุมชุน'";
                foreach($nursery as $nursery_row):
                    $xAxis .= $xAxis == '' ? "'".$nursery_row->name."'" : ",'".$nursery_row->name."'";
                    echo '<td colspan="12"  class="th_datatable" >'.$nursery_row->name.'</td>';
                endforeach;
            }
            ?>
        </tr>
        <tr>    
            <th style="height:40px;"></th>
            <?php $head_column = '
            <td class="th_datatable" colspan="3" style="">จำนวนเหตุการณ์</td>
            <td class="th_datatable" colspan="3" style="">จำนวนผู้ป่วย</td>
            <td class="th_datatable" colspan="3" style="">ชาย</td>
            <td class="th_datatable" colspan="3" style="">หญิง</td>';   
            echo $head_column;            
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):                    
                    echo $head_column;
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    echo $head_column;
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    echo $head_column;
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    echo $head_column;
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    echo $head_column;
                endforeach;
            }
            ?>
        </tr>   
        <tr>
            <th style="height: 60px;">
                                        โรค
            </th>
            <?php
                $head_column = '
                <td class="th_datatable" style="width:100px;">รวม</td>
                <td class="th_datatable" style="width:100px;">ศูนย์เด็กเล็ก</td>
                <td class="th_datatable" style="width:100px;">พื้นที่ชุมชน</td>                
                '; 
            for($i=1;$i<=4;$i++):                
                echo $head_column;       
            endfor;      
            ?>
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    for($i=1;$i<=4;$i++):                
                        echo $head_column;       
                    endfor;                      
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    for($i=1;$i<=4;$i++):                
                        echo $head_column;       
                    endfor;
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    for($i=1;$i<=4;$i++):                
                        echo $head_column;       
                    endfor;
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    for($i=1;$i<=4;$i++):                
                        echo $head_column;       
                    endfor;
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    for($i=1;$i<=4;$i++):                
                        echo $head_column;       
                    endfor;
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
            //$condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
            $sql = get_desease_watch_sql($condition);                
            $desease_age = $this->db->query($sql)->result();            
        ?>
        <tr class="desease_total">
            <th>
                <?php echo $desease_row->desease_name;?>
                <?php $series[$series_idx]['name'] = $desease_row->desease_name;?>
            </th>
            <?php
                report_desease_watch_report_column($desease_age);            
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
                        report_desease_watch_report_column($desease_age);           
                    endforeach;
                }else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
                    foreach($province as $province_row):                
                        $ex_condition = " AND province_id = ".@$province_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age);
                    endforeach;
                }else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
                    foreach($amphur as $amphur_row):                
                        $ex_condition = " AND amphur_id = ".@$amphur_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age);
                    endforeach;
                }else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
                    foreach($district as $district_row):                
                        $ex_condition = " AND district_id = ".@$district_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        $series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age);
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
                        report_desease_watch_report_column($desease_age);
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
                <tr class="desease_age_range">
                    <th>
                        <?php echo $age->age_range;?>
                    </th>
                    <?php
                    report_desease_watch_report_column($value);                    
                    ?>
                    <?php 
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
                    //$condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';                                                          
                    if(@$_GET['area_id']==''&&@ $_GET['province_id']==''){
                        foreach($area as $area_row):
                            $ex_condition = " AND area_id = ".$area_row->id;                                        
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value);
                        endforeach;
                    }else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
                        foreach($province as $province_row):
                            $ex_condition = " AND province_id = ".$province_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value);
                        endforeach;
                    }else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
                        foreach($amphur as $amphur_row):
                            $ex_condition = " AND amphur_id = ".$amphur_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value);
                        endforeach;
                    }else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
                        foreach($district as $district_row):
                            $ex_condition = " AND district_id = ".$district_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value);
                        endforeach;
                    }else if(@$_GET['district_id']!=''){
                        foreach($nursery as $nursery_row):
                            $ex_condition = " AND nurseries_id = ".$nursery_row->id;            
                            $sql = get_desease_watch_sql($condition.$ex_condition);                     
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value);
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
    
});
</script>
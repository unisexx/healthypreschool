<?php
    $parameter = GetCurrentUrlGetParameter();
    $xAxis='';
    $line_chart_category = '';
    $series = '';
    $series_idx = 0;
    $no=0;         
    @$series[1]['data'] = '';@$series[2]['data'] = ''; @$series[3]['data'] = '';
    if(@$_GET['area_id']=='' && @$_GET['province_id']==''){
        $condition_mode = 'area';
        $sql = " SELECT id,area_name FROM areas ORDER BY id ";
        $area_data = $this -> db -> query($sql)->result();
    }else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
        $condition_mode = 'province';
        $sql = ' SELECT id,name area_name FROM v_provinces WHERE area_id = '.$_GET['area_id'].' ORDER BY area_name ';
        $area_data = $this -> db -> query($sql)->result();
    }else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
        $condition_mode = 'amphur';
        $sql = ' SELECT id,amphur_name area_name FROM amphures WHERE province_id = '.$_GET['province_id'].' ORDER BY area_name ';
        $area_data = $this -> db -> query($sql)->result();
    }else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
        $condition_mode = 'district';
        $sql = ' SELECT id,district_name area_name FROM districts WHERE amphur_id = '.$_GET['amphur_id'].' ORDER BY area_name ';
        $area_data = $this -> db -> query($sql)->result();
    }else if(@$_GET['district_id']!=''){
        $condition_mode = 'nursery';
        $sql = ' SELECT id,district_name area_name FROM v_nureseries WHERE district_id = '.$_GET['district_id'].' ORDER BY area_name ';
        $area_data = $this -> db -> query($sql)->result();
    }

    $start_date = @$_GET['start_date']!='' ? @$_GET['start_date'] : '';
    $end_date = @$_GET['end_date']!='' ? @$_GET['end_date'] : '';
    
    $list_condition = "";
    $list_condition.= @$_GET['user_type']!='' ? ' AND user_type_id = '.$_GET['user_type'] : ''; 
    $list_condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
    $list_condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND province_id = ".@$_GET['province_id'] : '';
    $list_condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND amphur_id = ".@$_GET['amphur_id'] : '';
    $list_condition.= @$_GET['district_id']!='' ? " AND district_id = ".@$_GET['district_id'] : '';
    
    $time_condition = '';
    switch (@$_GET['range_type']) {
        case 'year':
            $start_year = @$_GET['report_end_year']!='' ? @$_GET['report_end_year'] : date("Y");
            $end_year =   @$_GET['report_start_year']!='' ? @$_GET['report_start_year'] : $start_year-5;
            $time_condition = " AND (year(uqr.update_date) between ".$end_year." AND ".$start_year.")";
            
            break;
        case'month_year':
        break; 
        default:
            if($start_date!='' && $end_date != ''){
                $time_condition = " AND date(uqr.update_date) BETWEEN '".Date2DB($start_date)."' AND '".Date2DB($end_date)."' ";
            }else if($start_date!='' && $end_date==''){
                $time_condition = " AND date(uqr.update_date) >= '".Date2DB($start_date)."' ";
            }else if($start_date=='' && $end_date!=''){
                $time_condition = " AND date(uqr.update_date) <= '".Date2DB($start_date)."' ";
            }else{
                $time_condition = '';
            }
            break;
    }
    $list_condition.= $time_condition; 
?>
<?php if(@$_GET['export_type']==''):?>
  <div style="float:left;text-align:right;width:100%;padding-top:10px;padding-bottom: 10px;">
    <div style="width:100%;text-align:center;">     
    <div class="input-prepend">
        <span class="add-on">แสดงผลกราฟ</span>
            <div class="add-on">
                <input type="radio" name="mychart" class="mychart" id="column2" value="column" onclick="show_chart('stack-chart')">
                <i class="fa fa-bar-chart"></i>
            </div>
            <div class="add-on">
            <input type="radio" name="mychart" class="mychart" id="bar2" value="bar" onclick="show_chart('line-chart')">
            <i class="fa fa-line-chart"></i>
            </div>
            <div class="add-on">
            <input type="radio" name="mychart" class="mychart" id="close2" value="close" onclick="show_chart('')">
            <i class="fa fa-times"></i>
            </div>
    </div>
    </div>      
</div>           
<?php endif;?>
<div id="stack-chart" style="<?php if(@$_GET['export_type']!=''){echo 'width:650px; ';}else{echo 'width:950px;';}?>height: 400px; margin: 0 auto"></div>
<div id="line-chart" style="<?php if(@$_GET['export_type']!=''){echo 'width:650px; ';}else{echo 'width:950px;';}?>height: 400px; margin: 0 auto"></div>        
<br>
<div class="outer" style="margin-top:50px;"> 
  <div class="inner">            
<?php if(@$_GET['export_type']==''):?>
<div style="float:left;text-align:right;width:100%;padding-top:10px;padding-bottom: 10px;">
        <div class="input-prepend">
        <span class="add-on">ส่งออก</span>
            <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
            <span class="btn btn-default btn-excel-report">Excel</span>            
        </div>
</div>           
<?php endif;?>  
<?php if(@$_GET['export_type']=='print'){ echo '<br><br><br><br>';}?>
<table id="datatable" class="table table-bordered table-hover" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
    <thead>
        <tr>
            <th>
                                            พื้นที่
            </th>
            <th>
                                             จำนวนผู้ทำแบบทดสอบ
            </th>
            <th>
                                             จำนวนผู้ผ่านแบบทดสอบ
            </th>
            <th>
                                             จำนวนผู้ไม่ผ่านแบบทดสอบ
            </th>
        </tr>        
    </thead>
    <tbody>
        <?php 
        if(@$condition_mode=='province'){
            $no++;
            $list_condition = @$_GET['user_type']!='' ? ' AND user_type_id = '.$_GET['user_type'] : '';
            $list_condition .= " AND area_id = ".$_GET['area_id'].' AND province_id = 0'.$list_condition.$time_condition; 
        ?>
        <tr>
            <td style="width:250px !important;text-align:left;">
                <?php echo $no;?>.<?php echo 'ประจำเขต (ไม่ได้ระบุจังหวัด)';?>
                <?php
                $xAxis .= $xAxis == '' ? "'ประจำเขต (ไม่ได้ระบุจังหวัด)'" : ",'ประจำเขต (ไม่ได้ระบุจังหวัด)'";
                $line_chart_category .= $line_chart_category == '' ? "'ประจำเขต (ไม่ได้ระบุจังหวัด)'" : ",'ประจำเขต (ไม่ได้ระบุจังหวัด)'";
                ?>
            </td>
            <td>
                <?php                     
                    echo $n_total_rec = get_elearning_count($list_condition);
                    $series[1]['name'] = 'จำนวนผู้ทำแบบทดสอบ';
                    $series[1]['data'].= @$series[1]['data'] != '' ? ',' :'';
                    $series[1]['data'].= number_format($n_total_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_rec = get_elearning_pass_count($list_condition);
                    $series[2]['name'] = 'จำนวนผู้ผ่านแบบทดสอบ';
                    $series[2]['data'].= @$series[2]['data'] != '' ? ',' :'';
                    $series[2]['data'].= number_format($n_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_nopass_rec = $n_total_rec - $n_rec;
                    $series[3]['name'] = 'จำนวนผู้ไม่ผ่านแบบทดสอบ';
                    $series[3]['data'].= @$series[3]['data'] != '' ? ',' :'';
                    $series[3]['data'].= number_format($n_nopass_rec,0);
                ?>
            </td>
        </tr>            
        <?php } ?>  
        <?php 
        if(@$condition_mode=='amphur'){
            $no++;
            $list_condition = @$_GET['user_type']!='' ? ' AND user_type_id = '.$_GET['user_type'] : '';
            $list_condition .= " AND province_id = ".$_GET['province_id'].' AND amphur_id = 0'.$list_condition.$time_condition; 
        ?>
        <tr>
            <td style="width:250px !important;text-align:left;">
                <?php
                $col_title = 'ประจำจังหวัด (ไม่ได้ระบุอำเภอ)'; 
                echo $no.$col_title;
                $xAxis .= $xAxis == '' ? "'".$col_title."'" : ",'".$col_title."'";
                $line_chart_category .= $line_chart_category == '' ? "'".$col_title."'" : ",'".$col_title."'";
                ?>
            </td>
            <td>
                <?php                     
                    echo $n_total_rec = get_elearning_count($list_condition);
                    $series[1]['name'] = 'จำนวนผู้ทำแบบทดสอบ';
                    $series[1]['data'].= @$series[1]['data'] != '' ? ',' :'';
                    $series[1]['data'].= number_format($n_total_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_rec = get_elearning_pass_count($list_condition);
                    $series[2]['name'] = 'จำนวนผู้ผ่านแบบทดสอบ';
                    $series[2]['data'].= @$series[2]['data'] != '' ? ',' :'';
                    $series[2]['data'].= number_format($n_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_nopass_rec = $n_total_rec - $n_rec;
                    $series[3]['name'] = 'จำนวนผู้ไม่ผ่านแบบทดสอบ';
                    $series[3]['data'].= @$series[3]['data'] != '' ? ',' :'';
                    $series[3]['data'].= number_format($n_nopass_rec,0);
                ?>
            </td>
        </tr>            
        <?php } ?>   
        <?php 
        if(@$condition_mode=='district'){
            $no++;
            $list_condition = @$_GET['user_type']!='' ? ' AND user_type_id = '.$_GET['user_type'] : '';
            $list_condition .= " AND amphur_id = ".$_GET['amphur_id'].' AND district_id = 0'.$list_condition.$time_condition; 
        ?>
        <tr>
            <td style="width:250px !important;text-align:left;">
                <?php
                $col_title = 'ประจำอำเภอ (ไม่ได้ระบุตำบล)'; 
                echo $no.$col_title;
                $xAxis .= $xAxis == '' ? "'".$col_title."'" : ",'".$col_title."'";
                $line_chart_category .= $line_chart_category == '' ? "'".$col_title."'" : ",'".$col_title."'";
                ?>
            </td>
            <td>
                <?php                     
                    echo $n_total_rec = get_elearning_count($list_condition);
                    $series[1]['name'] = 'จำนวนผู้ทำแบบทดสอบ';
                    $series[1]['data'].= @$series[1]['data'] != '' ? ',' :'';
                    $series[1]['data'].= number_format($n_total_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_rec = get_elearning_pass_count($list_condition);
                    $series[2]['name'] = 'จำนวนผู้ผ่านแบบทดสอบ';
                    $series[2]['data'].= @$series[2]['data'] != '' ? ',' :'';
                    $series[2]['data'].= number_format($n_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_nopass_rec = $n_total_rec - $n_rec;
                    $series[3]['name'] = 'จำนวนผู้ไม่ผ่านแบบทดสอบ';
                    $series[3]['data'].= @$series[3]['data'] != '' ? ',' :'';
                    $series[3]['data'].= number_format($n_nopass_rec,0);
                ?>
            </td>
        </tr>            
        <?php } ?>               
        <?php        
        foreach($area_data as $item):
            $no++;
            $series_idx=0;
            switch($condition_mode){
                case 'area':
                    $list_condition =' AND area_id = '.$item->id;
                break;
                case 'province':
                    $list_condition =' AND province_id = '.$item->id;
                break;
                case 'amphur':
                    $list_condition =' AND amphur_id = '.$item->id;
                break;
                case 'district':
                    $list_condition =' AND district_id = '.$item->id;
                break;
                case 'nursery':
                    $list_condition =' AND nursery_id = '.$item->id;
                break;
            }
                $list_condition.= @$_GET['user_type']!='' ? ' AND user_type_id = '.$_GET['user_type'] : '';
                $list_condition .= $list_condition.$time_condition;
        ?>        
        <tr>
            <td style="width:250px !important;text-align:left;">
                <?php echo $no;?>.<?php echo $item->area_name;?>
                <?php
                $xAxis .= $xAxis == '' ? "'".$item->area_name."'" : ",'".$item->area_name."'";
                $line_chart_category .= $line_chart_category == '' ? "'".$item->area_name."'" : ",'".$item->area_name."'";
                ?>
            </td>
            <td>
                <?php                     
                    echo $n_total_rec = get_elearning_count($list_condition);
                    $series[1]['name'] = 'จำนวนผู้ทำแบบทดสอบ';
                    $series[1]['data'].= @$series[1]['data'] != '' ? ',' :'';
                    $series[1]['data'].= number_format($n_total_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_rec = get_elearning_pass_count($list_condition);
                    $series[2]['name'] = 'จำนวนผู้ผ่านแบบทดสอบ';
                    $series[2]['data'].= @$series[2]['data'] != '' ? ',' :'';
                    $series[2]['data'].= number_format($n_rec,0);
                ?>
            </td>
            <td>
                <?php 
                    echo $n_nopass_rec = $n_total_rec - $n_rec;
                    $series[3]['name'] = 'จำนวนผู้ไม่ผ่านแบบทดสอบ';
                    $series[3]['data'].= @$series[3]['data'] != '' ? ',' :'';
                    $series[3]['data'].= number_format($n_nopass_rec,0);
                ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
</div>
</div>
<script type="text/javascript">
function show_chart(chart_type){
        switch(chart_type){
            case 'line-chart':
                $('#line-chart').show();
                $('#stack-chart').hide();
            break;
            case 'stack-chart':
                $('#line-chart').hide();
                $('#stack-chart').show();
            break;
            default:
                $('#line-chart').hide();
                $('#stack-chart').hide();
            break;
        }
    }
$(function(){
    <?php if(@$_GET['export_type']==''){?>
        $("#line-chart").hide();
        $("#stack-chart").hide();
    <?php }?>
    
    $('#stack-chart').highcharts({
        chart: {
            type: 'column'
        },
        exporting: { enabled: false },
        title: {
            text: ''
        },
        xAxis: {
            categories: [<?php echo $xAxis;?>]
        },
        yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
                text: 'จำนวนคน'
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
                    this.series.name + ': ' + this.y + '<br/>' +
                    'จำนวนผู้ทดสอบทั้งหมด: ' + this.point.stackTotal;
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
            for($i=2;$i<=3;$i++):
                $series_txt.= $series_txt !='' ? ',' : '';
                $series_txt.="{name: '".$series[$i]['name']."', data: [".$series[$i]['data']."]}";
            endfor;
            echo $series_txt;
            ?>
        ]
    });
    
    $('#line-chart').highcharts({
        title: {
            text: ''            
        },        
        xAxis: {
            categories: [<?php echo $line_chart_category;?>]
        },
        yAxis: {
            title: {
                text: 'จำนวนคน'
            },
            allowDecimals: false
        },
        exporting: { enabled: false },
        tooltip: {
            
        },
        legend: {
            
        },
        series: [
            <?php 
            $series_txt = '';
            for($i=1;$i<=2;$i++):
                $series_txt.= $series_txt !='' ? ',' : '';
                $series_txt.="{name: '".$series[$i]['name']."', data: [".$series[$i]['data']."]}";
            endfor;
            echo $series_txt;
            ?>
        ]
    });   
    
    $('.btn-print-report').click(function(){
        var url = 'reports/elearning_result<?php echo $parameter;?>&export_type=print';
        window.open(url);
    });
    
    $('.btn-excel-report').click(function(){
        var url = 'reports/elearning_result<?php echo $parameter;?>&export_type=excel';
        window.open(url);
    });
});
<?php if(@$_GET['export_type']=='print'):?>
canvg();
<?php endif;?>
<?php if(@$_GET['export_type']=='print'):?>
setTimeout("window.print();",2000);
<?php endif;?>
</script>
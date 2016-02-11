<?php
	$parameter = GetCurrentUrlGetParameter();
    $xAxis='';
    $line_chart_category = '';
    $series = '';
    $series_idx = 0;    
    $desease = New Desease_watch_name();    
    $desease->get();
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
        <span class="add-on">เลือกดูตามพื้นที่</span>
        <select name="select_data" class="form-control">
            <option value="col_total">รวม</option>
                <?php
                    if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                        foreach($area as $area_row):
                            echo '<option value="col_area_'.$area_row->id.'" >'.$area_row->area_name.'</option>';
                        endforeach;
                    }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                        foreach($province as $province_row):                    
                            echo '<option value="col_province_'.$province_row->id.'" >'.$province_row->name.'</option>';
                        endforeach;
                    }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                        foreach($amphur as $amphur_row):                    
                            echo '<option value="col_amphur_'.$amphur_row->id.'">'.$amphur_row->amphur_name.'</option>';
                        endforeach;
                    }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                        foreach($district as $district_row):                    
                            echo '<option value="col_district_'.$district_row->id.'" >'.$district_row->district_name.'</option>';
                        endforeach;
                    }else if(@$_GET['district_id']!=''){                
                        foreach($nursery as $nursery_row):                    
                            echo '<option value="col_nursery_'.$nursery_row->id.'" >'.$nursery_row->name.'</option>';
                        endforeach;
                    }
                    ?>
        </select>
        </div>
        <div class="input-prepend">
        <span class="add-on">ส่งออก</span>
            <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
            <span class="btn btn-default btn-excel-report">Excel</span>            
        </div>
</div>           
<?php endif;?>
<table id="datatable" class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
    <thead>
        <tr>
            <th rowspan="2" style="text-align: center;vertical-align: middle;">
                                        โรค
            </th>
            <td colspan="4" style="width:650px;" class="th_datatable col_total" >
                                            รวม
            </td>
            
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    $xAxis .= $xAxis == '' ? "'".$area_row->area_name."'" : ",'".$area_row->area_name."'";
                    $line_chart_category .= $line_chart_category == '' ? "'".$area_row->area_name."'" : ",'".$area_row->area_name."'";
                    echo '<td colspan="4"  class="th_datatable col_area col_area_'.$area_row->id.'" >'.$area_row->area_name.'</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    $xAxis .= $xAxis == '' ? "'".$province_row->name."'" : ",'".$province_row->name."'";
                    $line_chart_category .= $line_chart_category == '' ? "'".$province_row->name."'" : ",'".$province_row->name."'";
                    echo '<td colspan="4"  class="th_datatable col_province col_province_'.$province_row->id.'" >'.$province_row->name.'</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    $xAxis .= $xAxis == '' ? "'".$amphur_row->amphur_name."'" : ",'".$amphur_row->amphur_name."'";
                    $line_chart_category .= $line_chart_category == '' ? "'".$amphur_row->amphur_name."'" : ",'".$amphur_row->amphur_name."'";
                    echo '<td colspan="4"  class="th_datatable col_amphur col_amphur_'.$amphur_row->id.'">'.$amphur_row->amphur_name.'</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    $xAxis .= $xAxis == '' ? "'".$district_row->district_name."'" : ",'".$district_row->district_name."'";
                    $line_chart_category .= $line_chart_category == '' ? "'".$district_row->district_name."'" : ",'".$district_row->district_name."'";
                    echo '<td colspan="4"  class="th_datatable col_district col_district_'.$district_row->id.'" >'.$district_row->district_name.'</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                $xAxis .= $xAxis == '' ? "'พื้นที่ชุมชุน'" : ",'พื้นที่ชุมชุน'";
                foreach($nursery as $nursery_row):
                    $xAxis .= $xAxis == '' ? "'".$nursery_row->name."'" : ",'".$nursery_row->name."'";
                    $line_chart_category .= $line_chart_category == '' ? "'".$nursery_row->name."'" : ",'".$nursery_row->name."'";
                    echo '<td colspan="4"  class="th_datatable col_nursery col_nursery_'.$nursery_row->id.'" >'.$nursery_row->name.'</td>';
                endforeach;
            }
            ?>
        </tr>
        <tr>    
            
            <?php 
            echo $head_column = '
            <td class="th_datatable th_total col_total" style="col_total">จำนวนเหตุการณ์</td>
            <td class="th_datatable th_total col_total" style="col_total">จำนวนผู้ป่วย</td>
            <td class="th_datatable th_total col_total" style="col_total">ชาย</td>
            <td class="th_datatable th_total col_total" style="col_total">หญิง</td>';   
                        
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
                    $col_style_name = 'col_nursery col_nursery_'.$nursery_row->id;         
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
            $start_year = @$_GET['report_end_year']!='' ? @$_GET['report_end_year'] : date("Y");
            $end_year =   @$_GET['report_start_year']!='' ? @$_GET['report_start_year'] : $start_year-5;
        ?> 
        <tr class="year_total">
            <th>
                                                รวม ปี <?php echo ($end_year+543);?> ถึง <?php echo ($start_year+543);?>
            </th>
            <?php
            $condition = " AND (year(start_date) between ".$end_year." AND ".$start_year.")";
            $condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
            $condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND province_id = ".@$_GET['province_id'] : '';
            $condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND amphur_id = ".@$_GET['amphur_id'] : '';
            $condition.= @$_GET['district_id']!='' ? " AND district_id = ".@$_GET['district_id'] : '';
            $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
            $sql = get_desease_watch_sql($condition);
			//echo $sql."<br>";     
            $total_year = $this->db->query($sql)->result();            
            report_desease_watch_report_column($total_year,$display_mode,'col_total');

                $condition = " AND (year(start_date) between ".$end_year." AND ".$start_year.")";
                if(@$_GET['area_id']=='' && @@$_GET['province_id']==''){
                    foreach($area as $area_row):                
                        $ex_condition = " AND area_id = ".$area_row->id;
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();                        
                        report_desease_watch_report_column($desease_age,$display_mode,'col_area col_area_'.$area_row->id);           
                    endforeach;
                }else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
                    foreach($province as $province_row):                
                        $ex_condition = " AND province_id = ".@$province_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_province col_province_'.$province_row->id);
                    endforeach;
                }else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
                    foreach($amphur as $amphur_row):                
                        $ex_condition = " AND amphur_id = ".@$amphur_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_amphur col_amphur_'.$amphur_row->id);
                    endforeach;
                }else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
                    foreach($district as $district_row):                
                        $ex_condition = " AND district_id = ".@$district_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_district col_district_'.$district_row->id);
                    endforeach;
                }else if(@$_GET['district_id']!=''){
                    foreach($nursery as $nursery_row):              
                        $ex_condition = " AND nurseries_id = ".@$nursery_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_nursery col_nursery_'.$nursery_row->id);
                    endforeach;
                }
            ?>
        </tr>       
        <?php
        foreach($desease as $desease_row):
			$series_idx++;
            $condition = " AND disease = ".$desease_row->id;
			$condition.= " AND (year(start_date) between ".$end_year." AND ".$start_year.")";            
            $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
            $condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
            $condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND province_id = ".@$_GET['province_id'] : '';
            $condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND amphur_id = ".@$_GET['amphur_id'] : '';
            $condition.= @$_GET['district_id']!='' ? " AND district_id = ".@$_GET['district_id'] : '';
            $sql = get_desease_watch_sql($condition);                    
            $desease_age = $this->db->query($sql)->result();
            
            $sql = " SELECT count(*)nrec FROM v_disease_watch WHERE 1=1 ".$condition;
            $exist = $this->db->query($sql)->result();
		?>
		<tr class="desease_total">
            <th>
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
                $condition = " AND (year(start_date) between ".$end_year." AND ".$start_year.")";
                $condition.= " AND disease = ".$desease_row->id;
                $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
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
                    foreach($nursery as $nursery_row):              
                        $ex_condition = " AND nurseries_id = ".@$nursery_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
						$series[$series_idx]['data'].= @$series[$series_idx]['data'] != '' ? ',' :'';
                        $series[$series_idx]['data'].= number_format($desease_age[0]->n_event,0);
                        report_desease_watch_report_column($desease_age,$display_mode,'col_nursery col_nursery_'.$nursery_row->id);
                    endforeach;
                }
            ?>
        </tr>
        <?php
                $condition = " AND disease = ".$desease_row->id;
				$condition.= " AND (year(start_date) between ".$end_year." AND ".$start_year.")";
                $condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND v_nurseries.area_id = ".$_GET['area_id'] : '';
                $condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND v_nurseries.province_id = ".$_GET['province_id'] : '';
                $condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND v_nurseries.amphur_id = ".$_GET['amphur_id'] : '';
                $condition.= @$_GET['district_id'] != '' ? " AND v_nurseries.district_id = ".$_GET['district_id'] : '';
                $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
                $sql = " SELECT
                            disease,
                            age_duration_start age_start,
                            age_duration_end age_end,
                            CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range                         
                        FROM
                            disease_watch
                            LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                        WHERE
                            1=1 ".$condition."
                        group by age_duration_start, age_duration_end
                        order by age_duration_start
                        ";
                $desease_age = $this->db->query($sql)->result();
                foreach($desease_age as $age):
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
                    $condition.= " AND (year(start_date) between ".$end_year." AND ".$start_year.")";
                    $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
                    $condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
                    $condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND province_id = ".$_GET['province_id'] : '';
                    $condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND amphur_id = ".$_GET['amphur_id'] : '';
                    $condition.= @$_GET['district_id'] != '' ? " AND district_id = ".$_GET['district_id'] : ''; 
                    $sql = get_desease_watch_sql($condition);                     
                    $value = $this->db->query($sql)->result();                          
            ?>
                <tr class="desease_age_range <?php echo 'tr_desease_'.$desease_row->id;?>">
                    <th>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $age->age_range;?>
                    </th>
                    <?php
                    report_desease_watch_report_column($value,$display_mode,'col_total');
                    ?>
                    <?php 
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
					$condition.= " AND (year(start_date) between ".$end_year." AND ".$start_year.")";                    
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
		<?php endforeach;?>		
        <?php 
        for($i_year=$start_year;$i_year>=$end_year;$i_year--):            
            $year_condition = " AND year(start_date) = ".$i_year;
            $condition = " AND year(start_date) = ".$i_year;
            $condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
            $condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND province_id = ".@$_GET['province_id'] : '';
            $condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND amphur_id = ".@$_GET['amphur_id'] : '';
            $condition.= @$_GET['district_id']!='' ? " AND district_id = ".@$_GET['district_id'] : '';
            $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
            $sql = get_desease_watch_sql($condition);                
            $year_age = $this->db->query($sql)->result();
        ?>
          <tr class="year_total">
            <th>
                                            ปี <?php echo $i_year+543?>
            </th>
            <?php
            report_desease_watch_report_column($year_age,$display_mode,'col_total');
            ?>      
            <?php                
                $condition = " AND year(start_date) = ".$i_year;
                if(@$_GET['area_id']=='' && @@$_GET['province_id']==''){
                    foreach($area as $area_row):                
                        $ex_condition = " AND area_id = ".$area_row->id;
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_area col_area_'.$area_row->id);           
                    endforeach;
                }else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
                    foreach($province as $province_row):                
                        $ex_condition = " AND province_id = ".@$province_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_province col_province_'.$province_row->id);
                    endforeach;
                }else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
                    foreach($amphur as $amphur_row):                
                        $ex_condition = " AND amphur_id = ".@$amphur_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_amphur col_amphur_'.$amphur_row->id);
                    endforeach;
                }else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
                    foreach($district as $district_row):                
                        $ex_condition = " AND district_id = ".@$district_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_district col_district_'.$district_row->id);
                    endforeach;
                }else if(@$_GET['district_id']!=''){
                    foreach($nursery as $nursery_row):              
                        $ex_condition = " AND nurseries_id = ".@$nursery_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                        
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_nursery col_nursery_'.$nursery_row->id);
                    endforeach;
                }
            ?>
        </tr>       
        <?php            
            foreach($desease as $desease_row):
            $condition = " AND disease = ".$desease_row->id;            
            $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
            $condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
            $condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND province_id = ".@$_GET['province_id'] : '';
            $condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND amphur_id = ".@$_GET['amphur_id'] : '';
            $condition.= @$_GET['district_id']!='' ? " AND district_id = ".@$_GET['district_id'] : '';
            $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';            
            $sql = get_desease_watch_sql($condition.$year_condition);                    
            $desease_age = $this->db->query($sql)->result();
            
            $sql = " SELECT count(*)nrec FROM v_disease_watch WHERE 1=1 ".$condition.$year_condition;
            $exist = $this->db->query($sql)->result();
        ?>
        <tr class="desease_total">
            <th>
                <?php if($exist[0]->nrec > 0){?>
                <span id="desease_<?php echo $i_year.'_'.$desease_row->id;?>" class="desease_name" style="cursor:hand;cursor:pointer;">
                    <?php echo $desease_row->desease_name;?>                                                       
                </span>
                <div style="float:right;padding-top:8px;">
                    <span class="caret"></span>
                </div>
                <?php }else{ ?>
                    <?php echo $desease_row->desease_name;?>
                <?php } ?>
            </th>
            <?php
            report_desease_watch_report_column($desease_age,$display_mode,'col_total');
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
                                1=1 ";
                $condition.= $year_condition;
                $condition.= " AND disease = ".$desease_row->id;
                $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
                if(@$_GET['area_id']=='' && @@$_GET['province_id']==''){
                    foreach($area as $area_row):                
                        $ex_condition = " AND area_id = ".$area_row->id;   
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_area col_area_'.$area_row->id);           
                    endforeach;
                }else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
                    foreach($province as $province_row):                
                        $ex_condition = " AND province_id = ".@$province_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_province col_province_'.$province_row->id);
                    endforeach;
                }else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
                    foreach($amphur as $amphur_row):                
                        $ex_condition = " AND amphur_id = ".@$amphur_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_amphur col_amphur_'.$amphur_row->id);
                    endforeach;
                }else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
                    foreach($district as $district_row):                
                        $ex_condition = " AND district_id = ".@$district_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_district col_district_'.$district_row->id);
                    endforeach;
                }else if(@$_GET['district_id']!=''){
                    foreach($nursery as $nursery_row):              
                        $ex_condition = " AND nurseries_id = ".@$nursery_row->id;                       
                        $sql = get_desease_watch_sql($condition.$ex_condition);                     
                        $desease_age = $this->db->query($sql)->result();
                        report_desease_watch_report_column($desease_age,$display_mode,'col_nursery col_nursery_'.$nursery_row->id);
                    endforeach;
                }
            ?>
        </tr>
            <?php
                $condition = " AND disease = ".$desease_row->id;
                $condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND v_nurseries.area_id = ".$_GET['area_id'] : '';
                $condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND v_nurseries.province_id = ".$_GET['province_id'] : '';
                $condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND v_nurseries.amphur_id = ".$_GET['amphur_id'] : '';
                $condition.= @$_GET['district_id'] != '' ? " AND v_nurseries.district_id = ".$_GET['district_id'] : '';
                $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
                $sql = " SELECT
                            disease,
                            age_duration_start age_start,
                            age_duration_end age_end,
                            CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range                         
                        FROM
                            disease_watch
                            LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
                        WHERE
                            1=1 ".$year_condition.$condition."
                        group by age_duration_start, age_duration_end
                        order by age_duration_start
                        ";
                $desease_age = $this->db->query($sql)->result();
                foreach($desease_age as $age):
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
                    $condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';
                    $condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
                    $condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND province_id = ".$_GET['province_id'] : '';
                    $condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND amphur_id = ".$_GET['amphur_id'] : '';
                    $condition.= @$_GET['district_id'] != '' ? " AND district_id = ".$_GET['district_id'] : ''; 
                    $sql = get_desease_watch_sql($condition);                     
                    $value = $this->db->query($sql)->result();                          
            ?>
                <tr class="desease_age_range <?php echo 'tr_desease_'.$i_year.'_'.$desease_row->id;?>">
                    <th>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $age->age_range;?>
                    </th>
                    <?php
                    report_desease_watch_report_column($value,$display_mode,'col_total');
                    ?>
                    <?php 
                    $condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
					$condition.= @$_GET['place_type']!='' ? " AND place_type = ".@$_GET['place_type'] : '';                    
                    if(@$_GET['area_id']==''&&@ $_GET['province_id']==''){
                        foreach($area as $area_row):
                            $ex_condition = " AND area_id = ".$area_row->id;   
                            $sql = get_desease_watch_sql($year_condition.$condition.$ex_condition);
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_area col_area_'.$area_row->id);
                        endforeach;
                    }else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
                        foreach($province as $province_row):
                            $ex_condition = " AND province_id = ".$province_row->id;            
                            $sql = get_desease_watch_sql($year_condition.$condition.$ex_condition);
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_province col_province_'.$province_row->id);
                        endforeach;
                    }else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
                        foreach($amphur as $amphur_row):
                            $ex_condition = " AND amphur_id = ".$amphur_row->id;            
                            $sql = get_desease_watch_sql($year_condition.$condition.$ex_condition);
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_amphur col_amphur_'.$amphur_row->id);
                        endforeach;
                    }else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
                        foreach($district as $district_row):
                            $ex_condition = " AND district_id = ".$district_row->id;            
                            $sql = get_desease_watch_sql($year_condition.$condition.$ex_condition);
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_district col_district_'.$district_row->id);
                        endforeach;
                    }else if(@$_GET['district_id']!=''){
                        foreach($nursery as $nursery_row):
                            $ex_condition = " AND nurseries_id = ".$nursery_row->id;            
                            $sql = get_desease_watch_sql($year_condition.$condition.$ex_condition);
                            $value = $this->db->query($sql)->result();
                            report_desease_watch_report_column($value,$display_mode,'col_nursery col_nursery_'.$nursery_row->id);
                        endforeach;
                    }
                    ?>
                </tr>
                <?php endforeach; //end desease_age_row?>
            <?php endforeach; //end desease?>
        <?php endfor //year_row?>
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
    hide_data_col();    
    $('.col_total').show();
    <?php if(@$_GET['export_type']==''){?>
        $("#line-chart").hide();
        $("#stack-chart").hide();
        $('.desease_age_range').hide();
    <?php }else{ ?>
        show_data_col('<?php echo @$_GET['select_data'];?>');
    <?php } ?>
    
    
    
    $('.btn-print-report').click(function(){
        var select_data = $('select[name=select_data]').val();
        var url = 'reports/desease_watch_number<?php echo @$parameter;?>&export_type=print&select_data='+select_data;
        window.open(url);
    });
    
    $('.btn-excel-report').click(function(){
        var select_data = $('select[name=select_data]').val();
        var url = 'reports/desease_watch_number<?php echo @$parameter;?>&export_type=excel&select_data='+select_data;
        window.open(url);
    });
    
    function hide_data_col(){
        $('.col_total').hide();
        $('.col_area').hide();
        $('.col_province').hide();
        $('.col_amphur').hide();
        $('.col_district').hide();
        $('.col_nursery').hide();
    }
    
    function show_data_col(col_val){
        hide_data_col();
        $('.'+col_val).show();
    }
    
    $('select[name=select_data]').live('click',function(){
        var select_col = $(this).val();
        hide_data_col();
        show_data_col(select_col);
    })
    
    $(".desease_name").live('click',function(){
        var tr = "tr_" + $(this).attr('id');
        $('.'+tr).toggle();
    })     
    
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
    
    $('#line-chart').highcharts({
        title: {
            text: ''            
        },        
        xAxis: {
            categories: [<?php echo $line_chart_category;?>]
        },
        yAxis: {
            title: {
                text: 'จำนวนของเหตุการณ์'
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
            for($i=1;$i<=$series_idx;$i++):
                $series_txt.= $series_txt !='' ? ',' : '';
                $series_txt.="{name: '".$series[$i]['name']."', data: [".$series[$i]['data']."]}";
            endfor;
            echo $series_txt;
            ?>
        ]
    });
    
});
<?php if(@$_GET['export_type']=='print'):?>
canvg();
<?php endif;?>
<?php if(@$_GET['export_type']=='print'):?>
setTimeout("window.print();",2000);
<?php endif;?>
</script>
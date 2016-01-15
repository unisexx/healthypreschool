<?php
    $xAxis='';
    $series = '';
    $series_idx = 0;
    $desease = New Desease_watch_name();    
    $symptom = New Desease_watch_symptom();
    $symptom->get();
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
            <th style="height: 60px;">
                                            พื้นที่
            </th>
            <td colspan="15" style="width:650px;" class="th_datatable" >
                                            รวม
            </td>            
            
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    echo '<td colspan="15"  class="th_datatable" >'.$area_row->area_name.'</td>';
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    echo '<td colspan="15"  class="th_datatable" >'.$province_row->name.'</td>';
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    echo '<td colspan="15"  class="th_datatable" >'.$amphur_row->amphur_name.'</td>';
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    echo '<td colspan="15"  class="th_datatable" >'.$district_row->district_name.'</td>';
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    echo '<td colspan="15"  class="th_datatable" >'.$nursery_row->name.'</td>';
                endforeach;
            }
            ?>
        </tr>   
        <tr>
            <th style="height: 60px;">
                                        โรค
            </th>
            <?php 
            $desease_head = '';
            foreach($desease as $desease_row):
                $desease_head.='<td colspan="3" class="th_datatable">'.$desease_row->desease_name.'</td>';
            endforeach;
            echo $desease_head;
            ?>
            
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    echo $desease_head;
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    echo $desease_head;
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    echo $desease_head;
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    echo $desease_head;
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    echo $desease_head;
                endforeach;
            }
            ?>
        </tr>
        <tr>
            <th style="height:60px;">อาการ</th>
            <?php
                $head_column = '
                <td class="th_datatable" style="width:100px;">รวม</td>
                <td class="th_datatable" style="width:100px;">ศูนย์เด็กเล็ก</td>
                <td class="th_datatable" style="width:100px;">พื้นที่ชุมชน</td>                
                '; 
            foreach($desease as $desease_row):                
                echo $head_column;       
            endforeach;
            ?>
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;        
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($symptom as $symptom_row):?>
        <tr>
            <th><?php echo $symptom_row->title;?></th>
            <?php
                $head_column = '
                <td style="width:100px;"></td>
                <td style="width:100px;"></td>
                <td style="width:100px;"></td>                
                ';
            $condition=" AND question='".$symptom_row->code."' AND value = 1 ";
            $sql = "SELECT count(*)n_symptom from disease_watch_question dwq
                    LEFT JOIN disease_watch dw ON dwq.disease_watch_id = dw.id
                    LEFT JOIN v_nurseries on dw.nurseries_id = v_nurseries.id 
                    WHERE 1=1
                    ".$condition;            
            foreach($desease as $desease_row):              
                $ex_condition = " AND disease=".$desease_row->id;                                
                report_desease_watch_symptom_report_column($sql.$ex_condition);       
            endforeach;
            ?>
            <?php
            if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
                foreach($area as $area_row):
                    foreach($desease as $desease_row):
                        $ex_condition = " AND disease=".$desease_row->id." AND area_id = ".$area_row->id;                
                        report_desease_watch_symptom_report_column($sql.$ex_condition);       
                    endforeach;        
                endforeach;
            }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
                foreach($province as $province_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
                foreach($amphur as $amphur_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
                foreach($district as $district_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }else if(@$_GET['district_id']!=''){
                foreach($nursery as $nursery_row):
                    foreach($desease as $desease_row):                
                        echo $head_column;       
                    endforeach;
                endforeach;
            }
            ?>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
</div>
</div>
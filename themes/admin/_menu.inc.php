<ul class="menu unstyled">
	<?php if(permission('administrators', 'read')):?>
    <li <?php echo menu_active('users','administrators')?>><a href="users/admin/administrators">ผู้ดูแล</a></li>
    <?php endif;?>
    
    <!-- <?php if(permission('permissions', 'read')):?>
	<li <?php echo menu_active('permissions','permissions')?>><a href="permissions/admin/permissions/">สิทธิ์การใช้งาน</a></li>
	<?php endif;?> -->
	
	<?php if(permission('coverpages', 'read')):?>
	<li <?php echo menu_active('coverpages','coverpages')?> ><a href="coverpages/admin/coverpages">หน้าแรก</a></li>
	<?php endif;?>
	
	<?php if(permission('histories', 'update')):?>
	<li><a href="contents/admin/contents/form/histories/25">ความเป็นมาศูนย์เด็กเล็กปลอดโรค</a>
	<?php endif;?>
	
	<?php if(permission('hilights', 'read')):?>
    <li <?php echo menu_active('hilights','hilights')?>><a href="hilights/admin/hilights">ไฮไลท์</a>
    <?php endif;?>
    
    <?php if(permission('informations', 'read')):?>
    <li <?php echo menu_active('informations','informations')?>><a href="contents/admin/contents/index/informations">ข่าวประชาสัมพันธ์</a></li>
    <?php endif;?>
    
    <?php if(permission('vdos', 'read')):?>
    <li <?php echo menu_active('vdos','vdos')?>><a href="contents/admin/contents/index/vdos">vdo แนะนำ</a></li>
    <?php endif;?>
    
    <?php if(permission('articles', 'read')):?>
    <li <?php echo menu_active('articles','articles')?>><a href="contents/admin/contents/index/articles">บทความน่าสนใจ</a></li>
    <?php endif;?>
    
    <?php if(permission('newsletters', 'read')):?>
    <li><a href="contents/admin/contents/index/newsletters">จดหมายข่าว</a></li>
    <?php endif;?>
    
    <?php if(permission('galleries', 'read')):?>
	<!-- <li <?php echo menu_active('galleries','categories')?>><a href="galleries/admin/categories">ภาพกิจกรรม</a></li> -->
	<li <?php echo menu_active('albums','albums')?>><a href="albums/admin/albums">ภาพกิจกรรม</a></li>
	<?php endif;?>
    
    <?php if(permission('calendars', 'read')):?>
    <li <?php echo menu_active('calendars','calendars')?>><a href="calendars/admin/calendars">ปฎิทินกิจกรรม</a></li>
    <?php endif;?>
    
    <?php if(permission('downloads', 'read')):?>
    <li <?php echo menu_active('downloads','downloads')?>><a href="contents/admin/contents/index/downloads">เอกสารดาวน์โหลด</a></li>
    <?php endif;?>
	
	<li <?php echo menu_active('pages','pages')?>><a href="pages/admin/pages">หน้าเพจ</a></li>
	
	<li <?php echo menu_active('elearnings','elearnings')?>><a href="elearnings/admin/elearnings">บทเรียน E-learning</a></li>
	
	<li <?php echo menu_active('elearnings','ereports')?>><a href="elearnings/admin/ereports">รายงาน E-learning</a></li>
	
	<li <?php echo menu_active('elearnings','certs')?>><a href="elearnings/admin/certs">ออกใบประกาศนียบัตร</a></li>
    
    <!-- <li <?php echo menu_active('nurseries','nurseries')?>><a href="nurseries/admin/nurseries/category_form">ศูนย์เด็กเล็กปลอดโรค</a></li> -->
    
    <!-- <?php if(permission('dashboards', 'read')):?>
	<li <?php echo menu_active('dashboards','dashboards')?>><a href="dashboards/admin/dashboards">สถิติโดยรวม</a></li>
	<?php endif;?>
	
	<?php if(permission('headers', 'read')):?>
	<li><a href="headers/admin/headers/form">เฮดเดอร์</a></li>
	<?php endif;?>
	
	<?php if(permission('abouts', 'read')):?>
	<li <?php echo menu_active('abouts','abouts')?>><a href="abouts/admin/abouts/form/2">เกี่ยวกับองค์กร</a></li>
	<?php endif;?>
	
	<?php if(permission('stats', 'read')):?>
	<li><a href="contents/admin/contents/index/stat">ข้อมูลสถิติ ข้อมูลสนับสนุนการตรวจราชการในพื้นที่</a></li>
	<?php endif;?>
	
	<?php if(permission('supports', 'read')):?>
	<li><a href="contents/admin/contents/index/support">ข้อมูลสถิติ ข้อมูลสนับสนุนตามแผนการตรวจราชการ</a></li>
	<?php endif;?>
	
	<?php if(permission('contacts', 'read')):?>
	<li <?php echo menu_active('contacts','contacts')?>><a href="contacts/admin/contacts">ติดต่อเรา</a></li>
	<?php endif;?>
    
    <?php if(permission('fields', 'read')):?>
    <li><a href="contents/admin/contents/index/field">รอบรั้วเขต</a></li>
    <?php endif;?>
    
    <?php if(permission('policies', 'read')):?>
    <li><a href="contents/admin/contents/index/policy">ข้อสั่งการ นโยบาย หนังสือเวียน</a></li>
    <?php endif;?> -->
	
	<!-- <?php if(permission('inspects', 'read')):?>
	<li><a href="contents/admin/contents/index/inspect">การตรวจราชการและนิเทศงานกรณีปกติ</a></li>
	<?php endif;?>
	
	<?php if(permission('inspect_ints', 'read')):?>
	<li><a href="contents/admin/contents/index/inspect_int">การตรวจราชการแบบบูรณาการ</a></li>
	<?php endif;?>
	
	<?php if(permission('projects', 'read')):?>
	<li><a href="contents/admin/contents/index/project">โครงการพิเศษ</a></li>
	<?php endif;?>
	
	<?php if(permission('services', 'read')):?>
	<li><a href="contents/admin/contents/index/service">Service Plan</a></li>
	<?php endif;?>
	
	<?php if(permission('outstands', 'read')):?>
	<li><a href="contents/admin/contents/index/outstand">ผลงานดีเด่นระดับเขต/จังหวัด</a></li>
	<?php endif;?>
	
	<?php if(permission('pratices', 'read')):?>
	<li><a href="contents/admin/contents/index/pratice">Best Practice/นวัตกรรม</a></li>
	<?php endif;?>
	
	<?php if(permission('meetings', 'read')):?>
	<li><a href="contents/admin/contents/index/meeting">รายงานการประชุม</a></li>
	<?php endif;?>
	
	<?php if(permission('seats', 'read')):?>
	<li><a href="contents/admin/contents/index/seat">ทำเนียบผู้บริหารภายในเขต</a></li>
	<?php endif;?>
	
	<?php if(permission('houses', 'read')):?>
	<li><a href="contents/admin/contents/index/house">ทำเนียบ คปสข.</a></li>
	<?php endif;?>
	
	<?php if(permission('offices', 'read')):?>
	<li><a href="contents/admin/contents/index/office">สำนักงานสาธารณสุขจังหวัดในเขต</a></li>
	<?php endif;?>
	
	<?php if(permission('downloads', 'read')):?>
	<li><a href="contents/admin/contents/index/download">Download</a></li>
	<?php endif;?>
	
	<?php if(permission('kms', 'read')):?>
	<li><a href="contents/admin/contents/index/km">KM</a></li>
	<?php endif;?>
	
	<?php if(permission('weblinks', 'read')):?>
    <li <?php echo menu_active('weblinks','weblinks')?>><a href="weblinks/admin/weblinks">เว็บไซต์ที่เกี่ยวข้อง</a></li>
    <?php endif;?>
    
    <?php if(permission('webboards', 'read')):?>
    <li <?php echo menu_active('webboards','webboard_categories')?>><a href="webboards/admin/webboard_categories">กระดานสนทนา</a></li>
    <?php endif;?>
    
    <?php if(permission('polls', 'read')):?>
	<li <?php echo menu_active('polls','polls')?>><a href="polls/admin/polls">แบบสำรวจความคิดเห็น</a></li>
	<?php endif;?>
	
	<?php if(permission('guestbooks', 'read')):?>
	<li <?php echo menu_active('guestbooks','guestbooks')?>><a href="guestbooks/admin/guestbooks">สมุดเยี่ยม</a></li>
	<?php endif;?>
	
	<?php if(permission('networks', 'read')):?>
	<li <?php echo menu_active('networks','guestbooks')?>><a href="contents/admin/contents/index/network">คำสั่งเครือข่ายบริการ</a></li>
	<?php endif;?> -->
	
	<!-- <li><a href="contents/admin/contents/index/order">ข้อสั่งการ นโยบาย หนังสือเวียน</a></li> -->
	
	<!-- <li><a href="contents/admin/contents/index/pr">ประชาสัมพันธ์</a></li> -->
	
	<!--<?php if(permission('vdos', 'read')):?>
	<li <?php echo menu_active('vdos','categories')?>><a href="vdos/admin/categories">วิดิทัศน์</a></li>
	<?php endif;?>-->
	
    <!-- <?php if(permission('knowledges', 'read')):?>
	<li <?php echo menu_active('knowledges','knowledges')?>><a href="knowledges/admin/knowledges">ความรู้พื้นฐาน</a></li>
	<?php endif;?>
    
    <?php if(permission('projects', 'read')):?>
    <li <?php echo menu_active('projects','projects')?>><a href="projects/admin/projects">โครงการสำคัญ</a></li>
    <?php endif;?>
    
    <?php if(permission('report_years', 'read')):?>
    <li <?php echo menu_active('report_years','report_years')?>><a href="report_years/admin/report_years">รายงานปี 2555 - 2559</a></li>
    <?php endif;?>
    
    <?php if(permission('practices', 'read')):?>
    <li <?php echo menu_active('practices','practices')?>><a href="practices/admin/practices">Best Practices</a></li>
    <?php endif;?>
    
    <?php if(permission('history_pages', 'read')):?>
    <li <?php echo menu_active('history_pages','history_pages')?>><a href="history_pages/admin/history_pages/form/1">ความเป็นมา</a></li>
    <?php endif;?> -->
    
    <!-- <?php if(permission('currents', 'read')):?>
    <li <?php echo menu_active('currents','currents')?>><a href="currents/admin/currents/form/1">สถานการณ์ปัจจุบัน</a></li>
    <?php endif;?> -->
        
    <!-- <?php if(permission('plans', 'read')):?>
    <li <?php echo menu_active('plans','plans')?>><a href="plans/admin/plans/form/1">นโยบายและแผน</a></li>
    <?php endif;?>
    
    <?php if(permission('faqs', 'read')):?>
    <li <?php echo menu_active('faqs','faqs')?>><a href="faqs/admin/faqs/form/1">ถาม - ตอบ</a></li>
    <?php endif;?>
    
    <?php if(permission('manuals', 'read')):?>
    <li <?php echo menu_active('manuals','manuals')?>><a href="manuals/admin/manuals">คู่มือการดำเนินงาน</a></li>
    <?php endif;?>
    
    <?php if(permission('successes', 'read')):?>
    <li <?php echo menu_active('successes','successes')?>><a href="successes/admin/successes">เส้นทางความสำเร็จ</a></li>
    <?php endif;?>
	
	<!-- <?php if(permission('newsletters', 'read')):?>
	<li <?php echo menu_active('newsletters','newsletters')?>><a href="newsletters/admin/newsletters">จดหมายข่าว</a></li>
	<?php endif;?> -->
	
	<!-- <?php if(permission('vdos', 'read')):?>
	<li <?php echo menu_active('vdos','categories')?>><a href="vdos/admin/categories">วิดิทัศน์</a></li>
	<?php endif;?> -->
	
	<!-- <?php if(permission('notices', 'read')):?>
	<li <?php echo menu_active('notices','notices')?>><a href="notices/admin/notices">จัดซื้อ/จัดจ้าง</a></li>
	<?php endif;?> -->
	
	<!-- <?php if(permission('documents', 'read')):?>
	<li <?php echo menu_active('documents','documents')?>><a href="documents/admin/documents">เอกสารวิชาการ</a></li>
	<?php endif;?> -->
	
	<!-- <?php if(permission('district_infos', 'read')):?>
	<li <?php echo menu_active('district_infos','district_infos')?> id="district_infos"><a href="district_infos/admin/district_infos/form/1">ตำบลต้นแบบ</a></li>
	<?php endif;?> -->
	
	<!-- <?php if(permission('pms', 'read')):?>
	<li <?php echo menu_active('pms','pms')?> id="pms"><a href="pms/admin/pms/form/1">เครือข่าย พม.</a></li>
	<?php endif;?> -->
	
	<!-- <?php if(permission('stats', 'read')):?>
	<li <?php echo menu_active('stats','researches')?> id="stats"><a href="stats/admin/researches">วิชาการและสถิติ</a></li>
	<?php endif;?> -->
</ul>
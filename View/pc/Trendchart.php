<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 17/8/28
 * Time: 下午9:45
 * Created people: gaodonglai
 * pageName:走势图
 */
?>
<!--走势图页面-->
<main>
	<div class="personal_main Betting_main">
		<div class="personal_main_right Betting_main_right">
			<div class="Betting_main_macen">
				<div class="Betting_main_rig_main">
					<!--选项卡-->
					<div class="brigtinh_main_top rig_main_zla active_zla">
						<?php
						$name= '';
						$get_ks= $_GET['ks']?$_GET['ks']:$lottery[0]['id'];
						foreach ($lottery as $lv){
							$url = _get_home_url('fastthree/trendchart/?ks='.$lv['id']);
							$class = '';
							if($lv['id']==$get_ks){
								$url='javascript:;';
								$class.=' betting_top-active';
								$name= $lv['name'];
							}
							?>
							<a href="<?=$url?>" class="<?=$class?>"><?=$lv['name']?></a>
						<?php }?>

					</div>
					<!--江苏快三-->
					<div class="brigtinh_main_cen brigtinh_main_cen_active" id="jians">
						<div class="brigtinh_main_cenmn">
							<p class="title_Prompt Trend_chart"><?=$name?>走势图</p>
							<table class="Trend_chart_table">
								<tbody>
									<tr class="table_top_bor">
				                        <th rowspan="2">期号</th>
				                        <th rowspan="2">开奖号码</th>
				                        <th colspan="6">开奖号码分布</th>
				                        <th colspan="16">和值</th>
				                        <th colspan="2">大小</th>
				                        <th colspan="2">单双</th>
				                    </tr>
				                    <tr class="table_top_tow">
				                        <?php
											for($i=1;$i<=6;$i++){
												echo '<th>'.sprintf("%02d", $i).'</th>';
											}
											for($i=3;$i<=18;$i++){
												echo '<th>'.sprintf("%02d", $i).'</th>';
											}
										?>
				                        <th>大</th>
				                        <th>小</th>
				                        <th>单</th>
				                        <th>双</th>
				                    </tr>
									<?php
										if($ks){
											foreach ($ks as $v){
												echo '<tr class="table_top_mainbor">';
												echo '<td>'.$v['lottery_period'].'</td>';
												echo '<td>'.$v['p_number'].'</td>';
												$p_number = explode(',',$v['p_number']);
												for($i=1;$i<=6;$i++){
													$class= '';
													if(in_array($i,$p_number)){
														$class = 'class="winBall"';
													}
													echo '<td '.$class.'>'.sprintf("%02d", $i).'</td>';
												}
												for($i=3;$i<=18;$i++){
													$class= '';
													if($i==$v['sumvalue']){
														$class = 'class="winBall"';
													}
													echo '<td '.$class.'>'.sprintf("%02d", $i).'</td>';
												} ?>
												<td class="<?=$v['p_size']=='y'?'trendcolor2':'trendcolor5'?>">大</td>
												<td class="<?=$v['p_size']=='n'?'trendcolor2':'trendcolor5'?>"">小</td>
												<td class="<?=$v['p_odd_even']=='n'?'trendcolor3':'trendcolor5'?>"">单</td>
												<td class="<?=$v['p_odd_even']=='y'?'trendcolor3':'trendcolor5'?>"">双</td>
												<?php echo '</tr>';
											}
											?>
										<?php }else{ ?>
											<tr class="table_top_mainbor">
												<td colspan="28" style="text-align: center;border-right:none;padding:40px">
													暂无历史开奖
												</td>
											</tr>
									<?php	}
									?>

								</tbody>
							</table>
						</div>
					</div>
	            </div>
			</div>	
		</div>
	</div>
</main>
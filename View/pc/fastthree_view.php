<!--快三投注页面-->
<main>
<div class="personal_main Betting_main">
	<!--左边导航-->
	<div class="Betting_main_left">
		<div class="sonal_main_lef_nav Betting_main_lef_nav">
		<p class="childTitleaa"><span>各地区快三<i class="iconfont iconnonea">&#xe8da;</i><i class="iconfont iconnoneb">&#xe602;</i></span></p>
			<ul class="childContentbb">
				<?php foreach ($lottery as $lv){
					$url = _get_home_url('fastthree/view/?ks='.$lv['id']);
					$class = '';
					if($lv['id']==$_GET['ks']){
						$url='javascript:;';
						$class.=' left-nav-active';
					}
					?>
					<li><a href="<?=$url?>" class="<?=$class?>"><?=$lv['name']?></a></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<!--右边内容-->
	<div class="personal_main_right Betting_main_right">
		<div class="Betting_main_macen">
			<div class="Betting_main_rig_top">
				<div class="Betting_logo_left">
					<?php
					/*单双*/
					$p_odd_even = '--';
					/*大小*/
					$p_size = '--';
					/*和*/
					$sumvalue = 0;
					/*期号*/
					$lottery_period = '--';
					$p_number = array('-','-','-');
					if($ks->p_id){
						$p_number = explode(',',$ks->p_number);
						$p_odd_even = $ks->p_odd_even=='y'?'双':'单';
						$p_size = $ks->p_size=='y'?'大':'小';
						$sumvalue = $ks->sumvalue;
						$lottery_period = $ks->lottery_period;
					}

					/*获取图片*/
					$src = _get_home_url().'View/pc/image/BJK3.png';
					if($ks->img) {
						$image_attributes = wp_get_attachment_image_src($ks->img);
						if($image_attributes) $src = $image_attributes[0];
					}
					?>
					<img src="<?=$src?>" alt="">
					<p><span><?=$ks->name?></span></p>
				</div>
				<div class="Betting_main_center">
					<div class="bettThe_otterya">
						<div>
							<p>开奖号码</p>
							<p><span><?=$lottery_period?></span>期</p>
							<p>
								<a href="<?=_get_home_url('fastthree/trendchart/?ks='.$ks->id)?>" target="_blank" class="bt01">
									<i class="iconfont">&#xe62a;</i>
									号码走势
								</a>
							</p>
						</div>
					</div>
					<div class="bettThe_otteryb">
						<p>
							<span><?=$p_number[0]?></span>
							<span><?=$p_number[1]?></span>
							<span><?=$p_number[2]?></span>
						</p>
					</div>
					<div class="bettThe_otteryc">
						<div>
							<p>和值：<span><?=$sumvalue?></span> </p>
							<p>型态：
								<span><?=$p_size?></span>
								<span><?=$p_odd_even?></span>
							</p>
						</div>
					</div>
				</div>
				<div class="Betting_time_right">
					<div class="time_left">
						<div>
							<p>投注剩余时间</p>
							<p><span>20170829</span>期</p>
						</div>
					</div>
					<div class="time_right">
						<div class="time_right_main">
							<div class="clock flip-clock-wrapper"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="Betting_main_rig_main">
				<!--选项卡-->
				<div class="brigtinh_main_top rig_main_zla active_zla">
				<?php
				$h = '';
				foreach ($get_probability as $v){ ?>
					<a href="#<?=$v['bt_type']?>" <?=$v['bt_type']=='HZ'?'class="betting_top-active"':''?>>
						<?=$v['bt_name']?>
					</a>
				<?php
					$class_ = $v['bt_type']=='HZ'?'brigtinh_main_cen_active':'';
					$h .= '<div class="brigtinh_main_cen '.$class_.'" id="'.$v['bt_type'].'">
						<div class="brigtinh_main_cenmn">
						<p class="title_Prompt">投注说明：'.$v['bt_content'].'</p>
						<p class="title_Prompt">实例说明：<span>选号：';
					switch ($v['bt_type']){
						case 'HZ':
							//和值-->
							$h .= '3</span><span>开奖：1,1,1</span><span>赔率'.$v['odds']['3']['odds'].'</span></p>
									<div class="brigtinh_main_cenle Selected_null">';
							for($i=3;$i<=18;$i++){
								$h .= '<div class="key_shadow">
									<p class="key_shadow_num" data-id="'.$v['odds'][$i]['odds_id'].'" data-odds="'.$v['odds'][$i]['odds'].'">
									<a href="javascript:void(0)">'.$i.'</a></p>
									<p>赔率：<span>'.$v['odds'][$i]['odds'].'</span></p>
								</div>';
							}

							$h .= '</div>
									<div class="brigtinh_main_cenri Selected_null">
										<div class="key_shadow2">
											<p class="key_shadow_num2" data-id="'.$v['odds'][DAN]['odds_id'].'" data-odds="'.$v['odds'][DAN]['odds'].'">
											<a href="javascript:void(0)">单(全部奇数)</a></p>
											<p>赔率：<span>'.$v['odds'][$i]['DAN'].'</span></p>
										</div>
										<div class="key_shadow2">
											<p class="key_shadow_num2" data-id="'.$v['odds']['SHUANG']['odds_id'].'" data-odds="'.$v['odds']['SHUANG']['odds'].'">
											<a href="javascript:void(0)">双(全部偶数)</a></p>
											<p>赔率：<span>'.$v['odds'][$i]['SHUANG'].'</span></p>
										</div>
										<div class="key_shadow2">
											<p class="key_shadow_num2" data-id="'.$v['odds']['XIAO']['odds_id'].'" data-odds="'.$v['odds']['XIAO']['odds'].'">
											<a href="javascript:void(0)">小(3-10)</a></p>
											<p>赔率：<span>'.$v['odds'][$i]['XIAO'].'</span></p>
										</div>
										<div class="key_shadow2">
											<p class="key_shadow_num2" data-id="'.$v['odds']['DA']['odds_id'].'" data-odds="'.$v['odds']['DA']['odds'].'">
											<a href="javascript:void(0)">大(11-18)</a></p>
											<p>赔率：<span>'.$v['odds'][$i]['DA'].'</span></p>
										</div>
									</div>';
						break;
						case '3THTX':
							//-三同号通选-->
							$h .= '三同号通选</span>
									<span>开奖：3,3,3</span>
									<span>中奖：赔率'.$v['odds']['3THTX']['odds'].'</span></p>
									<div class="Three_different" id="box_ball_3THTX_num">
										<div class="select_info_text">
											<a href="javascript:void(0);" class="addbtn_disabled modify_sub" data-id="'.$v['odds']['3THTX']['odds_id'].'" data-odds="'.$v['odds']['3THTX']['odds'].'">
											添加到投注列表
											</a>
										</div>
									</div>';
						break;
						case '3THDX':
							//<!--三同号单选-->
							$h .= '5,5,5</span>
									<span>开奖：5,5,5</span>
									<span>中奖：赔率'.$v['odds']['3THDX']['odds'].'</span></p>
									<div class="Three_different" id="box_ball_3THDX_num">
										<div class="box_ball_3THDX_main box_ball_wid">';
							for($i=1;$i<=6;$i++){
								$h .= '<div class="key_shadow">
										<p class="key_shadow_num" data-id="'.$v['odds']['3THDX']['odds_id'].'" data-odds="'.$v['odds']['3THDX']['odds'].'">
										<a href="javascript:void(0)">'.$i.$i.$i.'</a>
										</p></div>';
							}
							$h .= '</div></div>';
						break;
						case '3BTH':
							//<!--三不同号-->
							$h .= '5,3,6</span>
									<span>开奖：5,3,6</span>
									<span>中奖：赔率'.$v['odds']['3BTH']['odds'].'</span></p>
									<div class="Three_different" id="box_ball_3BTH_num">
										<div class="box_ball_3BTH_main box_ball_radu">';
							for($i=1;$i<=6;$i++){
								$h .= '<div class="key_shadow">
										<p class="key_shadow_num">
										<a href="javascript:void(0)">1</a>
										</p>
									</div>';
							}
							$h.='</div>
								<a href="javascript:void(0);" class="addbtn_disabled modify_sub" data-id="'.$v['odds']['3BTH']['odds_id'].'" data-odds="'.$v['odds']['3BTH']['odds'].'">
								添加到投注列表
								</a>
								</div>';
						break;
						case '3LHTX':
							//<!--三连号通选-->
							$h .= '三连号</span><span>开奖：4,5,6</span>
									<span>中奖：赔率'.$v['odds']['3LHTX']['odds'].'</span></p>
									<div class="Three_different" id="box_ball_3LHTX_num">
										<div class="select_info_text">
											<a href="javascript:void(0);" class="addbtn_disabled modify_sub" data-id="'.$v['odds']['3LHTX']['odds_id'].'" data-odds="'.$v['odds']['3LHTX']['odds'].'">
											添加到投注列表</a>
										</div>
									</div>';
						break;
						case '2THFX':
							//<!--二同号复选-->
							$h .= '5,5</span><span>开奖：5,5,6</span><span>中奖：赔率'.$v['odds']['2THFX']['odds'].'</span></p>
									<div class="Three_different" id="box_ball_2THFX_num">
										<div class="box_ball_2THFX_main box_ball_wid">';
							for($i=1;$i<=6;$i++){
								$h .= '<div class="key_shadow">
										<p class="key_shadow_num" data-id="'.$v['odds']['2THFX']['odds_id'].'" data-odds="'.$v['odds']['2THFX']['odds'].'">
										<a href="javascript:void(0)">11</a></p>
									</div>';
							}
							$h.='</div></div>';
						break;
						case '2THDX':
							//<!--二同号单选-->
							$h .= '5,5,6</span><span>开奖：5,5,6</span><span>中奖：赔率'.$v['odds']['2THDX']['odds'].'</span></p>
									<div class="Three_different" id="box_ball_2THFX_num">
										<div class="box_ball_2THDX_num box_ball_wid">';
							$c='';
							for($i=1;$i<=6;$i++){
								$h .= '<div class="key_shadow">
									<p class="key_shadow_num" data-id="'.$i.$i.'#">
									<a href="javascript:void(0)">'.$i.$i.'</a>
									</p>
								</div>';
								$c .= '<div class="key_shadow">
									<p class="key_shadow_num">
									<a href="javascript:void(0)">'.$i.'</a>
									</p>
								</div>';
							}
							$h .=$c.'</div>
									<a href="javascript:void(0);" class="addbtn_disabled modify_sub" data-id="'.$v['odds']['2THDX']['odds_id'].'" data-odds="'.$v['odds']['2THDX']['odds'].'">
									添加到投注列表
									</a>
								</div>
							</div>
							</div>';
						break;
						case '2BTH':
							//<!--二不同号-->
							$h .= '2,3</span><span>开奖：4,3,2</span><span>中奖：赔率6.5</span></p>
									<div class="Three_different" id="box_ball_3BTH_num">
										<div class="box_ball_2BTH box_ball_radu">';
							for($i=1;$i<=6;$i++){
								$h .= '<div class="key_shadow">
										<p class="key_shadow_num">
										<a href="javascript:void(0)" data-id="'.$i.'">1</a>
										</p>
									</div>';
							}
						$h .= '</div>
							<a href="javascript:void(0);" class="addbtn_disabled modify_sub" data-id="'.$v['odds']['2BTH']['odds_id'].'" data-odds="'.$v['odds']['2BTH']['odds'].'">
						添加到投注列表</a></div>';
						break;
					}
					$h .='</div></div>';
				}
				?>
				</div>
				<?=$h?>
				<!--投注框-->
				<div class="Betting_list_box">
					<p class="bg_top"></p>
					<div class="choose_list_box">
						<div class="chose_list">
							<ul class="has_add_ball" id="has_add_ball">
								<li id="li_HZ_小" data-type="HZ" data-zhushu="1" data-code="小" data-id="box_ball_HZ_c">
									<span class="txt-betsName">[和值]</span>
									<span title="小" class="txt-num js-code">小</span>
									<span class="txt-amount js-money">金额：
									<input type="number" onkeyup="BET.formatIntVal(this)" data-odd="1.95" onafterpaste="BET.formatIntVal(this)" name="totals[]" class="totalsVal" size="6">
									元 <em>可赢：<span class="bingoMoney">3250.0</span> 元</em>
									</span>
									<a href="javascript:void(0);" class="txt-delNum js-del"><i class="iconfont">&#xe629;</i></a>
									<input type="hidden" name="tmpCodes[]" class="tmpCodes" value="小|HZ|和值">
								</li>
								<li id="li_HZ_小" data-type="HZ" data-zhushu="1" data-code="小" data-id="box_ball_HZ_c">
									<span class="txt-betsName">[和值]</span>
									<span title="小" class="txt-num js-code">小</span>
									<span class="txt-amount js-money">金额：
									<input type="number" onkeyup="BET.formatIntVal(this)" data-odd="1.95" onafterpaste="BET.formatIntVal(this)" name="totals[]" class="totalsVal" size="6">
									元 <em>可赢：<span class="bingoMoney">3250.0</span> 元</em>
									</span>
									<a href="javascript:void(0);" class="txt-delNum js-del"><i class="iconfont">&#xe629;</i></a>
									<input type="hidden" name="tmpCodes[]" class="tmpCodes" value="小|HZ|和值">
								</li>
								<li id="li_HZ_小" data-type="HZ" data-zhushu="1" data-code="小" data-id="box_ball_HZ_c">
									<span class="txt-betsName">[和值]</span>
									<span title="小" class="txt-num js-code">小</span>
									<span class="txt-amount js-money">金额：
									<input type="number" onkeyup="BET.formatIntVal(this)" data-odd="1.95" onafterpaste="BET.formatIntVal(this)" name="totals[]" class="totalsVal" size="6">
									元 <em>可赢：<span class="bingoMoney">3250.0</span> 元</em>
									</span>
									<a href="javascript:void(0);" class="txt-delNum js-del"><i class="iconfont">&#xe629;</i></a>
									<input type="hidden" name="tmpCodes[]" class="tmpCodes" value="小|HZ|和值">
								</li>
								<li id="li_HZ_小" data-type="HZ" data-zhushu="1" data-code="小" data-id="box_ball_HZ_c">
									<span class="txt-betsName">[和值]</span>
									<span title="小" class="txt-num js-code">小</span>
									<span class="txt-amount js-money">金额：
									<input type="number" onkeyup="BET.formatIntVal(this)" data-odd="1.95" onafterpaste="BET.formatIntVal(this)" name="totals[]" class="totalsVal" size="6">
									元 <em>可赢：<span class="bingoMoney">3250.0</span> 元</em>
									</span>
									<a href="javascript:void(0);" class="txt-delNum js-del"><i class="iconfont">&#xe629;</i></a>
									<input type="hidden" name="tmpCodes[]" class="tmpCodes" value="小|HZ|和值">
								</li>
								<li id="li_HZ_小" data-type="HZ" data-zhushu="1" data-code="小" data-id="box_ball_HZ_c">
									<span class="txt-betsName">[和值]</span>
									<span title="小" class="txt-num js-code">小</span>
									<span class="txt-amount js-money">金额：
									<input type="number" onkeyup="BET.formatIntVal(this)" data-odd="1.95" onafterpaste="BET.formatIntVal(this)" name="totals[]" class="totalsVal" size="6">
									元 <em>可赢：<span class="bingoMoney">3250.0</span> 元</em>
									</span>
									<a href="javascript:void(0);" class="txt-delNum js-del"><i class="iconfont">&#xe629;</i></a>
									<input type="hidden" name="tmpCodes[]" class="tmpCodes" value="小|HZ|和值">
								</li>
							</ul>
						</div>
						<hr class="style12">
					</div>
					<!--投注和购买方式-->
					<div class="choose_list_boxri">
						<div class="mode">
                          	<input type="hidden" name="_token" value="p39tumGfQRmDyOGdCiTADpLDcZIzepNDNeHFiGV5">
                          	<ul>
							<li class="mode_li basic_information_c">
								<label for="">购买方式：</label>
								<label class="basic_radio_label">
									<input class="mui-checkbox checkbox-s checkbox-orange" id="daigou" type="radio" name="buyType" value="zhuihao" checked="">
									<i class="iconfont checkbox-i">&#xe628;</i>
									代购
								</label>
								<label class="basic_radio_label">
									<input class="mui-checkbox checkbox-s checkbox-orange" id="buyType" type="radio" name="buyType" value="daigou">
									<i class="iconfont checkbox-i">&#xe628;</i>
									追号
								</label>
							</li>
     					  	<li class="mode_lia">	
								<label>统一金额：</label>
								<input type="number" onfocus="$(this).select()" id="unifiedPrice" onkeyup="BET.formatIntValAndReplaceAll(this)" onafterpaste="BET.formatIntValAndReplaceAll(this)" value="0">
     					   	</li>
     					   	<li class="mode_lic">
								<button class="modify_sub">立即投注</button>
								<button class="modify_sub">清空列表</button>
     					   	</li>			   
                          	</ul>
                        </div>
					</div>
				</div>
				<!--提示-->
				<p class="system_Prompt"><?=$ks->each_time?> 分钟一期，返奖率<?=$ks->return_rate?>% 销售时间：<?=$ks->start_time?>-<?=$ks->end_time?></p>
				<!--投注记录-->
				<div class="Accordion_Record">
					<div class="Accordion_Record_main">
		                    <div class="child">
		                        <div class="childTitle Record_active">
		                            <div class="childIcon">
		                                <div class="sub sub1">
		                                </div>
		                                <div class="sub sub2">
		                                </div>
		                            </div>
		                            <div class="title">
		                                <p><?=$ks->name?>近期投注记录</p>
		                            </div>
		                        </div>
		                        <div class="childContent"  style="display: block;">
		                          <div class="basic_information">
										<div class="table_betting_main table_betting_active">
											 <table class="table_reference"> 
										       <thead class="tbody_referencea">
										          <tr> 
										            <th><span>彩票类型</span></th> 
										            <th><span>彩票期号</span></th> 
										            <th><span>投注类型</span></th>
										            <th><span>投注号码</span></th> 
										            <th><span>投注金额</span></th> 
										            <th><span>中奖金额</span></th> 
										            <th><span>开奖号码</span></th> 
										            <th><span>中奖状态</span></th> 
										            <th><span>投注时间</span></th>  
										          </tr> 
										         </thead> 
										         <tbody class="tbody_referenceb tbody_referencebc" id="Recent_bets_html">
												 <tr class="nothover">
													 <td colspan="9" class="record_p">
														 加载中...
													 </td>
												 </tr>
												 </tbody>
										      </table>
										      <hr class="style12">
										</div>
									</div>
		                        </div>
		                    </div>
		                    <!--开奖公告-->
		                    <div class="child">
		                        <div class="childTitle">
		                            <div class="childIcon">
		                                <div class="sub sub1">
		                                </div>
		                                <div class="sub sub2">
		                                </div>
		                            </div>
		                            <div class="title">
		                                <p><?=$ks->name?>开奖公告</p>
		                            </div>
		                        </div>
		                        <div class="childContent">
		                            <div class="basic_information">
										<div class="table_betting_main table_betting_active">
											 <table class="table_reference"> 
										       <thead class="tbody_referencea">
										          <tr> 
										            <th><span>期号</span></th> 
										            <th><span>奖号</span></th> 
										            <th><span>和值</span></th>
										            <th><span>形态</span></th> 
										          </tr> 
										         </thead>
										         <tbody class="tbody_referenceb tbody_referencebc" id="Recent_lottery_html">
													 <tr class="nothover">
														 <td colspan="4" class="record_p">
															 加载中...
														 </td>
													 </tr>
										        </tbody>
										      </table>
										      <hr class="style12">
										</div>
									</div>
		                        </div>
		                    </div>
		                    <!--玩法详情介绍-->
		                    <div class="child">
		                        <div class="childTitle">
		                            <div class="childIcon">
		                                <div class="sub sub1">
		                                </div>
		                                <div class="sub sub2">
		                                </div>
		                            </div>
		                            <div class="title">
		                                <p>玩法详情介绍</p>
		                            </div>
		                        </div>
		                        <div class="childContent" style="display: none;">
		                            <div class="basic_information">
										<div class="table_betting_main table_betting_active">
											 <p class="jiesao_ks">本平台快3开奖结果是根据<span>江苏快三</span>，<span>安徽快三</span>，<span>广西快三</span>，<span>吉林快三</span>，<span>湖北快三</span>，<span>河北快三</span>开奖为依据的。另外会员可以下注单，双，大，小。</p>
											 <h1 class="title_ks">快三游戏八大解读</h1>
											 <div class="introduce_ks">
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">5</span>
																<b>+</b>
																<span class="key_shadow_numint">3</span>
															</div>
															<p>和值投注</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对三个号码的和值进行投注，包括“和值3”至“和值18”投注</p>
															<p>最少10元投注</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">111</span>
																<b>+</b>
																<span class="key_shadow_numint">333</span>
																<b>+</b>
																<span class="key_shadow_numint">666</span>
															</div>
															<p>三同号通选</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对所有相同的三个号码111-666进行投注</p>
															<p>10元可包全部投注</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">111</span>
																<b>+</b>
																<span class="key_shadow_numint">333</span>
																<b>+</b>
																<span class="key_shadow_numint">666</span>
															</div>
															<p>三同号单选</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对所有相同的三个号码111-666进行投注</p>
															<p>10元可中1800元</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">2</span>
																<b>+</b>
																<span class="key_shadow_numint">2</span>
																<b>+</b>
																<span class="key_shadow_numint">3</span>
															</div>
															<p>二同号复选</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个号码中的2个指定的相同号码进行投注</p>
															<p>10元可中115元</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">*</span>
															</div>
															<p>二同号单选</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个号码中的2个指定的相同号码和1个指定的不同号码进行投注</p>
															<p>10元可中600元</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">5</span>
																<b>+</b>
																<span class="key_shadow_numint">3</span>
															</div>
															<p>三不同号</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个各不相同的号码进行投注</p>
															<p>10元可中325元</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">5</span>
																<b>+</b>
																<span class="key_shadow_numint">4</span>
																<b>+</b>
																<span class="key_shadow_numint">*</span>
															</div>
															<p>二不同号</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个号码中的2个指定的不同号码进行投注</p>
															<p>10元可中65元</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">2</span>
																<b>+</b>
																<span class="key_shadow_numint">3</span>
															</div>
															<p>三连号通选</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个相连的号码(123,456)进行投注</p>
															<p>10元可包全部4注</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">5</span>
																<b>+</b>
																<span class="key_shadow_numint">3</span>
															</div>
															<p>和值投注</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个号码的和值单双不同号码进行投注</p>
															<p>10元可中18元</p>
														</div>
													</div>
												</div>
												<div class="introduce_ks_main">
													<div class="introduce_left">
														<div class="center_ks_int">
															<div class="radio_int">
																<span class="key_shadow_numint">1</span>
																<b>+</b>
																<span class="key_shadow_numint">5</span>
																<b>+</b>
																<span class="key_shadow_numint">3</span>
															</div>
															<p>和值投注</p>
														</div>
													</div>
													<div class="introduce_right">
														<div class="center_ks_intb">
															<p>对3个号码的和值大小不同号码进行投注</p>
															<p>10元可中18元</p>
														</div>
													</div>
												</div>
											 </div>
											 <div class="text_main_intr">
												<p><span>1.</span>快3投注是指以三个号码组合为一注进行单式投注，每个投注号码为1-6共六个自然数中的任意一个，一组三个号码的组合称为一注。购买者可对其选定的投注号码进行多倍投注。单张彩票的投注金额最高无上限。</p>
												<p><span>2.</span>购买者可在本平台进行投注，投注号码记录为江苏快三开奖凭证，开奖时将结算到账户。</p>
												<p><span>3.</span>快3游戏根据号码组合共分为"和值"、"三同号"、"二同号"、"三不同号"、"二不同号"、"三连号通选(即全包)"投注方式，具体规定如下：</p>
												<ul class="text_main_intr_ula">
													<li>（一）和值投注：是指对三个号码的和值进行投注，包括"和值4"至"和值17"投注。</li>
													<li>（二）三同号投注：是指对三个相同的号码进行投注，具体分为：</li>
														<ul>
															<li>1、三同号通选：是指对所有相同的三个号码（111、222、…、666）进行投注；</li>
															<li>2、三同号单选：是指从所有相同的三个号码（111、222、…、666）中任意选择一组号码进行投注。</li>
														</ul>
													<li>（三）二同号投注：是指对两个指定的相同号码进行投注，具体分为：</li>
														<ul>
															<li>1、三同号通选：是指对所有相同的三个号码（111、222、…、666）进行投注；</li>
															<li>2、三同号单选：是指从所有相同的三个号码（111、222、…、666）中任意选择一组号码进行投注。</li>
														</ul>
													<li>（四）三不同号投注：是指对三个各不相同的号码进行投注。</li>
													<li>（五）二不同号投注：是指对三个号码中两个指定的不同号码和一个任意号码进行投注。</li>
													<li>（六）三连号通选投注：是指对所有三个相连的号码（仅限：123、234、345、456）进行投注。</li>
												</ul>
												<p><span>4.</span>快3游戏每期销售时间为10分钟。销售期号以销售日按每期开奖顺序编排。</p>
											 </div>
										</div>
									</div>
		                        </div>
		                    </div>
		                </div>
	                </div>
			</div>
		</div>	
	</div>
</div>
</main>
<script id="Recent_bets" type="text/html">
{{each info as v}}
	<tr class="screen_nowin_a">
		<td><span>{{v.name}}</span></td>
		<td><span>{{v.lottery_period}}</span></td>
		<td><span>{{v.bt_name}}</span></td>
		<td><span>{{v.betting_number}}</span></td>
		<td><span>{{v.betting_money}}</span></td>
		<td><span>{{v.winning_money}}</span></td>
		<td><span>{{v.p_number}}</span></td>
		<td>
			{{if v.betting_state=='y'}}
				<span class="tdbetting-active-aa">中奖</span>
			{{else if v.betting_state=='s'}}
				<span class="tdbetting-active-b">未开奖</span>
			{{else}}
				<span>未中奖</span>
			{{/if}}
		</td>
		<td><span>{{v.betting_time}}</span></td>
	</tr>
{{/each}}
</script>
<script id="no_Recent_bets" type="text/html">
	<tr class="nothover">
		<td colspan="9" class="record_p">
			近期无投注记录
		</td>
	</tr>
</script>
<script id="Recent_lottery" type="text/html">
	{{each info as v}}
	<tr class="screen_nowin_a">
		<td><span>{{v.lottery_period}}</span></td>
		<td><span class="color_red_da">{{v.p_number}}</span></td>
		<td><span>{{v.sumvalue}}</span></td>
		<td>
			<span class="Cl_ico">
				{{if v.p_size=='y'}}
				<i class="da_icoa">大</i>
				{{else}}
				<i class="xiao_icoc">小</i>
				{{/if}}
			</span>
			|
			<span class="Cl_ico">
				{{if v.p_odd_even=='y'}}
				<i class="shuang_icod">双</i>
				{{else}}
				<i class="dan_icob">单</i>
				{{/if}}
			</span>
		</td>
	</tr>
	{{/each}}
</script>
<script id="no_Recent_lottery" type="text/html">
	<tr class="nothover">
		<td colspan="4" class="record_p">
			最近12小时无开奖记录
		</td>
	</tr>
</script>
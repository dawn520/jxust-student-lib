<?php

/***********************************************************************
 Class:        正方数字校园API
 Version:      1.0
 By：          周晨希 · 2016/6/30
 ***********************************************************************/
namespace Org\Util;

class CAApi {
	/**
	 *全局参数
	 *$ykth 一卡通号
	 *$password 密码
	 *$cookie cookie      
	 */
	private  $ykth;        
    private  $password;   
    private  $cookie;
    /**
     * 类初始化
     * 
     * @param String $ykth
     * @param String $password
     * @param String $mode   1为教务系统模式
	 *                       2为一卡通模式
	 *                       3为图书馆模式
	 *                       4为财务系统模式
	 * 实例化类时 ，必须带上相应模式的参数，每个模式下可自由使用其方法，使用不同模式下的方法需要重新
	 * 实例化，否则实例化失败将无法使用
     */
    public function __construct($ykth,$password,$mode){    
    	$this->ykth = $ykth; 
    	$this->password = $password;
    	switch ($mode){
    		case 0:
    			$url = 'http://ca.jxust.edu.cn/zfca/login?login=0122579031373493685&url=protal_content.aspx&yhlx=student';
    			break;
    	    case 1:
    	    	$url = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;  	    	
    	    case 2:
    	    	$url = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;
    	    case 3:
    	    	$url = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;
    	    default:
    	    	$url = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;
    	}
    	$url = 'http://ca.jxust.edu.cn/zfca/login?login=0122579031373493685&url=protal_content.aspx&yhlx=student';
    	$result = $this->curl_request($url,'','',1,$url);
    	$caCookie = $result["cookie"];
    	$pattern = '/<input type="hidden" name="lt" value="(.*?)"[^>]*\/>/is';
    	preg_match_all($pattern,$result['content'],$matches);
    	$lt = $matches[1][0];
    	$caCookiel = explode("=", $caCookie);
    switch ($mode){
    		case "jiaowu":  	
    			$url1 = "http://ca.jxust.edu.cn/zfca/login;jsessionid=".$caCookiel."?login=0122579031373493685&url=protal_content.aspx&yhlx=student";
    			break;
    	    case "yikatong":	
    	    	$url1 = "http://ca.jxust.edu.cn/zfca/login;jsessionid=".$caCookiel."?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;  	    	
    	    case "tushuguan":
    	    	$url1 = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;
    	    case "caiwu":
    	    	$url1 = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;
    	    default:
    	    	$url1 = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
    	    	break;
    	}	
    	$post['useValidateCode'] = "0";
    	$post['isremenberme'] = "0";
    	$post['username'] = $this->ykth;
    	$post['password'] = $this->password;
    	$post['lt'] = $lt;
    	$post['_eventId'] = 'submit';
    	$result1 = $this->curl_request($url1,$post,$caCookie,1,$url1);
    	preg_match_all("/Set\-Cookie:([^;]*);/",$result1['content'],$matches);
    	$jwCookie = $matches['1']['0'];
    	$this->cookie = $jwCookie;
    }
    
    
    
    
    
	/**
	 * 
	 * 
	 */
	function loginPage(){
		$url = "http://ca.jxust.edu.cn/zfca/login?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
		$result = $this->curl_request($url,'','',1,$url);
		$caCookie = $result["cookie"];
 		$pattern = '/<input type="hidden" name="lt" value="(.*?)"[^>]*\/>/is';
		preg_match_all($pattern,$result['content'],$matches);
		$lt = $matches[1][0];
		var_dump($caCookie);
		
		$caCookiel = explode("=", $caCookie);
		//var_dump($caCookiel);
		$url1 = "http://ca.jxust.edu.cn/zfca/login;jsessionid=".$caCookiel."?yhlx=student&login=0122579031373493699&url=http://ecard.jxust.edu.cn/jxustPortalHome.action";
		$post['useValidateCode'] = "0";
		$post['isremenberme'] = "0";

		$post['username'] = $this->ykth;
		$post['password'] = $this->password;
		//$post['losetime'] = "240";
		$post['lt'] = $lt;
		$post['_eventId'] = 'submit';

		//var_dump($post);
		$result1 = $this->curl_request($url1,$post,$caCookie,1,$url1);
		preg_match_all("/Set\-Cookie:([^;]*);/",$result1['content'],$matches);
		$jwCookie = $matches['1']['0'];
		
		
		
		$url2 = 'http://ecard.jxust.edu.cn/accountcardUser.action';
		$result2 = $this->curl_request($url2,'',$jwCookie);
		$result2 = $this->safeEncoding($result2);
		//var_dump($result1);
	//	var_dump($matches);
	//	var_dump($jwCookie);
		
		return $result2;
		
	}
	/**
	 * 获取学生信息
	 * 
	 * xixi 2016/08/01
	 */
	public function getJwTitle() {
		$url = "http://jw.jxust.edu.cn/xs_main.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$result = $this->curl_request($url,'',$this->cookie);
		$result = $this->safeEncoding($result);
		preg_match_all('/<title>([\s\S]*?)<\/title>/',$result,$rs);		
		return $rs;
	}
	/**
	 * 获取学生信息
	 * 
	 * xixi 2016/08/01
	 */
	public function  getInfo() {
		$url = "http://jw.jxust.edu.cn/xsgrxx.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$result = $this->curl_request($url,'',$this->cookie);
		$result = $this->safeEncoding($result);
		preg_match_all('/<table class="formlist" width="100%" align="center">([\s\S]*?)<\/table>/',$result,$rs);
		preg_match_all('/<option selected="selected" [^>]*>([\s\S]*?)<\/option>/',$result,$sex);
		$arr = $this->get_td_array($rs['0']['0']);
		if(!empty($arr)){
			$data['name'] = $arr['1']['1'];
			$data['sex'] = $sex['1']['0'];
			$data['xueyuan'] = $arr['12']['1'];
			$data['zhuanye'] = $arr['14']['1'].$arr['20']['1'].'级';
			$data['class'] = $arr['16']['1'];
		}
		return $data;		
	}
	
	/**
	 * 获取考试
	 *
	 * xixi 2016/08/01
	 */
	public function getExam() {
		$url = "http://jw.jxust.edu.cn/xskscx.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$result = $this->curl_request($url,'',$this->cookie);
		$result = $this->safeEncoding($result);
		preg_match_all('/<table class="datelist" [^>]*>([\s\S]*?)<\/table>/',$result,$rs);
		$arr = $this->get_td_array($rs['0']['0']);
		if(count($arr)==1){
			$shuzu = "";
			$shuzu = '暂时没有查到考试';
		}else{
			$shuzu = array();
			$i=0;
			for($d = 1;$d<count($arr);$d++){
				$kcmc = $arr[$d][3];
				$shuzu[$i]['kcmc'] = $arr[$d]['1'];
				$shuzu[$i]['kssj'] = $arr[$d]['3'];
				preg_match_all('/\((.*?)\)/',$arr[$d]['3'], $rq);
				$shuzu[$i]['ksrq'] = strtotime("".$rq['1']['0']."");
				$shuzu[$i]['ksjs'] = mb_substr($arr[$d]['3'],-5,null,'utf-8');
				$shuzu[$i]['ksdd'] = $arr[$d]['4'];
				$shuzu[$i]['zwh'] = $arr[$d]['6'];
				$shuzu[$i]['xq'] = $arr[$d]['7'];
				$i++;
			}
		}
		return $shuzu;	
	}
	
	/**
	 * 获取课表
	 *
	 * xixi 2016/08/01
	 */
	public function getClass() {
		$url = "http://jw.jxust.edu.cn/xskbcx.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$result = $this->curl_request($url,'',$this->cookie);
		$result = $this->safeEncoding($result);
		preg_match_all('/<table id="Table1" [^>]*>([\s\S]*?)<\/table>/',$result,$rs);
		$arr = $this->get_td_array2($rs[0][0]);
		$shuzu = array(
				"0" => array(
						"0" => $arr[2][2],
						"1" => $arr[2][3],
						"2" => $arr[2][4],
						"3" => $arr[2][5],
						"4" => $arr[2][6],
						"5" => $arr[2][7],
						"6" => $arr[2][8],
						"7" => "一二节"
				),
				"1" => array(
						"0" => $arr[4][2],
						"1" => $arr[4][3],
						"2" => $arr[4][4],
						"3" => $arr[4][5],
						"4" => $arr[4][6],
						"5" => $arr[4][7],
						"6" => $arr[4][8],
						"7" => "三四节"
				),
				"2" => array(
						"0" => $arr[6][2],
						"1" => $arr[6][3],
						"2" => $arr[6][4],
						"3" => $arr[6][5],
						"4" => $arr[6][6],
						"5" => $arr[6][7],
						"6" => $arr[6][8],
						"7" => "五六节"
				),
				"3" => array(
						"0" => $arr[8][2],
						"1" => $arr[8][3],
						"2" => $arr[8][4],
						"3" => $arr[8][5],
						"4" => $arr[8][6],
						"5" => $arr[8][7],
						"6" => $arr[8][8],
						"7" => "七八节"
				),
				"4" => array(
						"0" => $arr[10][2],
						"1" => $arr[10][3],
						"2" => $arr[10][4],
						"3" => $arr[10][5],
						"4" => $arr[10][6],
						"5" => $arr[10][7],
						"6" => $arr[10][8],
						"7" => "九十节"
				)
	
		);
		for($i=0;$i<5;$i++){
			for($j=0;$j<7;$j++){
				preg_match_all('/<ahref=[^>]*>([\s\S]*?)<\/a>/',$shuzu[$i][$j],$info);
				$okinfo=array();
				for($k=0;$k<count($info['1']);$k++){
					$kcinfo = explode('<br>',$info['1'][$k]);
					$kcinfo1['kcmc'] = $kcinfo['0'];//课程名称
					$kcinfo1['sksj'] = $kcinfo['1'];//上课时间
					$kcinfo1['rkjs'] = $kcinfo['2'];//任课教师
					$kcinfo1['skdd'] = $kcinfo['3'];//上课地点
					$okinfo[] = $kcinfo1;
				}
				$shuzu[$i][$j] = $okinfo;
			}
		}
		return $shuzu;
	}
	/**
	 * 获取历史课表
	 *
	 * xixi 2016/08/01
	 */
	public function getHistoricClass($xn,$xq) {
		$url = "http://jw.jxust.edu.cn/xskbcx.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$result = $this->curl_request($url,'',$this->cookie);
		$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/is';
		preg_match_all($pattern,$result,$matches);
		$viewState = $matches[1][0];
		$post['__VIEWSTATE'] = $viewState;
		$post['__EVENTTARGET'] = 'xnd';
		$post['__EVENTARGUMENT'] = '';
		$post['xnd'] = $xn;
		$post['xqd'] = $xq;
		$result = $this->curl_request($url,$post,$this->cookie);
		$result = $this->safeEncoding($result);
		preg_match_all('/<table id="Table1" [^>]*>([\s\S]*?)<\/table>/',$result,$rs);
		$arr = $this->get_td_array2($rs[0][0]);
		$shuzu = array(
				"0" => array(
						"0" => $arr[2][2],
						"1" => $arr[2][3],
						"2" => $arr[2][4],
						"3" => $arr[2][5],
						"4" => $arr[2][6],
						"5" => $arr[2][7],
						"6" => $arr[2][8],
						"7" => "一二节"
				),
				"1" => array(
						"0" => $arr[4][2],
						"1" => $arr[4][3],
						"2" => $arr[4][4],
						"3" => $arr[4][5],
						"4" => $arr[4][6],
						"5" => $arr[4][7],
						"6" => $arr[4][8],
						"7" => "三四节"
				),
				"2" => array(
						"0" => $arr[6][2],
						"1" => $arr[6][3],
						"2" => $arr[6][4],
						"3" => $arr[6][5],
						"4" => $arr[6][6],
						"5" => $arr[6][7],
						"6" => $arr[6][8],
						"7" => "五六节"
				),
				"3" => array(
						"0" => $arr[8][2],
						"1" => $arr[8][3],
						"2" => $arr[8][4],
						"3" => $arr[8][5],
						"4" => $arr[8][6],
						"5" => $arr[8][7],
						"6" => $arr[8][8],
						"7" => "七八节"
				),
				"4" => array(
						"0" => $arr[10][2],
						"1" => $arr[10][3],
						"2" => $arr[10][4],
						"3" => $arr[10][5],
						"4" => $arr[10][6],
						"5" => $arr[10][7],
						"6" => $arr[10][8],
						"7" => "九十节"
				)
	
		);
		for($i=0;$i<5;$i++){
			for($j=0;$j<7;$j++){
				preg_match_all('/<ahref=[^>]*>([\s\S]*?)<\/a>/',$shuzu[$i][$j],$info);
				$okinfo=array();
				for($k=0;$k<count($info['1']);$k++){
					$kcinfo = explode('<br>',$info['1'][$k]);
					$kcinfo1['kcmc'] = $kcinfo['0'];//课程名称
					$kcinfo1['sksj'] = $kcinfo['1'];//上课时间
					$kcinfo1['rkjs'] = $kcinfo['2'];//任课教师
					$kcinfo1['skdd'] = $kcinfo['3'];//上课地点
					$okinfo[] = $kcinfo1;
				}
				$shuzu[$i][$j] = $okinfo;
			}
		}
		return $shuzu;
	}
	/**
	 * 获取成绩
	 *
	 * xixi 2016/08/01
	 */
	public function getGrade() {
		$url = "http://jw.jxust.edu.cn/xscj_gc.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$result = $this->curl_request($url,'',$this->cookie);
		$pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/is';
		preg_match_all($pattern,$result,$matches);
		$VIEWSTATE= $matches[1][0];
		
		$url = "http://jw.jxust.edu.cn/xscj_gc.aspx?xh=".mb_substr($this->ykth,2,8,'utf-8');
		$post['ddl_kcxz'] = '';
		$post['Button2'] = "在校学习成绩查询";
		$post['__VIEWSTATE'] = $VIEWSTATE;
		$result = $this->curl_request($url,$post,$this->cookie);
		$result = $this->safeEncoding($result);
		preg_match_all('/<table class="datelist" [^>]*>([\s\S]*?)<\/table>/',$result,$rs);
		$arr = $this->get_td_array($rs[0][0]);
		if(count($arr)==1){
			$shuzu = "";
			$shuzu = '暂时没有查到成绩';
		}else{
			$shuzu = array();
			$i=0;
			for($d = 1;$d<count($arr);$d++){
				$kcmc = $arr[$d][3];
				$shuzu[$i]['kcmc'] = $arr[$d][3];
				$shuzu[$i]['xn'] = $arr[$d][0];
				$shuzu[$i]['xq'] = $arr[$d][1];
				$shuzu[$i]['kcxz'] = $arr[$d][4];
				$shuzu[$i]['xf'] = $arr[$d][6];
				$shuzu[$i]['jd'] = $arr[$d][7];
				$shuzu[$i]['cj'] = $arr[$d][8];
				$shuzu[$i]['bkcj'] = $arr[$d][10];
				$shuzu[$i]['cxcj'] = $arr[$d][11];
				$shuzu[$i]['kcdm'] = $arr[$d][2];
				$i++;
			}
		}
		return $shuzu;
	}	
	/**
	 * 获取一卡通账户基本信息
	 *
	 * xixi 2016/09/04
	 */
	public function ecardAccount() {
		$url = 'http://ecard.jxust.edu.cn/accountcardUser.action';
		$result = $this->curl_request($url,'',$this->cookie);
		$result = $this->safeEncoding($result);
		$pattern = '/<table width="63" border="1" cellpadding="0" cellspacing="0" bordercolor="#EFF8FF">([\s\S]*?)<\/table>/';
		$result = preg_replace($pattern,'',$result);
		$pattern = '/<table [^>]*>([\s\S]*?)<\/table>/';
		preg_match_all($pattern,$result,$matches);
		$arr = $this->get_td_array($matches['0']['0']);
		if(empty($arr['2']['1'])){
			$shuzu = "";
			$shuzu = 'false';
		}else{
			$shuzu = array();
			$shuzu['kzt'] = $arr['11']['3'];
			$shuzu['djzt'] = $arr['11']['5'];
			$shuzu['yexq'] = $arr['12']['1'];
			$ye = strpos($shuzu['yexq'],'元');
			$shuzu['ye'] = mb_substr($shuzu['yexq'],0,$ye);
			$shuzu['gszt'] = $arr['12']['5'];
		}
		return $shuzu;
	}
	/**
	 * 获取一卡通今日流水
	 *
	 * xixi 2016/09/04
	 */
	public 	function todayBill() {
		$url = 'http://ecard.jxust.edu.cn/accounttodayTrjn.action';
		$result = $this->curl_request($url,'',$this->cookie);
		$pattern = '/<select id="account" name="account" class = "and">[^>]*<option [^>]*>([\s\S]*?)<\/option>[^>]*<\/select>/';
		preg_match_all($pattern,$result,$matches);
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$ecardid = str_replace($qian,$hou,$matches['1']['0']);
		$url = 'http://ecard.jxust.edu.cn/accounttodatTrjnObject.action';
		$post['account'] = $ecardid;
		$post['inputObject'] = "all";
		$post['Submit'] = " 确 定 ";
		$result = $this->curl_request($url,$post,$this->cookie);
		$result = $this->safeEncoding($result);
		$pattern = '/<table [^>]* id="tables">([\s\S]*?)<\/table>/';
		preg_match_all($pattern,$result,$matches);
		$arr = $this->get_td_array($matches['0']['0']);
		if(count($arr)==1){
			$shuzu = "";
			$shuzu = '暂时没有查到数据';
		}else{
			$shuzu = array();
			$i=0;
			for($d = 1;$d<count($arr)-1;$d++){
				$jysj = strtotime("".$arr[$d]['0']."");
				$shuzu[$i]['jysj'] =  date("Y年m月d日 H:i:s",$jysj);
				$shuzu[$i]['jydd'] = $arr[$d]['2'];	
				$shuzu[$i]['jye'] = $arr[$d]['4'];	
				$shuzu[$i]['xyye'] = $arr[$d]['5'];	
				$shuzu[$i]['zt'] = $arr[$d]['7'];	
				$i++;
			}
		}
		return $shuzu;
	}
	/**
	 * 获取一卡通历史流水
	 *
	 * xixi 2016/09/04
	 */
	function pastBill($datefrom,$dateto) {
		$url = 'http://ecard.jxust.edu.cn/accounthisTrjn.action';
		$result = $this->curl_request($url,'',$this->cookie);
		$pattern = '/<select id="account" name="account" class = "and">[^>]*<option [^>]*>([\s\S]*?)<\/option>[^>]*<\/select>/';
		preg_match_all($pattern,$result,$matches);
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$ecardid = str_replace($qian,$hou,$matches['1']['0']);
		$pattern = '/<form id="accounthisTrjn" [^>]* action="(.*?)" [^>]*>/';
		preg_match_all($pattern,$result,$matches);
		$action = str_replace($qian,$hou,$matches['1']['0']);
		$url = 'http://ecard.jxust.edu.cn'.$action;
		$post['account'] = $ecardid;
		$post['inputObject'] = "all";
		$post['Submit'] = " 确 定 ";
		$result = $this->curl_request($url,$post,$this->cookie);
		//$result = $this->safeEncoding($result);
		$pattern = '/<form [^>]* name="form1" [^>]* action="(.*?)" [^>]*>/';
		preg_match_all($pattern,$result,$matches);
		$action = str_replace($qian,$hou,$matches['1']['0']);
		$url = 'http://ecard.jxust.edu.cn'.$action;
		$datefrom = strtotime("".$datefrom."");
		$dateto = strtotime("".$dateto."");
		$datefrom = date("Ymd",$datefrom);
		$dateto = date("Ymd",$dateto);
		$post['inputStartDate'] = $datefrom;
		$post['inputEndDate'] = $dateto;
		$result = $this->curl_request($url,$post,$this->cookie);
		$pattern = '/<form [^>]* name="form1" [^>]* action="(.*?)" [^>]*>/';
		preg_match_all($pattern,$result,$matches);
		$action = str_replace($qian,$hou,$matches['1']['0']);
		$url = 'http://ecard.jxust.edu.cn/accounthisTrjn.action'.$action;
		$result = $this->curl_request($url,'',$this->cookie);
		$result = $this->safeEncoding($result);
		$pattern = '/<table [^>]* id="tables" [^>]*>([\s\S]*?)<\/table>/';
		preg_match_all($pattern,$result,$matches);
		$arr = $this->get_td_array($matches['0']['0']);
		$pattern = '/form1.pageNum.value=(.*?);/';
		preg_match_all($pattern,$result,$matches);
		$allpage = $matches['1']['1'];
		$i = 0;
		if(count($arr)==1){
			$shuzu = "";
			$shuzu = '暂时没有查到数据';
		}else{
			$shuzu = array();
			for($d = 1;$d<count($arr)-1;$d++){
				$jysj = strtotime("".$arr[$d]['0']."");
				$shuzu[$i]['jysj'] = date("Y年m月d日 H:i:s",$jysj);
				$shuzu[$i]['jydd'] = $arr[$d]['2'];
				$shuzu[$i]['jye'] = $arr[$d]['3'];
				$shuzu[$i]['xyye'] = $arr[$d]['4'];
				$shuzu[$i]['zt'] = $arr[$d]['6'];
				$i++;
			}
		}
		if($allpage>1){
			for($j=2;$j<=$allpage;$j++){
				$url = 'http://ecard.jxust.edu.cn/accountconsubBrows.action';
				$post['inputStartDate'] = $datefrom;
				$post['inputEndDate'] = $dateto;
				$post['pageNum'] = $j;
				$result = $this->curl_request($url,$post,$this->cookie);
				$result = $this->safeEncoding($result);
				$pattern = '/<table [^>]* id="tables" [^>]*>([\s\S]*?)<\/table>/';
				preg_match_all($pattern,$result,$matches);
				$arr = $this->get_td_array($matches['0']['0']);
				for($d = 1;$d<count($arr)-1;$d++){
					$jysj = strtotime("".$arr[$d]['0']."");
					$shuzu[$i]['jysj'] = date("Y年m月d日 H:i:s",$jysj);
					$shuzu[$i]['jydd'] = $arr[$d]['2'];
					$shuzu[$i]['jye'] = $arr[$d]['3'];
					$shuzu[$i]['xyye'] = $arr[$d]['4'];
					$shuzu[$i]['zt'] = $arr[$d]['6'];
					$i++;
				}
			}
		}
		return $shuzu;
	}
	

	// 参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
	function curl_request($url,$post = '',$cookie = '',$returnCookie = 0,$referer) {
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($curl,CURLOPT_AUTOREFERER,1);
		curl_setopt($curl,CURLOPT_REFERER,$referer);
		if($post){
			curl_setopt($curl,CURLOPT_POST,1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($post));
		}
		if($cookie){
			curl_setopt($curl,CURLOPT_COOKIE,$cookie);
		}
		curl_setopt($curl,CURLOPT_HEADER,$returnCookie);
		curl_setopt($curl,CURLOPT_TIMEOUT,10);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($curl);
		if(curl_errno($curl)){
			return curl_error($curl);
		}
		curl_close($curl);
		if($returnCookie){
			list($header,$body) = explode("\r\n\r\n",$data,2);
			preg_match_all("/Set\-Cookie:([^;]*);/",$header,$matches);
			$info['cookie'] = substr($matches[1][0],1);
			$info['content'] = $body;
			return $info;
		}else{
			return $data;
		}
	}
	
	// 获取
	// 参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
	function curl_request1($url,$post = '',$cookie = '',$returnCookie = 0,$referer) {
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($curl,CURLOPT_AUTOREFERER,1);
		curl_setopt($curl,CURLOPT_REFERER,$referer);
		if($post){
			curl_setopt($curl,CURLOPT_POST,1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($post));
		}
		if($cookie){
			curl_setopt($curl,CURLOPT_COOKIE,$cookie);
		}
		curl_setopt($curl,CURLOPT_HEADER,$returnCookie);
		curl_setopt($curl,CURLOPT_TIMEOUT,10);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($curl);
		if(curl_errno($curl)){
			return curl_error($curl);
		}
		curl_close($curl);
		if($returnCookie){
			list($header,$body) = explode("\r\n\r\n",$data,2);
			preg_match_all("/Set\-Cookie:([^;]*);/",$header,$matches);
			$info['cookie'] = substr($matches[1][0],1);
			$info['content'] = $body;
			return $info;
		}else{
			return $data;
		}
	}
	// 表格转化数组函数
	function get_td_array($table) {
		$table = preg_replace("'<table[^>]*?>'si","",$table);
		$table = preg_replace("'<tr[^>]*?>'si","",$table);
		$table = preg_replace("'<td[^>]*?>'si","",$table);
		$table = preg_replace("'<TD[^>]*?>'si","",$table);
		$table = str_replace("</tr>","{tr}",$table);
		$table = str_replace("</td>","{td}",$table);
		$table = str_replace("</TD>","{td}",$table);
		// 去掉 HTML 标记
		$table = preg_replace("'<[/!]*?[^<>]*?>'si","",$table);
		// 去掉空白字符
		$table = preg_replace("'([rn])[s]+'","",$table);
		$table = preg_replace('/&nbsp;/',"",$table);
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$table = str_replace($qian,$hou,$table);
		
		$table = explode('{tr}',$table);
		array_pop($table);
		$td_array = array();
		foreach($table as $key => $tr){
			$td = explode('{td}',$tr);
			array_pop($td);
			$td_array[] = $td;
		}
		return $td_array;
	}
	
	function get_td_array2($table) {
		$table = preg_replace("'<table[^>]*?>'si","",$table);
		$table = preg_replace("'<tr[^>]*?>'si","",$table);
		$table = preg_replace("'<td[^>]*?>'si","",$table);
		$table = str_replace("</tr>","{tr}",$table);
		$table = str_replace("</td>","{td}",$table);
		// 去掉空白字符
		$table = preg_replace("'([rn])[s]+'","",$table);
		$table = preg_replace('/&nbsp;/',"",$table);
		$qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
		$table = str_replace($qian,$hou,$table);
	
		$table = explode('{tr}',$table);
		array_pop($table);
		$td_array = array();
		foreach($table as $key => $tr){
			$td = explode('{td}',$tr);
			array_pop($td);
			$td_array[] = $td;
		}
		return $td_array;
	}
	
	// 转换为UTF-8编码
	function safeEncoding($str) {
		$code = mb_detect_encoding($str,array(
				'ASCII',
				'GB2312',
				'GBK',
				'UTF-8'
		)); // 检测字符串编码
		if($code=="CP936"){
			$result = $str;
		}else{
			// $result=mb_convert_encoding($str,'UTF-8',$code);//将编码$code转换为utf-8编码
			$result = iconv($code,"UTF-8",$str);
		}
		return $result;
	}
}
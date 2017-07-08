<?php
function encrypt($string) {global $C_CONFIG_KEY; $key=$C_CONFIG_KEY;$result = '';for($i=0; $i<strlen($string); $i++) {$char = substr($string, $i, 1);$keychar = substr($key, ($i % strlen($key))-1, 1);$char = chr(ord($char)+ord($keychar));$result.=$char;}return base64_encode($result);}
function decrypt($string) {global $C_CONFIG_KEY; $key=$C_CONFIG_KEY;$result = '';$string = base64_decode($string);for($i=0; $i<strlen($string); $i++) {$char = substr($string, $i, 1);$keychar = substr($key, ($i % strlen($key))-1, 1);$char = chr(ord($char)-ord($keychar));$result.=$char;}return $result;}

class shorten {
#_________________________________________________________________________________________
	function submiturl ($url,$pass)
	{
	$conf = explode("|",file_get_contents(config));
	$now = $conf[1]+1;
	$data	= base_convert($now, 10, 36);   # 'a'
	$cur = '|'.$now.'|'.$conf[2].'|'.$conf[3].'|'.$conf[4].'|'.$conf[5].'';
	$crypt = encrypt($url);
	if ($pass != "null") {$pass = md5(sha1($pass));}
	$contents = "|0|COUNTRY|REFER|PLANFORM|$crypt|$pass|-9|CLICK|";
	file_put_contents (config,$cur);
	file_put_contents (database.$data.'.crypt',$contents);
	return $data;
	}
#_________________________________________________________________________________________
	function banlist ($url)
	{
		preg_match('@^(?:http://|https://)?([^/]+)@i',$url, $matches);
		$data = $matches[1];
		$ban = "/(is.gd|bit.do|riffhold.com|bitigee.com|aly.vn|shorte.st|linkshrink.net|adyou.me|uskip.me|blv.me|binbucks.com|spaste.com|ah.pe|ouo.io|cash4files.com|linkbucks.com|fas.li|filesonthe.net|goneviral.com|megaline.co|miniurls.co|seriousdeals.net|theseblogs.com|theseforums.com|tinylinks.co|tubeviral.com|ultrafiles.net|urlbeat.net|whackyvidz.com|qqc.co|yyv.co|erq.io|yko.io|tiny.cc|tinyium.com|microify.com|atomcurve.com|mcaf.ee|picocurl.com|ay.gy|ow.ly|goo.gl|bit.ly|shota.one|j.gs|q.gs|tinyurl.com|thinfi.com)/si";
		if ( preg_match ($ban,$data)) { return 'BANNED';} else { return $data;}
	
	}
#_________________________________________________________________________________________
	function checkurl ($url)
	{
		$num = strlen($url);
		if (preg_match('("|<|>|\')',$url)){ return 'n';}
		elseif ($num>=600 OR $num<=5){ return 'n';}
		elseif(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$url)){return 'y';}
		else {return 'n';}
	}
#_________________________________________________________________________________________
	function makeurl (){
	$url = $_POST['url'];
	$password = $_POST['protect'];
	$hash = $_POST['hash'];
	$randid = rand(0,9999);
	$checkhash = $this->hashcreate("0");
	if ($hash!=$checkhash OR !$hash OR !$url) { return '<div class="alert alert-warning"> <i class="fa fa-times" aria-hidden="true"></i> Your url may seem not a url, or that denied</div>';}
	else {
	$short = "shota.one/FReA";
	$thisurl = $this->checkurl($url);
	if ($_SESSION['lasturl'] == $url) { $short=$_SESSION['short'];}
	elseif ($thisurl=="n" OR $this->banlist($url) == 'BANNED') { $short='NOT A URL';}
	else  { $short="shota.one/".$this->submiturl($url,$password);}
	
	
	#
	if ($short != 'NOT A URL'){
	$_SESSION['lasturl'] = $url;
	$_SESSION['short'] = $short;
	}
	#
	if ($short == 'NOT A URL') { return '<div class="alert alert-warning"> <i class="fa fa-times" aria-hidden="true"></i> Your url may seem not a url, or that denied</div>';}
	return '<script>$(\'.demo-2'.$randid.'\').click(function(){$(\'.urlcopyed'.$randid.'\').CopyToClipboard();});</script>

	<div class="input-group" style="max-width:400px">
	<input onClick="this.select();" class="form-control input-lg urlcopyed'.$randid.'"  readonly id="yoururl" type="text" value="'.$short.'">
	<span class="input-group-btn"><button onClick="" id="shotaone'.$randid.'" class="btn btn-primary btn-lg demo-2'.$randid.'" type="button">Copy</button></span>
	</div>
	</br>
<script type="text/javascript" charset="utf-8">$(\'#shotaone'.$randid.'\').click( function() {$.gritter.add({title: \'Job done!\',time: 1000,class_name: \'gritter-light\',});flashMsgSound.play();	});</script>

		
		
		
		
		';
	
	
	}
}
#_________________________________________________________________________________________

	function hashcreate ($action) 
	{
		$hash = substr(sha1(md5(time()."shotaonedotcom$#".rand(0,99))),5,8);
		
		if ($action == 'change'){ $_SESSION['hashtime']=time();$_SESSION['hash']=$hash; return $hash;}
		else {return $_SESSION['hash'];}
	}
#_________________________________________________________________________________________
	function hashgo ($action) 
	{
		$hash = substr(sha1(md5(time()."shotaonedotcom$#".rand(0,99))),5,8);
		
		if ($action == 'change'){ $_SESSION['hashtimego']=time();$_SESSION['hashgo']=$hash; return $hash;}
		else {return $_SESSION['hashgo'];}
	}

#_________________________________________________________________________________________

	function short()
	{
		return '
			
			<div class="input-group">
				<input class="form-control input-lg" id="url" type="text" placeholder="URL">
				<input class="form-control input-lg" id="hash" type="hidden" value="'.$this->hashcreate('change').'">
				
				<span class="input-group-btn"><button id="shotaone" class="btn btn-success btn-lg" type="button">Shorten</button></span>
			</div>
				
					<br />
					
				<input style="max-width:350px"  onblur="if(document.getElementById(\'passprotect\').type==\'text\'){document.getElementById(\'passprotect\').type=\'password\';}" onclick="if(document.getElementById(\'passprotect\').type==\'password\'){document.getElementById(\'passprotect\').type=\'text\';}" class="form-control input-lg" id="passprotect" type="text" placeholder="Optional: password protect url">
			
					<hr />
					<div id="result"></div>
		<script type="text/javascript" charset="utf-8">
			$("#shotaone").click(function(){
				var url = document.getElementById("url").value;
				var protect = document.getElementById("passprotect").value;
				var hash = document.getElementById("hash").value;
				if (!protect) { protect="null";}
					if (url || protect){
					$.post("return.php?makeurl=true",
					{
						url: url,
						protect: protect,
						hash: hash,
					},function(data,status){    
					if (data.match(/(Your url may seem not a url)/) || data.match(/(BANNED)/) ) {$("#result").html(data);document.getElementById("url").value="";}
					else{$("#result").prepend(data);document.getElementById("url").value="";
					}
					         }); }

	})
		</script>
';
	}
	
}

?>
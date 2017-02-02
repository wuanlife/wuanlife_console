var http_request=false;

function send_request(url){//初始化，指定处理函数，发送请求的函数
    http_request=false;
//开始初始化XMLHttpRequest对象
    if(window.XMLHttpRequest){//Mozilla浏览器
        http_request=new XMLHttpRequest();
        if(http_request.overrideMimeType){//设置MIME类别
            http_request.overrideMimeType("text/xml");
        }
    }else if(window.ActiveXObject){//IE浏览器
        try{
            http_request=new ActiveXObject("Msxml2.XMLHttp");
        }catch(e){
            try{
                http_request=new ActiveXobject("Microsoft.XMLHttp");
            }catch(e){}
        }
    }
    if(!http_request){//异常，创建对象实例失败
        window.alert("创建XMLHttp对象失败！");
        return false;
    }
    http_request.onreadystatechange=processrequest;
//确定发送请求方式，URL，及是否同步执行下段代码
    http_request.open("GET",url,true);
    http_request.send(null);
}

//处理返回信息的函数
function processrequest(){
    if(http_request.readyState==4){//判断对象状态
        if(http_request.status==200){//信息已成功返回，开始处理信息
            document.getElementById(reobj).innerHTML=http_request.responseText;
        }else{//页面不正常
            alert("您所请求的页面不正常！");
        }
    }
}

function checkfourm(obj,id){
    if(id==""){
        document.getElementById(obj).innerHTML='请求出错！';
        return false;
    }else{
        document.getElementById(obj).innerHTML='正在删除。。。';
        send_request("index.php?/wuan/delete/"+id);
        reobj=obj;
        //deleteRemark(id);
	}
}

function deleteRemark(id){
		//document.getElementById(id).innerHTML='请求出错';
        var obj=document.getElementById(id);
        obj.parentNode.removeChild(obj);
        //document.tr.removeChild(document.getElementById(id));
}

function getname(obj){
	var nickname = document.getElementById("nickname").value;
	document.getElementById(obj).innerHTML='正在添加&nbsp;&nbsp;&nbsp;'+nickname;
	send_request("index.php?/wuan/adding/?nickname="+nickname);
    reobj=obj;
}

function starnameupd(obj,id,pn){
	//var nickname = document.getElementById("nickname").value;
	//document.getElementById(obj).innerHTML='正在添加&nbsp;&nbsp;&nbsp;'+nickname;
	send_request("index.php?/wuan/star_name_upd/"+id+"?pn="+pn);
    reobj=obj;
}

function starnameupding(obj,pn){
	var nickname = document.getElementById("starname").value;
	var id = document.getElementById("starnameid").value;
	//document.getElementById(obj).innerHTML='正在添加&nbsp;&nbsp;&nbsp;'+nickname;
	send_request("index.php?/wuan/star_name_upding/"+id+"?starname="+nickname+"&pn="+pn);
    reobj=obj;
}

function staruserupding(obj,pn){
	var uid = document.getElementById("userid").value;
	var gid = document.getElementById("starnameid").value;
	//document.getElementById(obj).innerHTML='正在添加&nbsp;&nbsp;&nbsp;'+nickname;
	send_request("index.php?/wuan/star_user_upding/"+gid+"?uid="+uid+"&pn="+pn);
    reobj=obj;
}

function staruserupd(obj,id,pn){
	send_request("index.php?/wuan/star_user_upd/"+id+"?pn="+pn);
    reobj=obj;
}

function groupcp(obj,id,pn,note){
	//alert("确认操作？");
	//window.location.href="index.php?/wuan/groupcp/"+id+"/"+pn;
	send_request("index.php?/wuan/groupcp/"+id+"/"+pn+"/"+note);
    reobj=obj;
}

function changepage(obj,note,pn){
	
		if(pn=="0"||pn==''||isNaN(pn)){
			document.getElementById(note).value='您的输入有误！';
		}else{
			send_request("index.php?/wuan/change_page?pn="+pn+"&note="+note);
			reobj=obj;
		}
	
}
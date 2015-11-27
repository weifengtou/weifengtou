<?php
/*
*2015-2-9
*/
namespace Admin\Controller;
use Admin\Model\AuthGroupModel;
// use Admin\Controller\ArticleController;

/**
 * 后台文件控制器
 * @author huajie<banhuajie@163.com>
 */
class FileDealController extends AdminController{

	/** 
	 * 此方法为公共方法用来删除某个文件夹下的所有文件
	 * $path为文件的路径
	 * $fileName文件夹名称 
	 */
	/* public function staticIndexDel($path,$fileName){
		if(file_exists($fileName)){
			$path = preg_replace('/(\/){2,}|{\\\}{1,}/','/',$path);//去除空格
			$path = $path.$fileName;//得到完整目录
			unlink($path);//逐一进行删除
			$this->success('删除成功！');
		}else{
			$this->error('静态文件不存在！');
		}
		header("location:admin.php?s=Article/mydocument");
	} */
	public function staticIndexDel(){
		$fileName="index.html";
		if(file_exists($fileName)){
			unlink($fileName);//逐一进行删除
			$this->success('删除成功！');
		}else{
	
			$this->error('静态文件不存在！');
		}
		exit();
		header("location:admin.php?s=Article/mydocument");
	}
	public function CacheDel(){
		$path1 = "Runtime/Cache/Home";	//缓存目录
		if(is_dir($path1)){	//是否为文件目录
			if($dh1 = opendir($path1)){	//打开文件
				while(($file1 = readdir($dh1))!=false){	//遍历文件目录名称
					unlink($path1.'\\'.$file1);
				}
			}
		}
		$path2 = "Runtime/Cache/Admin";	//缓存目录
		if(is_dir($path2)){	//是否为文件目录
			if($dh2 = opendir($path2)){	//打开文件
				while(($file2 = readdir($dh2))!=false){	//遍历文件目录名称
					unlink($path2.'\\'.$file2);
				}
			}
		}
		$path3 = "Runtime/Temp";	//缓存目录
		if(is_dir($path3)){	//是否为文件目录
			if($dh3 = opendir($path3)){	//打开文件
				while(($file3 = readdir($dh3))!=false){	//遍历文件目录名称
					unlink($path3.'\\'.$file3);
				}
			}
		}
		header("location:admin.php?s=Article/mydocument");
	}
}
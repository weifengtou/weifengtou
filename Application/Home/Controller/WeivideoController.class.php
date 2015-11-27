<?php

namespace Home\Controller;

class WeivideoController extends HomeController{
	public function videoFir(){
        $category=D('Category')->getChildrenId(mfilm_manage);
        $list = D('Document')->lists($category, '`level` DESC,`id` DESC', 1,true);
        if(is_array($list)): 
            $i = 0; 
            if(count($list)==0): 
                $this->error("暂无微电影");
            else:
                if (!$_GET[id]):
                    $info = D('Document')->detail($list[0][id]);
                else:
                    $info = D('Document')->detail($_GET[id]);
                    // foreach($list as $key=>$article): $mod = ($i % 2 );
                    //     if (true):$info = D('Document')->detail($article[id]);
                    //         ++$i; 
                    //     endif;
                    // endforeach; 
                endif;
            endif; 
        else: 
            $this->error("暂无微电影");
        endif;

        if ($x = $_GET[filmperiod]) {
            $x = M()->query("SELECT id FROM wft_document_mfilm WHERE filmperiod = '$x'");
            if ($id = $x[0][id]) {
                $info = D('Document')->detail($id);
            }else{
                $this->error("还没有本期微电影，敬请期待！");
            }
        }
        $this->assign('list',$list);
        $this->assign('info',$info);
		$this->display();
    }

    public function mfilm_comm()
    {
    	if (IS_POST) {
    		$data[mfilm_id] = $_POST[mfilm_id];
    		$data[uid] = $_POST[uid];
    		$data[comm_msg] = $_POST[comm_msg];
    		$data[comm_time] = time();
    		if (M("mfilm_comm")->data($data)->add()) {
    			echo "1";
    		}else{
    			echo "0";
    		}
    	}
    	exit;
    }
}
?>
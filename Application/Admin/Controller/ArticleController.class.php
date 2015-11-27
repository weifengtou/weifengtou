<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Admin\Model\AuthGroupModel;
use Think\Page;

/**
 * 后台内容控制器
 * @author huajie<banhuajie@163.com>
 */
class ArticleController extends AdminController {

    /* 保存允许访问的公共方法 */
    static protected $allow = array( 'draftbox','mydocument');

    private $cate_id        =   null; //文档分类id

    /**
     * 检测需要动态判断的文档类目有关的权限
     *
     * @return boolean|null
     *      返回true则表示当前访问有权限
     *      返回false则表示当前访问无权限
     *      返回null，则会进入checkRule根据节点授权判断权限
     *
     * @author 朱亚杰<xcoolcc@gmail.com>
     */
    protected function checkDynamic(){
        if(IS_ROOT){
            return true;//管理员允许访问任何页面
        }
        $cates = AuthGroupModel::getAuthCategories(UID);
        switch(strtolower(ACTION_NAME)){
            case 'index':   //文档列表
                $cate_id =  I('cate_id');
                break;
            case 'edit':    //编辑
            case 'update':  //更新
                $doc_id  =  I('id');
                $cate_id =  M('Document')->where(array('id'=>$doc_id))->getField('category_id');
                break;
            case 'setstatus': //更改状态
            case 'permit':    //回收站
                $doc_id  =  (array)I('ids');
                $cate_id =  M('Document')->where(array('id'=>array('in',$doc_id)))->getField('category_id',true);
                $cate_id =  array_unique($cate_id);
                break;
        }
        if(!$cate_id){
            return null;//不明,需checkRule
        }elseif( !is_array($cate_id) && in_array($cate_id,$cates) ) {
            return true;//有权限
        }elseif( is_array($cate_id) && $cate_id==array_intersect($cate_id,$cates) ){
            return true;//有权限
        }else{
            return false;//无权限
        }
        return null;//不明,需checkRule
    }

    /**
     * 显示左边菜单，进行权限控制
     * @author huajie<banhuajie@163.com>
     */
    protected function getMenu(){
        //获取动态分类
        $cate_auth  =   AuthGroupModel::getAuthCategories(UID); //获取当前用户所有的内容权限节点
        $cate_auth  =   $cate_auth == null ? array() : $cate_auth;
        $cate       =   M('Category')->where(array('status'=>1))->field('id,title,pid,allow_publish')->order('pid,sort')->select();

        //没有权限的分类则不显示
        if(!IS_ROOT){
            foreach ($cate as $key=>$value){
                if(!in_array($value['id'], $cate_auth)){
                    unset($cate[$key]);
                }
            }
        }

        $cate           =   list_to_tree($cate);    //生成分类树

        //获取分类id
        $cate_id        =   I('param.cate_id');
        $this->cate_id  =   $cate_id;

        //是否展开分类
        $hide_cate = false;
        if(ACTION_NAME != 'recycle' && ACTION_NAME != 'draftbox' && ACTION_NAME != 'mydocument'){
            $hide_cate  =   true;
        }

        //生成每个分类的url
        foreach ($cate as $key=>&$value){
            $value['url']   =   'Article/index?cate_id='.$value['id'];
            if($cate_id == $value['id'] && $hide_cate){
                $value['current'] = true;
            }else{
                $value['current'] = false;
            }
            if(!empty($value['_child'])){
                $is_child = false;
                foreach ($value['_child'] as $ka=>&$va){
                    $va['url']      =   'Article/index?cate_id='.$va['id'];
                    if(!empty($va['_child'])){
                        foreach ($va['_child'] as $k=>&$v){
                            $v['url']   =   'Article/index?cate_id='.$v['id'];
                            $v['pid']   =   $va['id'];
                            $is_child = $v['id'] == $cate_id ? true : false;
                        }
                    }
                    //展开子分类的父分类
                    if($va['id'] == $cate_id || $is_child){
                        $is_child = false;
                        if($hide_cate){
                            $value['current']   =   true;
                            $va['current']      =   true;
                        }else{
                            $value['current']   =   false;
                            $va['current']      =   false;
                        }
                    }else{
                        $va['current']      =   false;
                    }
                }
            }
        }
        $this->assign('nodes',      $cate);
        $this->assign('cate_id',    $this->cate_id);

        //获取面包屑信息
        $nav = get_parent_category($cate_id);
        $this->assign('rightNav',   $nav);

        //获取回收站权限
        $show_recycle = $this->checkRule('Admin/article/recycle');
        $this->assign('show_recycle', IS_ROOT || $show_recycle);
        //获取草稿箱权限
        $this->assign('show_draftbox', C('OPEN_DRAFTBOX'));
    }

    /**
     * 分类文档列表页
     * @param $cate_id 分类id
     * @author 朱亚杰<xcoolcc@gmail.com>
     */
    public function index($cate_id = null){
        //获取左边菜单
        $this->getMenu();

        if($cate_id===null){
            $cate_id = $this->cate_id;
        }

        //获取模型信息
        $model = M('Model')->getByName('document');

        //解析列表规则
        $fields = array();
        $grids  = preg_split('/[;\r\n]+/s', $model['list_grid']);
        foreach ($grids as &$value) {
            // 字段:标题:链接
            $val      = explode(':', $value);
            // 支持多个字段显示
            $field   = explode(',', $val[0]);
            $value    = array('field' => $field, 'title' => $val[1]);
            if(isset($val[2])){
                // 链接信息
                $value['href']  =   $val[2];
                // 搜索链接信息中的字段信息
                preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
            }
            if(strpos($val[1],'|')){
                // 显示格式定义
                list($value['title'],$value['format'])    =   explode('|',$val[1]);
            }
            foreach($field as $val){
                $array  =   explode('|',$val);
                $fields[] = $array[0];
            }
        }

        // 过滤重复字段信息 TODO: 传入到查询方法
        $fields = array_unique($fields);

        //获取对应分类下的模型
        if(!empty($cate_id)){   //没有权限则不查询数据
            //获取分类绑定的模型
            $models         =   get_category($cate_id, 'model');
            $allow_reply    =   get_category($cate_id, 'reply');//分类文档允许回复
            $pid            =   I('pid');
            if ( $pid==0 ) {
                //开发者可根据分类绑定的模型,按需定制分类文档列表
                $template = $this->indexOfArticle( $cate_id ); //转入默认文档列表方法
                $this->assign('model',  explode(',',$models));
            }else{
                //开发者可根据父文档的模型类型,按需定制子文档列表
                $doc_model = M('Document')->where(array('id'=>$pid))->find();

                switch($doc_model['model_id']){
                    default:
                        if($doc_model['type']==2 && $allow_reply){
                            $this->assign('model',  array(2));
                            $template = $this->indexOfReply( $cate_id ); //转入子文档列表方法
                        }else{
                            $this->assign('model',  explode(',',$models));
                            $template = $this->indexOfArticle( $cate_id ); //转入默认文档列表方法
                        }
                }
            }

            $this->assign('list_grids', $grids);
            $this->assign('model_list', $model);
            // 记录当前列表页的cookie
            Cookie('__forward__',$_SERVER['REQUEST_URI']);
            $this->display($template);
        }else{
            $this->error('非法的文档分类');
        }
    }

    /**
     * 默认文档回复列表方法
     * @param $cate_id 分类id
     * @author huajie<banhuajie@163.com>
     */
    protected function indexOfReply($cate_id) {
        /* 查询条件初始化 */
        $map = array();
        if(isset($_GET['content'])){
            $map['content']  = array('like', '%'.(string)I('content').'%');
        }
        if(isset($_GET['status'])){
            $map['status'] = I('status');
            $status = $map['status'];
        }else{
            $status = null;
            $map['status'] = array('in', '0,1,2');
        }
        if ( !isset($_GET['pid']) ) {
            $map['pid']    = 0;
        }
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        if ( isset($_GET['username']) ) {
            $map['uid'] = M('UcenterMember')->where(array('username'=>I('username')))->getField('id');
        }

        // 构建列表数据
        $Document = M('Document');
        $map['category_id'] =   $cate_id;
        $map['pid']         =   I('pid',0);
        if($map['pid']){ // 子文档列表忽略分类
            unset($map['category_id']);
        }

        $prefix   = C('DB_PREFIX');
        $l_table  = $prefix.('document');
        $r_table  = $prefix.('document_article');
        $list     = M() ->table( $l_table.' l' )
                       ->where( $map )
                       ->order( 'l.id DESC')
                       ->join ( $r_table.' r ON l.id=r.id' );
        $_REQUEST = array();
        $list = $this->lists($list,null,null,null,'l.id id,l.pid pid,l.category_id,l.title title,l.update_time update_time,l.uid uid,l.status status,r.content content' );
        int_to_string($list);

        if($map['pid']){
            // 获取上级文档
            $article    =   $Document->field('id,title,type')->find($map['pid']);
            $this->assign('article',$article);
        }
        //检查该分类是否允许发布内容
        $allow_publish  =   get_category($cate_id, 'allow_publish');

        $this->assign('status', $status);
        $this->assign('list',   $list);
        $this->assign('allow',  $allow_publish);
        $this->assign('pid',    $map['pid']);
        $this->meta_title = '子文档列表';
        return 'reply';//默认回复列表模板
    }
    /**
     * 默认文档列表方法
     * @param $cate_id 分类id
     * @author huajie<banhuajie@163.com>
     */
    protected function indexOfArticle($cate_id){
        /* 查询条件初始化 */
        $map = array();
        if(isset($_GET['title'])){
            $map['title']  = array('like', '%'.(string)I('title').'%');
        }
        if(isset($_GET['status'])){
            $map['status'] = I('status');
            $status = $map['status'];
        }else{
            $status = null;
            $map['status'] = array('in', '0,1,2');
        }
        if ( !isset($_GET['pid']) ) {
            $map['pid']    = 0;
        }
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        if ( isset($_GET['nickname']) ) {
            $map['uid'] = M('Member')->where(array('nickname'=>I('nickname')))->getField('uid');
        }

        // 构建列表数据
        $Document = M('Document');
        $map['category_id'] =   $cate_id;
        $map['pid']         =   I('pid',0);
        if($map['pid']){ // 子文档列表忽略分类
            unset($map['category_id']);
        }

        $list = $this->lists($Document,$map,'level DESC,id DESC');
        int_to_string($list);
        if($map['pid']){
            // 获取上级文档
            $article    =   $Document->field('id,title,type')->find($map['pid']);
            $this->assign('article',$article);
        }
        //检查该分类是否允许发布内容
        $allow_publish  =   get_category($cate_id, 'allow_publish');

        $this->assign('status', $status);
        $this->assign('list',   $list);
        $this->assign('allow',  $allow_publish);
        $this->assign('pid',    $map['pid']);

        $this->meta_title = '文档列表';
        return 'index';
    }

    /**
     * 设置一条或者多条数据的状态
     * @author huajie<banhuajie@163.com>
     */
    public function setStatus($model='Document'){
        return parent::setStatus('Document');
    }

    /**
     * 文档新增页面初始化
     * @author huajie<banhuajie@163.com>
     */
    public function add(){
        //获取左边菜单
        $this->getMenu();

        $cate_id    =   I('get.cate_id',0);
        $model_id   =   I('get.model_id',0);

        empty($cate_id) && $this->error('参数不能为空！');
        empty($model_id) && $this->error('该分类未绑定模型！');

        //检查该分类是否允许发布
        $allow_publish = D('Document')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        /* 获取要编辑的扩展模型模板 */
        $model      =   get_document_model($model_id);

        //处理结果
        $info['pid']            =   $_GET['pid']?$_GET['pid']:0;
        $info['model_id']       =   $model_id;
        $info['category_id']    =   $cate_id;
        if($info['pid']){
            // 获取上级文档
            $article            =   M('Document')->field('id,title,type')->find($info['pid']);
            $this->assign('article',$article);
        }

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('info',       $info);
        $this->assign('fields',     $fields);
        $this->assign('type_list',  get_type_bycate($cate_id));
        $this->assign('model',      $model);
        $this->meta_title = '新增'.$model['title'];
        $this->display();
    }

    /**
     * 文档编辑页面初始化
     * @author huajie<banhuajie@163.com>
     */
    public function edit(){
        //获取左边菜单
        $this->getMenu();

        $id     =   I('get.id','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }

        /*获取一条记录的详细数据*/
        $Document = D('Document');
        $data = $Document->detail($id);
        if(!$data){
            $this->error($Document->getError());
        }

        if($data['pid']){
            // 获取上级文档
            $article        =   M('Document')->field('id,title,type')->find($data['pid']);
            $this->assign('article',$article);
        }
        $this->assign('data', $data);
        $this->assign('model_id', $data['model_id']);

        /* 获取要编辑的扩展模型模板 */
        $model      =   get_document_model($data['model_id']);
        $this->assign('model',      $model);

        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('fields',     $fields);


        //获取当前分类的文档类型
        $this->assign('type_list', get_type_bycate($data['category_id']));

        $this->meta_title   =   '编辑文档';
        $this->display();
    }

    /**
     * 更新一条数据
     * @author huajie<banhuajie@163.com>
     */
    public function update(){
        $res = D('Document')->update();
        if(!$res){
            $this->error(D('Document')->getError());
        }else{
            $this->success($res['id']?'更新成功':'新增成功', Cookie('__forward__'));
        }
    }

    /**
     * 批量操作
     * @author huajie<banhuajie@163.com>
     */
    public function batchOperate(){
        //获取左边菜单
        $this->getMenu();

        $pid = I('pid', 0);
        $cate_id = I('cate_id');

        empty($cate_id) && $this->error('参数不能为空！');

        //检查该分类是否允许发布
        $allow_publish = D('Document')->checkCategory($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');

        //批量导入目录
        if(IS_POST){
            $model_id = I('model_id');
            $type = 1;  //TODO:目前只支持目录，要动态获取
            $content = I('content');
            $_POST['content'] = ''; //重置内容
            preg_match_all('/[^\r]+/', $content, $matchs);  //获取每一个目录的数据
            $list = $matchs[0];
            foreach ($list as $value){
                if(!empty($value) && (strpos($value, '|') !== false)){
                    //过滤换行回车并分割
                    $data = explode('|', str_replace(array("\r", "\r\n", "\n"), '', $value));
                    //构造新增的数据
                    $data = array('name'=>$data[0], 'title'=>$data[1], 'category_id'=>$cate_id, 'model_id'=>$model_id);
                    $data['description'] = '';
                    $data['pid'] = $pid;
                    $data['type'] = $type;
                    //构造post数据用于自动验证
                    $_POST = $data;

                    $res = D('Document')->update($data);
                }
            }
            if($res){
                $this->success('批量导入成功！', U('index?pid='.$pid.'&cate_id='.$cate_id));
            }else{
                if(isset($res)){
                    $this->error(D('Document')->getError());
                }else{
                    $this->error('批量导入失败，请检查内容格式！');
                }
            }
        }

        $this->assign('pid',        $pid);
        $this->assign('cate_id',    $cate_id);
        $this->assign('type_list',  get_type_bycate($cate_id));

        $this->meta_title       =   '批量导入';
        $this->display('batchoperate');
    }


    /**
     * 待审核列表
     */
    public function examine(){
        //获取左边菜单
        $this->getMenu();

        $map['status']  =   2;
        if ( !IS_ROOT ) {
            $cate_auth  =   AuthGroupModel::getAuthCategories(UID);
            if($cate_auth){
                $map['category_id']    =   array('IN',$cate_auth);
            }else{
                $map['category_id']    =   -1;
            }
        }
        $list = $this->lists(M('Document'),$map,'update_time desc');
        //处理列表数据
        if(is_array($list)){
            foreach ($list as $k=>&$v){
                $v['username']      =   get_nickname($v['uid']);
            }
        }

        $this->assign('list', $list);
        $this->meta_title       =   '待审核';
        $this->display();
    }

    /**
     * 回收站列表
     * @author huajie<banhuajie@163.com>
     */
    public function recycle(){
        //获取左边菜单
        $this->getMenu();

        $map['status']  =   -1;
        if ( !IS_ROOT ) {
            $cate_auth  =   AuthGroupModel::getAuthCategories(UID);
            if($cate_auth){
                $map['category_id']    =   array('IN',$cate_auth);
            }else{
                $map['category_id']    =   -1;
            }
        }
        $list = $this->lists(M('Document'),$map,'update_time desc');

        //处理列表数据
        if(is_array($list)){
            foreach ($list as $k=>&$v){
                $v['username']      =   get_nickname($v['uid']);
            }
        }

        $this->assign('list', $list);
        $this->meta_title       =   '回收站';
        $this->display();
    }

    /**
     * 写文章时自动保存至草稿箱
     * @author huajie<banhuajie@163.com>
     */
    public function autoSave(){
        $res = D('Document')->autoSave();
        if($res !== false){
            $return['data']     =   $res;
            $return['info']     =   '保存草稿成功';
            $return['status']   =   1;
            $this->ajaxReturn($return);
        }else{
            $this->error('保存草稿失败：'.D('Document')->getError());
        }
    }

    /**
     * 草稿箱
     * @author huajie<banhuajie@163.com>
     */
    public function draftBox(){
        //获取左边菜单
        $this->getMenu();

        $Document   =   D('Document');
        $map        =   array('status'=>3,'uid'=>UID);
        $list       =   $this->lists($Document,$map);
        //获取状态文字
        //int_to_string($list);

        $this->assign('list', $list);
        $this->meta_title = '草稿箱';
        $this->display();
    }

    /**
     * 我的文档
     * @author huajie<banhuajie@163.com>
     */
    public function mydocument($status = null, $title = null){
        //获取左边菜单
        $this->getMenu();

        $Document   =   D('Document');
        /* 查询条件初始化 */
        $map['uid'] = UID;
        if(isset($title)){
            $map['title']   =   array('like', '%'.$title.'%');
        }
        if(isset($status)){
            $map['status']  =   $status;
        }else{
            $map['status']  =   array('in', '0,1,2');
        }
        if ( isset($_GET['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($_GET['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        //只查询pid为0的文章
        $map['pid'] = 0;
        $list = $this->lists($Document,$map,'update_time desc');
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->meta_title = '我的文档';
        $this->display();
    }

    /**
     * 还原被删除的数据
     * @author huajie<banhuajie@163.com>
     */
    public function permit(){
        /*参数过滤*/
        $ids = I('param.ids');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }

        /*拼接参数并修改状态*/
        $Model  =   'Document';
        $map    =   array();
        if(is_array($ids)){
            $map['id'] = array('in', $ids);
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        $this->restore($Model,$map);
    }

    /**
     * 清空回收站
     * @author huajie<banhuajie@163.com>
     */
    public function clear(){
        $res = D('Document')->remove();
        if($res !== false){
            $this->success('清空回收站成功！');
        }else{
            $this->error('清空回收站失败！');
        }
    }

    /**
     * 移动文档
     * @author huajie<banhuajie@163.com>
     */
    public function move() {
        if(empty($_POST['ids'])) {
            $this->error('请选择要移动的文档！');
        }
        session('moveArticle', $_POST['ids']);
        session('copyArticle', null);
        $this->success('请选择要移动到的分类！');
    }

    /**
     * 拷贝文档
     * @author huajie<banhuajie@163.com>
     */
    public function copy() {
        if(empty($_POST['ids'])) {
            $this->error('请选择要复制的文档！');
        }
        session('copyArticle', $_POST['ids']);
        session('moveArticle', null);
        $this->success('请选择要复制到的分类！');
    }

    /**
     * 粘贴文档
     * @author huajie<banhuajie@163.com>
     */
    public function paste() {
        $moveList = session('moveArticle');
        $copyList = session('copyArticle');
        if(empty($moveList) && empty($copyList)) {
            $this->error('没有选择文档！');
        }
        if(!isset($_POST['cate_id'])) {
            $this->error('请选择要粘贴到的分类！');
        }
        $cate_id = I('post.cate_id');   //当前分类
        $pid = I('post.pid', 0);        //当前父类数据id

        //检查所选择的数据是否符合粘贴要求
        $check = $this->checkPaste(empty($moveList) ? $copyList : $moveList, $cate_id, $pid);
        if(!$check['status']){
            $this->error($check['info']);
        }

        if(!empty($moveList)) {// 移动    TODO:检查name重复
            foreach ($moveList as $key=>$value){
                $Model              =   M('Document');
                $map['id']          =   $value;
                $data['category_id']=   $cate_id;
                $data['pid']        =   $pid;
                //获取root
                if($pid == 0){
                    $data['root'] = 0;
                }else{
                    $p_root = $Model->getFieldById($pid, 'root');
                    $data['root'] = $p_root == 0 ? $pid : $p_root;
                }
                $res = $Model->where($map)->save($data);
            }
            session('moveArticle', null);
            if(false !== $res){
                $this->success('文档移动成功！');
            }else{
                $this->error('文档移动失败！');
            }
        }elseif(!empty($copyList)){ // 复制
            foreach ($copyList as $key=>$value){
                $Model  =   M('Document');
                $data   =   $Model->find($value);
                unset($data['id']);
                unset($data['name']);
                $data['category_id']    =   $cate_id;
                $data['pid']            =   $pid;
                $data['create_time']    =   NOW_TIME;
                $data['update_time']    =   NOW_TIME;
                //获取root
                if($pid == 0){
                    $data['root'] = 0;
                }else{
                    $p_root = $Model->getFieldById($pid, 'root');
                    $data['root'] = $p_root == 0 ? $pid : $p_root;
                }

                $result   =  $Model->add($data);
                if($result){
                    $logic      =   D(get_document_model($data['model_id'],'name'),'Logic');
                    $data       =   $logic->detail($value); //获取指定ID的扩展数据
                    $data['id'] =   $result;
                    $res        =   $logic->add($data);
                }
            }
            session('copyArticle', null);
            if($res){
                $this->success('文档复制成功！');
            }else{
                $this->error('文档复制失败！');
            }
        }
    }

    /**
     * 检查数据是否符合粘贴的要求
     * @author huajie<banhuajie@163.com>
     */
    protected function checkPaste($list, $cate_id, $pid){
        $return = array('status'=>1);
        $Document = D('Document');

        // 检查支持的文档模型
        $modelList =   M('Category')->getFieldById($cate_id,'model');   // 当前分类支持的文档模型
        foreach ($list as $key=>$value){
            //不能将自己粘贴为自己的子内容
            if($value == $pid){
                $return['status'] = 0;
                $return['info'] = '不能将编号为 '.$value.' 的数据粘贴为他的子内容！';
                return $return;
            }
            // 移动文档的所属文档模型
            $modelType  =   $Document->getFieldById($value,'model_id');
            if(!in_array($modelType,explode(',',$modelList))) {
                $return['status'] = 0;
                $return['info'] = '当前分类的文档模型不支持编号为 '.$value.' 的数据！';
                return $return;
            }
        }

        // 检查支持的文档类型和层级规则
        $typeList =   M('Category')->getFieldById($cate_id,'type'); // 当前分类支持的文档模型
        foreach ($list as $key=>$value){
            // 移动文档的所属文档模型
            $modelType  =   $Document->getFieldById($value,'type');
            if(!in_array($modelType,explode(',',$typeList))) {
                $return['status'] = 0;
                $return['info'] = '当前分类的文档类型不支持编号为 '.$value.' 的数据！';
                return $return;
            }
            $res = $Document->checkDocumentType($modelType, $pid);
            if(!$res['status']){
                $return['status'] = 0;
                $return['info'] = $res['info'].'。错误数据编号：'.$value;
                return $return;
            }
        }

        return $return;
    }

    /**
     * 文档排序
     * @author huajie<banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            //获取左边菜单
            $this->getMenu();

            $ids        =   I('get.ids');
            $cate_id    =   I('get.cate_id');
            $pid        =   I('get.pid');

            //获取排序的数据
            $map['status'] = array('gt',-1);
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }else{
                if($cate_id !== ''){
                    $map['category_id'] = $cate_id;
                }
                if($pid !== ''){
                    $map['pid'] = $pid;
                }
            }
            $list = M('Document')->where($map)->field('id,title')->order('level DESC,id DESC')->select();

            $this->assign('list', $list);
            $this->meta_title = '文档排序';
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = array_reverse(explode(',', $ids));
            foreach ($ids as $key=>$value){
                $res = M('Document')->where(array('id'=>$value))->setField('level', $key+1);
            }
            if($res !== false){
                $this->success('排序成功！');
            }else{
                $this->error('排序失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }
    //2014-10-22添加
    //项目管理
    // ======================================项目分配==================================================
    /** 
     * 项目查看页 
     */
    public function lookover(){
        //获取左边菜单
        $this->getMenu();
        $id = I('get.id','');
        /*获取一条记录的详细数据*/
        $Project = M('Project');
        $map[id] = $id;
        $result = $Project->where($map)->find();
        $this->assign(prid,$result[id]);
        $this->assign(name,$result[pjname]);
        $this->assign(linkman,$result[linkman]);
        $this->assign(prphone,$result[prphone]);
        $this->assign('videoweb',$result[videoweb]);
        $this->assign(introduce,$result[pjintroduce]);
        if($result[stageid]==1){
            $this->assign(stage,'起步阶段');
        }else if($result[stageid]==2){
            $this->assign(stage,'盈利阶段');
        }else if($result[stageid]==3){
            $this->assign(stage,'亏损阶段');
        }
        $this->assign(area,$result[province].'&nbsp;-&nbsp;'.$result[city].'&nbsp;-&nbsp;'.$result[town]);
        $this->assign(industry,$result[fathertrade].'&nbsp;-&nbsp;'.$result[fulltrade]);
        $this->assign(logo,$result[logo]);
        $this->assign(about,$result[prabout]);
        $this->assign(whysupport,$result[prwhysupport]);
        $this->assign(promise,$result[prpromise]);
        $this->assign(danger,$result[prdanger]);
        $this->assign(banner,$result[top_show_img]);
        $area = M('China');
        $province = $area->where('pid=0')->select();
        $this->assign('province',$province);
        $industry = M('Industrialclassification');
        $map['id']  = array('between','401,420');
        $grand = $industry->where($map)->select();
        $this->assign('grand',$grand);
        $Prmember = M('Prmember');
        $mem[prid] = $id;
        $member = $Prmember->where($mem)->order('id')->select();
        $this->assign('member',$member);
        $this->display();
    }
    /** 
     * 查看资料审核页 
     */
    public function lookover02(){
        $prid = $_GET[prid];
        $Companydata = M('Companydata');
        $map[prid] = $prid;
        $shenfu01 = 'Public/Home/images/entrepre/shenfu01.gif';
        $result = $Companydata->where($map)->find();
        $this->assign('prid',$prid);
        $this->assign('companyid',$result[id]);
        $this->assign('fornt',$result[fornt]);
        $this->assign('rear',$result[rear]);
        $this->assign('legalperson',$result[legalperson]);
        $this->assign('businesslicence',$result[businesslicence]);
        $this->assign('taxcertificate',$result[taxcertificate]);
        $this->assign('companyimg',$result[companyimg]);
        $this->display();
    }
    /** 
     * 查看融资需求页 
     */
    public function lookover03(){
        $prid = $_GET[prid];
        $Financingneeds = M('Financingneeds');
        $map[prid] = $prid;
        $result = $Financingneeds->where($map)->find();
        $this->assign('budget',$result[budget]);
        $this->assign('singleinvest',$result[singleinvest]);
        $this->assign('extras',$result[extras]);
        $this->assign('purpose',$result[purpose]);
        $this->assign('oldname',$result[oldname]);
        $this->assign('businessplan',$result[businessplan]);
        $this->assign('addinfo',$result[addinfo]);
        if($result[privacyset]==1){
            $this->assign(privacy,'所有投资人可见');
        }else{
            $this->assign(privacy,'设为隐私');
        }
        $this->assign('result',$result);
        $this->assign(investid,$result[id]);
        $this->assign('prid',$prid);
        $this->display();
    }
    /** 
     * 查看项目图片页 
     */
    public function lookover04(){
        $prid = $_GET[prid];
        $Primages = M('Primages');
        $map[prid] = $prid;
        $result = $Primages->where($map)->select();
        $this->assign('prid',$prid);
        $this->assign('imgs',$result);
        $this->display();
    }
    public function lookover05(){
    	$prid=$_GET[prid];
    	$this->assign('prid',$prid);
    	$map[prid] = $_GET[prid];
		$prdescription = M('Prdescription');
		$result = $prdescription->where($map)->find();
		$this->assign('prdes',$result[prdescription]);
		$this->display();
    }
    /** 
     * 项目分配 
     */
    public function distribute(){
        $this->getMenu();
        $prreviewid = $_GET[prreviewid];
        $prid = $_GET[prid];
        $prreview = $_GET[prreview];
        $Project = M('Project');
        $map[id] = $prid;
        $data[prreviewid] = $prreviewid;
        $data[prreview] = $prreview;
        $result = $Project->where($map)->save($data);
        if($result){
            $success = 1;
            $successArr = json_encode($success);
            echo $successArr;
        }else{
            $default = 0;
            $defaultArr = json_encode($default);
            echo $defaultArr;
        }
    }
    // ===============================================================================================
    // ============================================项目审核===========================================
    //项目编辑
    // **********************基本资料**********************
    /** 
     * 基本资料页 
     */
    public function predit(){
        //获取左边菜单
        $this->getMenu();
        $id = I('get.id','');
        /*获取一条记录的详细数据*/
        $Project = M('Project');
        $map[id] = $id;
        $result = $Project->where($map)->find();
        $this->assign(prid,$result[id]);
        $this->assign(name,$result[pjname]);
        $this->assign(linkman,$result[linkman]);
        $this->assign(phone,$result[prphone]);
        $this->assign(introduce,$result[pjintroduce]);
        $this->assign('videoweb',$result[videoweb]);
        if($result[stageid]==1){
            $this->assign(stage,'起步阶段');
        }else if($result[stageid]==2){
            $this->assign(stage,'盈利阶段');
        }else if($result[stageid]==3){
            $this->assign(stage,'亏损阶段');
        }
        $this->assign(area,$result[province].'&nbsp;-&nbsp'.$result[city].'&nbsp;-&nbsp'.$result[town]);
        $this->assign(industry,$result[fathertrade].'&nbsp;-&nbsp'.$result[fulltrade]);
        $this->assign(logo,$result[logo]);
        $this->assign(about,$result[prabout]);
        $this->assign(whysupport,$result[prwhysupport]);
        $this->assign(promise,$result[prpromise]);
        $this->assign(danger,$result[prdanger]);
        $this->assign(banner,$result[top_show_img]);
        $area = M('China');                 //  获取所有省份
        $province = $area->where('pid=0')->select();
        $this->assign('province',$province);
        $trade = M('Trade');                //获取所有一级分类
        $tradeone = $trade->where('pid=0')->select();
        $this->assign('alltradeone',$tradeone);
        $Prmember = M('Prmember');
        $mem[prid] = $id;
        $member = $Prmember->where($mem)->order('id')->select();
        $this->assign('member',$member);
        $this->display();
    }
    /** 
     * 获取所有二级城市 
     */
    public function province(){
        $id = $_GET[areaid]; 
        $area = M('China'); 
        $map[pid] = $id;
        $result = $area->where($map)->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }
    /** 
     * 获取所有三级城市 
     */
    public function city(){
        $id = $_GET[areaid]; 
        $area = M('China'); 
        $map[pid] = $id;
        $result = $area->where($map)->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }
    /** 
     * 获取二级行业 
     */
    public function trade(){
        $id = $_GET[tradeid];
        $trade = M('Trade'); 
        $map[pid] = $id;
        $result = $trade->where($map)->select();
        $resultArr = json_encode($result);
        echo($resultArr);
    }
    /** 
     * 项目基本资料获取 
     */
    public function prbaseedit(){
        $Project = M('Project');
        $map['id'] = $_GET['prid'];
        $prinfo = $Project->where($map)->select();
        $prinfoArr = json_encode($prinfo[0]);
        echo $prinfoArr;
    }
    /** 
     * 项目封面图更新 
     */
    public function updateSurface(){
        //图片上传
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Album/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        // 上传文件
        $info = $upload->upload();
        if($info){
            echo $info['prsurface03']['savename'];
            exit();
        }else{
            echo 0;
            exit();
        }
    }
    /** 
     * 更新项目基本资料 
     */
    public function prbaseupdate(){
        $Province = M('China');                     //获取省
        $map['id'] = $_POST['province03'];
        $pres = $Province->where($map)->select();                    
        $City = M('China');                         //获取市
        $map['id'] = $_POST['city03'];
        $cres = $City->where($map)->select();
        $Town = M('China');                         //获取县
        $map['id'] = $_POST['town03'];
        $tres = $Town->where($map)->select();
        //获取一级行业
        $father = M('Trade');
        $map['id'] = $_POST['father03'];
        $fares = $father->where($map)->select();
        // 获取二级行业
        $full = M('Trade');
        $map['id'] = $_POST['full03'];
        $fures = $full->where($map)->select(); 
        $Project = M('Project');                    //项目基本资料写入
        //判断是否有图片上传
        if($_POST['surface03']==''){
            $map[id] = $_POST[prid];
            $data[pjname] = $_POST[prname03];
            $data[linkman] = $_POST[linkman03];
            $data[prphone] = $_POST[prphone03];
            $data[pjintroduce] = $_POST[printroduce03];
            $data[videoweb] = $_POST[videoweb03];
            $data[stageid] = $_POST[prstage03];
            $data[provinceid] = $_POST[province03];
            $data[province] = $pres[0][name];
            $data[cityid] = $_POST[city03];
            $data[city] = $cres[0][name];
            $data[townid] = $_POST[town03];
            $data[town] = $tres[0][name];
            $data[fathertradeid] = $_POST[father03];
            $data[fathertrade] = $fares[0][trade];
            $data[fulltradeid] = $_POST[full03];   
            $data[fulltrade] = $fures[0][trade];
            $data[update_time] = date("Y-m-d");
            $prresult = $Project->where($map)->data($data)->save();
            if($prresult){
                $Project031 = M('Project');
                $result031 = $Project031->where($map)->select();
                $result031Arr = json_encode($result031[0]);
                echo $result031Arr;
            }
        }else{
            $map[id] = $_POST[prid];
            $data[pjname] = $_POST[prname03];
            $data[linkman] = $_POST[linkman03];
            $data[prphone] = $_POST[prphone03];
            $data[pjintroduce] = $_POST[printroduce03];
            $data[videoweb] = $_POST[videoweb03];
            $data[stageid] = $_POST[prstage03];
            $data[provinceid] = $_POST[province03];
            $data[province] = $pres[0][name];
            $data[cityid] = $_POST[city03];
            $data[city] = $cres[0][name];
            $data[townid] = $_POST[town03];
            $data[town] = $tres[0][name];
            $data[fathertradeid] = $_POST[father03];
            $data[fathertrade] = $fares[0][trade];
            $data[fulltradeid] = $_POST[full03];   
            $data[fulltrade] = $fures[0][trade];
            $data[update_time] = date("Y-m-d");

            $data[logo] = $_POST['surface03'];
            $prresult = $Project->where($map)->data($data)->save();
            if($prresult){
                $Project031 = M('Project');
                $result031 = $Project031->where($map)->select();
                $result031Arr = json_encode($result031[0]);
                echo $result031Arr;
            }
        }
    }
    /** 
     * 关于我们写入 
     */
    public function praboutinsert(){
        $Project = M('Project');
        $data[prabout] = $_POST['prabout11'];
        $map['id'] = $_POST['prid'];
        $result = $Project->where($map)->save($data);
        $prArr = json_encode($data);
        echo $prArr;   
    }
    /** 
     * 关于我们获取 
     */
    public function praboutedit(){
        $Project = M('Project');
        $map[id] = $_GET['prid'];
        $result = $Project->where($map)->select();
        $resultArr = json_encode($result[0]);
        echo $resultArr;
    }
    /** 
     * 更新关于我们 
     */
    public function praboutupdate(){
        $Project13 = M('Project');
        $data[prabout] = $_POST[prabout13];
        $map13[id] = $_POST[prid];
        $result13 = $Project13->where($map13)->data($data)->save();
        if($result13){
            $Project131 = M('Project');
            $result131 = $Project131->where($map13)->select();
            $result131Arr = json_encode($result131[0]);
            echo $result131Arr;
        }
    }
    /** 
     * 为什么支持我们写入 
     */
    public function prwhysupportinsert(){
        $Project = M('Project');
        $data[prwhysupport] = $_POST['prwhysupport41'];
        $map[id] = $_POST[prid];
        $result = $Project->where($map)->data($data)->save();
        $prArr = json_encode($data);
        echo $prArr; 
    }
    /** 
     * 为什么支持我们获取 
     */
    public function prwhysupportedit(){
        $Project = M('Project');
        $map[id] = $_GET['prid'];
        $result = $Project->where($map)->select();
        $resultArr = json_encode($result[0]);
        echo $resultArr;
    }
    /**
     * 更新为什们支持我们 
     */
    public function prwhysupportupdate(){
        $Project43 = M('Project');
        $data[prwhysupport] = $_POST[prwhysupport43];
        $map43[id] = $_POST[prid];
        $result43 = $Project43->where($map43)->data($data)->save();
        if($result43){
            $Project431 = M('Project');
            $result431 = $Project431->where($map43)->select();
            $result431Arr = json_encode($result431[0]);
            echo $result431Arr;
        }
    }
    /** 
     * 承诺写入 
     */
    public function prpromiseinsert(){
        $Project = M('Project');
        $data[prpromise] = $_POST['prpromise51'];
        $map[id] = $_POST[prid];
        $result = $Project->where($map)->data($data)->save();
        $prArr = json_encode($data);
        echo $prArr;   
    }
    /** 
     * 承诺获取 
     */
    public function prpromiseedit(){
        $Project = M('Project');
        $map[id] = $_GET['prid'];
        $result = $Project->where($map)->select();
        $resultArr = json_encode($result[0]);
        echo $resultArr;
    }
    /** 
     * 更新承诺 
     */
    public function prpromiseupdate(){
        $Project53 = M('Project');
        $data[prpromise] = $_POST[prpromise53];
        $map53[id] = $_POST[prid];
        $result53 = $Project53->where($map53)->data($data)->save();
        if($result53){
            $Project531 = M('Project');
            $result531 = $Project531->where($map53)->select();
            $result531Arr = json_encode($result531[0]);
            echo $result531Arr;
        }
    }
    /** 
     * 风险写入 
     */
    public function prdangerinsert(){
        $Project = M('Project');
        $data[prdanger] = $_POST['prdanger61'];
        $map[id] = $_POST[prid];
        $result = $Project->where($map)->data($data)->save();
        $prArr = json_encode($data);
        echo $prArr;   
    }
    /** 
     * 风险获取 
     */
    public function prdangeredit(){
        $Project = M('Project');
        $map[id] = $_GET['prid'];
        $result = $Project->where($map)->select();
        $resultArr = json_encode($result[0]);
        echo $resultArr;
    }
    /** 
     * 更新风险 
     */
    public function prdangerupdate(){
        $Project63 = M('Project');
        $data[prdanger] = $_POST[prdanger63];
        $map63[id] = $_POST[prid];
        $result63 = $Project63->where($map63)->data($data)->save();
        if($result63){
            $Project631 = M('Project');
            $result631 = $Project631->where($map63)->select();
            $result631Arr = json_encode($result631[0]);
            echo $result631Arr;
        }
    }
    /** 
     * banner图上传 
     */
    public function uploadBanner(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Banner/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        // 上传文件
        return $info = $upload->upload();
    }
    /**
     * 保存banner图片 
     */
    public function bannerinsert(){
        $info = $this->uploadBanner();
        if($info){
            $map[id] = $_POST[prid];;
            $data[top_show_img] = $info[banner71][savename];
            $Project = M('Project');
            $result = $Project->where($map)->save($data);
            $resultArr = json_encode($info[banner71][savename]);
            echo $resultArr;
        }else{
            echo 0;
        } 
    }
    /**
     * 更新banner图片 
     */
    public function bannerupdate(){
        $info = $this->uploadBanner();
        if($info){
            $map[id] = $_POST[prid];
            $data[top_show_img] = $info[banner73][savename];
            $Project = M('Project');
            $result = $Project->where($map)->save($data);
            $resultArr = json_encode($info[banner73][savename]);
            echo $resultArr;
            exit();

        }else{
            echo 0;
            exit();
        }
    }
    /**
     * 成员头像上传
     */
    public function uploadPhoto(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload ->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload ->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload ->autoSub = false;
        $upload ->savePath = './Portrait/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload ->saveName = $fileName;
        // 上传文件
        return $info = $upload->upload();
    }
    /**
     * 头像上传 
     */
    public function upPhoto(){
        $info = $this->uploadPhoto();
        if($info){
            echo $info['photo21'][savename];
            exit();
        }else{
            echo 0;
            exit();
        }
    }
    /**
     * 成员信息写入 
     */
    public function prmemberinsert21(){
        $Prmember21 = M('Prmember');
        $data[prid] = $_POST['prid'];
        $data[membername] = $_POST['name21'];
        $data[memberposition] = $_POST['position21'];
        $data[memberroleid] = $_POST['radio21'];
        $data[memberintroduce] = $_POST['introduce21'];
        $data[photo] = $_POST['headphoto21'];
        $result = $Prmember21->add($data);
        if($result){
            $Prmember211 = M('Prmember');
            $map211[prid] = $_POST['prid'];
            $map211[membername] = $_POST['name21'];
            $map211[memberposition] = $_POST['position21'];
            $result211 = $Prmember211->where($map211)->select();
            $result211Arr = json_encode($result211[0]);
            echo $result211Arr;
            exit();
        }      
    }
    /**
     * 成员信息获取 
     */
    public function prmemberedit(){
        $Prmember = M('Prmember');
        $map[id] = $_GET['memberid'];
        $result = $Prmember->where($map)->select();
        $resultArr = json_encode($result[0]);
        echo $resultArr;
    }
    /** 
     * 删除成员信息 
     */
    public function prmemberdelete(){
        $Prmember = M('Prmember');
        $map[id] = $_GET['memberid'];
        $result = $Prmember->where($map)->delete();
        $resultArr = json_encode($result[0]);
        echo $resultArr;
    }
    /**
     * 头像更新 
     */
    public function updatePhoto(){ 
        $info = $this->uploadPhoto();
        if ($info) {
            echo $info[memberphoto23][savename];
            exit();
        }else{
            echo 0;
            exit();
        }
    }
    /**
     * 更新成员信息 
     */
    public function prmemberupdated(){
        $Prmember = M('Prmember');
        $map[id] = $_POST[memberid23];
        $data[membername] = $_POST[name23];
        $data[memberposition] = $_POST[position23];
        $data[memberroleid] = $_POST[radio23];
        $data[memberintroduce] = $_POST[introduce23];
        $headphoto23 = $_POST[headphoto23];
        //判断是否有图片上传
        if(empty($headphoto23)){
            $result = $Prmember->where($map)->data($data)->save();
            if($result){
                $Prmember231 = M('Prmember');
                $result231 = $Prmember231->where($map)->select();
                $result231Arr = json_encode($result231[0]);
                echo $result231Arr;
            }
        }else{
            $data[photo] = $_POST['headphoto23'];
            $result = $Prmember->where($map)->data($data)->save();
            if($result){
                $Prmember231 = M('Prmember');
                $result231 = $Prmember231->where($map)->select();
                $result231Arr = json_encode($result231[0]);
                echo $result231Arr;
            }
        }     
    }
    // ***************************资料审核************************
    /**
     *  获取公司资料 
     */
    public function predit02(){
        $prid = $_GET[prid];
        $this->assign('prid',$prid);
        $Companydata = M('Companydata');
        $map[prid] = $prid;
        $result = $Companydata->where($map)->find();
        $this->assign('companyid',$result[id]);
        $this->assign('fornt',$result[fornt]);
        $this->assign('rear',$result[rear]);
        $this->assign('legalperson',$result[legalperson]);
        $this->assign('businesslicence',$result[businesslicence]);
        $this->assign('taxcertificate',$result[taxcertificate]);
        $this->assign('companyimg',$result[companyimg]);
        $this->display();
    }
    /**
     *  资料审核图片上传 
     */
    public function uploadReview(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './Company/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        // 上传文件
        return $info = $upload->upload();
    }
    /**
     *  保存身份证正面图片 
     */
    public function insertfornt(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M('Companydata');
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[fornt] = $info[fornt][savename];
                $res = $Companydata->where($map)->save();
            }else{
                $data[prid]= $_POST[prid];
                $data[fornt] = $info[fornt][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[fornt][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  更新身份证正面图片 
     */
    public function updatefornt(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[fornt] = $info[fornt02][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[fornt] = $info[fornt02][savename];
                $res = $Companydata->add($data);
            }
            $resArr = json_encode($info[fornt02][savename]);
            echo $resArr;
        }else {
            echo 0;
            exit();
        }
    }
    /** 
     * 保存身份证反面图片 
     */
    public function insertrear(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[rear] = $info[rear11][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[rear] = $info[rear11][savename];
                $res = $Companydata->add($data);
            }
            $dataArr = json_encode($info[rear11][savename]);
            echo $dataArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  更新身份证反面图片 
     */
    public function updaterear(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[rear] = $info[rear12][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[rear] = $info[rear12][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[rear12][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  保存法人证信报告图片 
     */
    public function insertlegalperson(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[legalperson] = $info[legalperson21][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[legalperson] = $info[legalperson21][savename];
                $res = $Companydata->add($data);
            }
            $dataArr = json_encode($info[legalperson21][savename]);
            echo $dataArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  更新法人证信报告图片 
     */
    public function updatelegalperson(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[legalperson] = $info[legalperson22][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[legalperson] = $info[legalperson22][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[legalperson22][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  保存营业执照副本图片 
     */
    public function insertbusinesslicence(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[businesslicence] = $info[businesslicence31][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[businesslicence] = $info[businesslicence31][savename];
                $res = $Companydata->add($data);
            }
            $dataArr = json_encode($info[businesslicence31][savename]);
            echo $dataArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  更新营业执照图片 
     */
    public function updatebusinesslicence(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[businesslicence] = $info[businesslicence32][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[businesslicence] = $info[businesslicence32][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[businesslicence32][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  保存税务登记证副本图片 
     */
    public function inserttaxcertificate(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[taxcertificate] = $info[taxcertificate41][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[taxcertificate] = $info[taxcertificate41][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[taxcertificate41][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  更新税务登记证图片 
     */
    public function updatetaxcertificate(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[taxcertificate] = $info[taxcertificate42][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[taxcertificate] = $info[taxcertificate42][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[taxcertificate42][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     * 保存公司图片 
     */
    public function insertcompanyimg(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[companyimg] = $info[companyimg51][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[companyimg] = $info[companyimg51][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[companyimg51][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  更新公司图片 
     */
    public function updatecompanyimg(){
        $info = $this->uploadReview();
        if($info){
            $map[prid] = $_POST[prid];
            $Companydata = M(Companydata);
            $result = $Companydata->where($map)->find();      //判断是否有prid的记录
            if($result){
                $data[companyimg] = $info[companyimg52][savename];
                $res = $Companydata->where($map)->save($data);
            }else{
                $data[prid]= $_POST[prid];
                $data[companyimg] = $info[companyimg52][savename];
                $res = $Companydata->add($data);
            }
            $resultArr = json_encode($info[companyimg52][savename]);
            echo $resultArr;
        }else{
            echo 0;
            exit();
        }
    }
    /**
     *  进入融资需求页 
     */
    public function predit03(){
        $prid = $_GET[prid];
        $companyid = $_GET[companyid];
        $this->assign('prid',$prid);
        $this->assign('companyid',$companyid);
        $Financingneeds = M('Financingneeds');
        $map[prid] = $prid;
        $result = $Financingneeds->where($map)->find();
        $this->assign('result',$result);
        $this->assign('investid',$result[id]);
        $this->assign('budget',$result[budget]);
        $this->assign('singleinvest',$result[singleinvest]);
//         $this->assign('extras',$result[extras]);
        $this->assign('purpose',$result[purpose]);
//         $this->assign('businessplan',$result[businessplan]);
//         $this->assign('oldname',$result[oldname]);
        $this->assign('privacy',$result[privacyset]);
        $this->assign('addinfo',$result[addinfo]);
        $this->display();
    }
    /**
     *  上传商业计划书 
     */
    /* public function upplan(){
        if (!empty($_FILES)) {
            //商业计划书上传设置
            $config = array(   
                'maxSize'    =>    25*1024*1024,    // 设置附件上传大小25M
                'savePath'   =>    './Businessplan/',   // 设置附件上传目录
                'saveName'   =>    date('YmdHis',time()).'_'.rand(100,999), 
                'exts'       =>    array('doc'),  // 设置附件上传类型
                'autoSub'    =>    false,   //是否使用子目录保存上传文件 
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $info = $upload->upload();
            //判断是否有图
            if($info){
                $data[oldname] = $info[businessplan][name];
                $data[name] = $info[businessplan][savename];
                $dataArr = json_encode($data);
                //返回文件名给JS作回调用
                echo $dataArr;         //输出上传文件名
            }else{
                echo 0;         //上传失败
            }
            exit();
        }
    } */
    /**
     *  保存融资需求信息 
     */
    public function insertinvest(){
        $Financingneeds = M('Financingneeds');
        $map[prid] = $_POST[prid];
        $data[budget] = $_POST[budget01];
        $data[singleinvest] = $_POST[singleinvest01];
//         $data[extras] = $_POST[extras01];
        $data[purpose] = $_POST[purpose01];
//         $data[businessplan] = $_POST[businessplan01];
        $data[privacyset] = $_POST[privacyset01];
        $data[addinfo] = $_POST[addinfo01];
//         $data[oldname] = $_POST[businessplanold01];
        $data[prid] = $_POST[prid];
        $result = $Financingneeds->add($data);
        $data[result] = $result;
        $dataArr = json_encode($data);
        echo $dataArr;
        exit();
    }
    /**
     *  获取融资需求信息 
     */
    public function editinvest(){
        $map[id] = $_GET[id];
        $Financingneeds = M('Financingneeds');
        $result = $Financingneeds->where($map)->find();
        $resultArr = json_encode($result);
        echo $resultArr;
        exit();
    }
    /**
     *  更新融资需求信息 
     */
    public function updateinvest(){
        $Financingneeds = M('Financingneeds');
        $map[id] = $_POST[investid];
//         if($_POST[businessplan03]){
//             $data[budget] = $_POST[budget03];
//             $data[singleinvest] = $_POST[singleinvest03];
// //             $data[extras] = $_POST[extras03];
//             $data[purpose] = $_POST[purpose03];
// //             $data[businessplan] = $_POST[businessplan03];
// //             $data[oldname] = $_POST[businessplanold03];
//             $data[privacyset] = $_POST[privacyset03];
//             $data[addinfo] = $_POST[addinfo03];
//             $result = $Financingneeds->where($map)->save($data);
//             $dataArr = json_encode($data);
//             echo $dataArr;
//         }else{
            $data[budget] = $_POST[budget03];
            $data[singleinvest] = $_POST[singleinvest03];
//             $data[extras] = $_POST[extras03];
            $data[purpose] = $_POST[purpose03];
            $data[privacyset] = $_POST[privacyset03];
            $data[addinfo] = $_POST[addinfo03];
            $result = $Financingneeds->where($map)->save($data);
            $dataArr = json_encode($data);
            echo $dataArr;
            exit();
//         }
    }
    /**
     *  进入项目图片页 
     */
    public function predit04(){
        $prid = $_GET[prid];
        $Primages = M('Primages');
        $map[prid] = $prid;
        $result = $Primages->where($map)->order("id asc")->select();
        //yc_vp($result);
        $this->assign('prid',$prid);
        $this->assign('imgs',$result);
        $this->display();
    }
    /** 
     * 项目描述
     */
    public function predit05(){
    	$prid = $_GET[prid];
    	$prdescription = M('Prdescription');
    	$map[prid] = $prid;
    	$result = $prdescription->where($map)->find();
    	$this->assign('prdes',$result[prdescription]);
    	//yc_vp($result);
    	$this->assign('prid',$prid);
    	$this->display();
    }
    /**
     * 项目描述添加
     */
    public function saveprdes(){
		$map[prid]=$_POST['prid'];
    	//$prdesdata[prdescription] = I("editor");
    	$prdesdata[prdescription] = htmlspecialchars($_POST[editor]);
    	$prdesdata[deal_time] = date("Y-m-d H:i:s");
    	$result=M('Prdescription')->where($map)->find();
    	if($result){
    		M('Prdescription')->where($map)->save($prdesdata);
    	}else{
    		$prdesdata[prid] = $_POST['prid'];
    		M('Prdescription')->add($prdesdata);
    	}
    	$dataArr=json_encode($prdesdata);
    	echo $dataArr;
    	exit();
    }
    
    // =====================================路演报名查看=================================================
    /**
     * 获取路演报名数据
     */
    public function getSignup($where,$status,$time){
        $this->getMenu();
        $Luyansignup = M('Luyansignup');
        $sql="SELECT
            wft_luyansignup.id,
            wft_luyansignup.realname,
            wft_luyansignup.telnumber,
            wft_luyansignup.status,
            wft_luyansignup.signuptime,
            wft_luyansignup.leavemsg
            FROM
            wft_luyansignup
            WHERE
            ".$where;
        $signup = M()->query($sql);
        $total = count($signup);
        $this->assign('_total',$total);
        $this->assign('list',$signup);
        $this->assign('status',$status);
        $this->assign('start',$time[start]);
        $this->assign('end',$time[end]);
        $this->display('luyan');
    }
    /**
     * 按时间筛选路演报名  */
    public function selectLuyan(){
		if($_POST[status]==0){
			$this->getSignup("'$_POST[start]' < wft_luyansignup.signuptime AND wft_luyansignup.signuptime < '$_POST[end]' AND wft_luyansignup.status=0",'0',$_POST);
		}else if($_POST[status]==1){
			$this->getSignup("'$_POST[start]' < wft_luyansignup.signuptime AND wft_luyansignup.signuptime < '$_POST[end]' AND wft_luyansignup.status=1",'1',$_POST);
		}else if($_POST[status]==2){
			$this->getSignup("'$_POST[start]' < wft_luyansignup.signuptime AND wft_luyansignup.signuptime < '$_POST[end]' AND wft_luyansignup.status>=0",'2',$_POST);
		}
    }
    /**
     *   所有报名人员 
     */
    public function allSignup(){
        $this->getSignup("wft_luyansignup.status>=0",'2');
    }
    /**
     *  投资人报名 
     */
    public function investorSignup(){
        $this->getSignup("wft_luyansignup.status=0","0");
    }
    /**
     *  项目方报名 
     */
    public function projectSignup(){
    	$this->assign('status',$status);
        $this->getSignup("wft_luyansignup.status=1","1");
    }
    // ==================================================================================================
    // =====================================网站建议=====================================================
    public function getSuggest(){
        $this->getMenu();
        $wwwsuggest = M('Wwwsuggest');
        $suggest = $wwwsuggest->select();
        $total = count($suggest);
        $this->assign('_total',$total);
        $this->assign('list',$suggest);
        $this->display('wwwsuggest');
    }
    public function suggestStatue(){
        // echo $_POST[id];
        $wwwsuggest = M('Wwwsuggest');
        $map[id] = $_POST[id];
        $data[statue] = $_POST[statue];
        $suggest = $wwwsuggest->where($map)->save($data);
        echo $suggest;
    }
    public function selectSuggest(){
 		$this->getMenu();
 		$this->assign('start',$_POST[start]);
 		$this->assign('end',$_POST[end]);
        $wwwsuggest = M('Wwwsuggest');
        $suggest = $wwwsuggest->where("'$_POST[start]' < wft_wwwsuggest.subTime AND wft_wwwsuggest.subTime < '$_POST[end]'")->select();
        $total = count($suggest);
        $this->assign('_total',$total);
        $this->assign('list',$suggest);
        $this->display('wwwsuggest');
    }
    // ==================================================================================================
    // =====================================项目查看=====================================================
    /**
     *	当前用户所在用户组的group_id   
     */
    public function getGroupid(){
    	$uid = $_SESSION[onethink_admin][user_auth][uid];
    	$Auth_group = M('auth_group_access');
    	$ResAuth = $Auth_group->field('group_id')->where("uid='$uid'")->find();
    	return $ResAuth[group_id];
    }
    /**
     *  筛选项目
     */
    private function getpros($where_and){
        $this->getMenu();
        $Project = M('Project');
        $sql = "SELECT
            wft_project.id,
            wft_project.pid,
            wft_project.pjname,
            wft_project.linkman,
            wft_project.prphone,
            wft_project.pjintroduce,
            wft_project.stageid,
            wft_project.provinceid,
            wft_project.province,
            wft_project.cityid,
            wft_project.city,
            wft_project.townid,
            wft_project.town,
            wft_project.fathertradeid,
            wft_project.fathertrade,
            wft_project.fulltradeid,
            wft_project.fulltrade,
            wft_project.logo,
            wft_project.oldname,
            wft_project.submit_time,
            wft_project.update_time,
            wft_project.prreviewid,
            wft_project.prreview,
            wft_project.prrate,
            wft_project.why,
            wft_project.financing,
            wft_project.`status`,
            wft_homeuser.email,
            wft_financingneeds.budget,
            invested.totalmoney
            FROM
            wft_project
            LEFT JOIN wft_homeuser ON wft_project.pid = wft_homeuser.id
            LEFT JOIN wft_financingneeds ON wft_project.id = wft_financingneeds.prid
            LEFT JOIN (SELECT
            sum(wft_financing.money) as totalmoney,
            wft_financing.prid
            FROM
            wft_financing
            GROUP BY
            wft_financing.prid
            ) AS invested
            ON wft_project.id = invested.prid
            WHERE 
        ".$where_and;
        $prreview = M()->query($sql);
        $total = count($prreview);
        $this->assign('_total',$total);
        $this->assign('list',$prreview);
        /* 所有项目助理 */
        $sql = "select * from wft_member left join wft_auth_group_access on(wft_member.uid = wft_auth_group_access.uid) where(wft_member.status=1 AND wft_auth_group_access.group_id = 3)";
        $prreviewes = M()->query($sql);
        $this->assign('prreviewes',$prreviewes);
        
        $this->display('review');
    }
   /** 
    *  所有项目
    */
    public function allProject(){
//     	yc_vp(count($_SESSION));
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate>=-1");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
        		$this->getpros("wft_project.prreviewid = '$prreviewid'");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("prrate>=-1 AND wft_project.prreviewid = '$prreviewid'");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("prrate>-1 AND wft_project.prreviewid IS NOT NULL");
        	}
        }    
    }
    /**
     * 待审核项目页 
     */
    public function review(){
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate=-1");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
//         		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=-1");
        		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=1");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("wft_project.prrate=-1");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("wft_project.prrate=-1");
        	}
        }
    }
    /** 
     * 不通过 的项目
     */
    public function failProject(){
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate=0");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
        		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=0");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("prrate=0");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("prrate=0");
        	}
        }
    }
    /** 
     * 通过的项目 
     */
    public function passProject(){
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate=1");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
        		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=1");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("prrate>=1");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("prrate=1");
        	}
        }
    }
    /** 
     * 预热中的项目 
     */
    public function preheatProject(){
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate=2");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
        		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=2");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("prrate=2");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("prrate=2");
        	}
        }
    }
    /**
     * 正式上线的项目 
     */
    public function onlineProject(){
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate=3");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
        		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=3");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("prrate=3");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("prrate=3");
        	}
        }
    }
    /**
     * 融资成功的项目 
     */
    public function successProject(){
        if(count($_SESSION)==1){            //判断是否是超级管理员
            $this->getpros("prrate=4");
        }else{
        	$group_id = $this->getGroupid();
        	$this->assign('group_id',$group_id);
        	if($group_id == 3){			//项目助理 得到的结果
        		$prreviewid = $_SESSION[onethink_admin][user_auth][uid];
        		$this->getpros("wft_project.prreviewid = '$prreviewid' AND prrate=4");
        	}else if($group_id == 4){	//项目客服 得到的结果
        		$this->getpros("prrate=4");
        	}else if($group_id == 9){	//项目经理 得到的结果
        		$this->getpros("prrate=4");
        	}
        }
    }
    /**
     * 项目隐藏、项目页显示、首页+项目页显示  
     */
    public function showHide($status,$id){
    	$data[status] = $status;
    	$map[id] = $id;
    	$result = M('Project')->where($map)->save($data);
    	echo $result;
    }
    /**
     * 项目通过  
     */
    public function rate1(){
    	/* var_dump($_POST);
    	exit(); */
        $id = $_POST[prid];
        $Project = M('Project');
        $map[id] = $id;
        $data[prrate] = 1; //项目进度1为通过
        $data[why] = '';
        $data['review_time'] = date("Y-m-d h:i:sa");
        $result = $Project->where($map)->save($data);
        $resultArr = json_encode($result);
        echo $resultArr;
		/* $phone=implode(',',$_POST[mobile]);
		$phone=$_POST[mobile];
	
		$account = $_POST[name];
		$pwd = $_POST[pwd];
		$date = date("Y-m-d H:i:s");

		$content = iconv("utf-8","utf-8",$_POST[content]."[签名]");
		
		$url = 'http://web.duanxinwang.cc/asmx/smsservice.aspx';
		$data['name'] = $account;
		$data['pwd'] = $pwd;
		$data['content']=$content;
		$data['mobile'] = $phone;
		$data['stime'] = $date;
		$data['sign'] = '签名';
		$data['type'] = 'pt';
		$data['extno'] = '';
		$info = $this->postSMS($url, $data);
		return $info; */	
    }
    /**
     * POST提交短信数据
     */
    /* public function postSMS($url,$data=''){
    	//var_dump($data);
    	//exit();
    	$row = parse_url($url);
    	$host = $row['host'];
    	$port = $row['port'] ? $row['port']:80;
    	$file = $row['path'];
    	while (list($k,$v) = each($data)){
    		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
    	}
    	$post = substr( $post , 0 , -1 );
    	$len = strlen($post);
    	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
    	if (!$fp) {
    		return "$errstr ($errno)\n";
    	} else {
    		$receive = '';
    		$out = "POST $file HTTP/1.1\r\n";
    		$out .= "Host: $host\r\n";
    		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
    		$out .= "Connection: Close\r\n";
    		$out .= "Content-Length: $len\r\n\r\n";
    		$out .= $post;
    		fwrite($fp, $out);
    		while (!feof($fp)) {
    			$receive .= fgets($fp, 128);
    		}
    		fclose($fp);
    		$receive = explode("\r\n\r\n",$receive);
    		unset($receive[0]);
    		return implode("",$receive);
    	}
    } */
    /** 
     * 项目不通过 
     */
    public function why(){
        $id = $_GET[prid];
        $why = $_GET[why];
        $Project = M('Project');
        $map[id] = $id;
        $data[prrate] = 0;  //项目进度为0为不通过
        $data[why] = $why;
        $result = $Project->where($map)->save($data);
        echo $result;
    }
    /**
     * 项目预热  
     */
    public function rate2(){
        $id = $_GET[prid];
        $Project = M('Project');
        $map[id] = $id;
        $data[prrate] = 2; //项目进度2为通过
        $data[why] = '';
        $result = $Project->where($map)->save($data);
        $resultArr = json_encode($result);
        echo $resultArr;
    }
    /** 
     * 项目融资中 
     */
    public function rate3(){
        $id = $_GET[prid];
        $Project = M('Project');
        $map[id] = $id;
        $data[prrate] = 3; //项目进度3为融资中
        $data[why] = '';
        $result = $Project->where($map)->save($data);
        $resultArr = json_encode($result);
        echo $resultArr;
    }
    /**
     * 项目融资成功 
     */
    public function rate4(){
        $id = $_GET[prid];
        $Project = M('Project');
        $map[id] = $id;
        $data[prrate] = 4; //项目进度4为融资成功
        $data[why] = '';
        $result = $Project->where($map)->save($data);
        $resultArr = json_encode($result);
        echo $resultArr;
    }
    /**
     * 融资信息页 
     */
    public function financing(){
        $sql = 'SELECT
            wft_homeuser.id,
            wft_homeuser.username,
            wft_investor.uid
            FROM
            wft_homeuser
            INNER JOIN wft_investor ON wft_homeuser.id = wft_investor.uid
            GROUP BY
            wft_homeuser.id';
        $investors = M()->query($sql);              //投资人查询
        $this->assign('investors',$investors);

        $prid = $_GET[prid];
        $Project = M('Project');        //项目信息
        $prmap[id] = $prid;
        $prresult = $Project->where($prmap)->find();
        $this->assign('prid',$prid);
        $this->assign('prname',$prresult[pjname]);
        $Financing = M('Financing');
        $finanmap[prid] = $prid;
        $result = $Financing->where($finanmap)->select();    //已融资查询
        for ($i=0;$i < count($result);$i++) {       //已融资总和
            $invested += $result[$i][money];
        }
        $Financingneeds = M('Financingneeds');      //融资需求额
        $investneed = $Financingneeds->where($finanmap)->find();
        $width = round($invested/$investneed[budget],2)*100;     //融资进度
        // echo $width;
        $this->assign('width',$width);
        $this->assign('list',$result);
        $this->display();
    }
    /**
     * 融资信息添加 
     */
    public function financingadd(){
        $homeusermap[id] = $_POST[invest];      //投资人用户名获取
        $Homeuser = M('Homeuser');
        $data[name] = $Homeuser->where($homeusermap)->getField('username');
        $data[pid] = $_POST[invest]; //投资人id
        $data[prid] = $_POST[prid]; //项目id
        $data[money] = $_POST[investmoney]; //投资金额
        $data[investtime] = $_POST[investtime]; //投资日期
        $data[catipalperiod] = $_POST[catipalperiod]; //回本期
        $data[interestperiod] = $_POST[interestperiod]; //收益期
        $data[yield] = $_POST[yield]; //收益率
        $data[paybacktime] = $_POST[paybacktime]; //还款开始时间

        $Financing = M('Financing');
        $result = $Financing->add($data);
        $map[id] = $result;                     //获取投资信息
        $resultfind = $Financing->where($map)->find();
        $resultArr = json_encode($resultfind);
        echo $resultArr;
    }
    /**
     * 融资信息删除  
     */
    public function finandelete(){
        $id = $_GET[id];
        $map[id] = $id;
        $Financing = M('Financing');
        $result = $Financing->where($map)->delete();
        echo $result;
    }
    
    //投资人//
    //筛选投资人
    private function getinvs($where)
    {
        $this->getMenu();
        $sql = "SELECT
            wft_investor.id,
            wft_homeuser.email,
            wft_homeuser.username,
            wft_investor.realname,
            wft_investor.phone,
            wft_investor.company,
            wft_investor.income,
            wft_investor.min_maney,
            wft_investor.max_maney,
            wft_investor.update_time,
            wft_investor.iden_status
            FROM
            wft_investor
            LEFT JOIN 
            wft_homeuser ON wft_investor.uid = wft_homeuser.id ".$where;
        $invs = M()->query($sql);
        $_total = count($invs);
        $this->assign('_total',$_total);
        $this->assign('list',$invs);
        $this->display('investorApply');
    }
    //投资人审核
    public function investorApply()
    {
        $this->getinvs("WHERE wft_investor.iden_status!=0");
        // $this->getinvs();
    }
    //未注册投资人
    public function wzcinvestors()
    {
        $this->getinvs("WHERE wft_investor.iden_status=0");
    }
    //待审核投资人
    public function dshinvestors()
    {   
        $this->getinvs("WHERE wft_investor.iden_status=1");
    }
    //审核未通过投资人
    public function wtginvestors()
    {
        $this->getinvs("WHERE wft_investor.iden_status=-1");
    }
    //审核通过投资人
    public function tginvestors()
    {
        $this->getinvs("WHERE wft_investor.iden_status=2");
    }
    //微风投认证投资人
    public function rzinvestors()
    {
        $this->getinvs("WHERE wft_investor.iden_status=3");
    }
    //投资人审核详细信息
    public function invApplyInfo()
    {
        if ($_GET['id']) {
            $invinfo = D("Home/Investor")->where("id='$_GET[id]'")->relation(true)->limit("1")->select();
            $this->assign("invinfo",$invinfo);
            // $id = $_GET['id'];
            // $sql = "SELECT
            //     wft_investor.id,
            //     wft_homeuser.email,
            //     wft_investor.realname,
            //     wft_investor.phone,
            //     wft_investor.company,
            //     wft_investor.income,
            //     wft_investor.min_maney,
            //     wft_investor.max_maney,
            //     wft_investor.inv_info,
            //     wft_investor.f_image,
            //     wft_investor.b_image,
            //     wft_investor.add_time,
            //     wft_investor.update_time,
            //     wft_investor.uid,
            //     wft_investor.iden_status,
            //     wft_homeuser.username,
            //     wft_homeuser.`password`,
            //     wft_homeuser.reg_time,
            //     wft_homeuser.update_time,
            //     wft_homeuser.`status`
            //     FROM
            //     wft_investor
            //     LEFT JOIN wft_homeuser ON wft_investor.uid = wft_homeuser.id
            //     WHERE
            //     wft_investor.id = '$id' 
            //     LIMIT 1
            // ";
            // $invinfo = M()->query($sql);
            // $cases = M('inv_case')->where("inv_id='$id'")->select();
            // $invdenymsginfo = M('invdenymsg')->where("iid='$id'")->select();
            // if ($invdenymsginfo) {
            //     $this->assign('denymsg',$invdenymsginfo[0][denymsg]);
            // }
            // $this->assign('invinfo',$invinfo);
            // $this->assign('cases',$cases);
            $this->display();
        }
    }
    //通过审核
    public function invApplyPass()
    {
        if (IS_POST) {
            $id = $_POST['id'];
            $data['iden_status'] = 2;
            M('investor')->where("id='$id'")->save($data);
            M('invdenymsg')->where("iid='$id'")->delete();
            echo "已通过";
        }
    }
    //微风投认证
    public function invApplyRz()
    {
        if (IS_POST) {
            $id = $_POST['id'];
            $data['iden_status'] = 3;
            M('investor')->where("id='$id'")->save($data);
            M('invdenymsg')->where("iid='$id'")->delete();
            echo "已成为微风投认证投资人";
        }
    }
    //拒绝
    public function invApplyDeny()
    {
        if (IS_POST) {
            $id = $_POST['id'];
            $denymsg = $_POST['msg'];
            $data['iden_status'] = -1;
            M('investor')->where("id='$id'")->save($data);
            unset($data[iden_status]);
            $data[iid] = $id;
            $data[denymsg] = $denymsg;
            $count = M('invdenymsg')->where("iid='$id'")->select();
            if ($count) {
                M('invdenymsg')->where("iid='$id'")->save($data);
            }else{
                M('invdenymsg')->data($data)->add();
            }
            echo "已拒绝";
        }
    }

    //项目图片上传
    public function upImg(){
        /* 
        * 项目图片上传
        */
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 1*1024*1024 ;// 设置附件上传大小1M
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->autoSub = false;
        $upload->savePath = './PrImages/'; // 设置附件上传目录
        $fileName = date('YmdHis',time()).'_'.rand(100,999);
        $upload->saveName = $fileName;
        // 上传文件
        $info = $upload->upload();
        if($info){
            $data[prid] = $_POST[prid];
            $data[name] = $info[upImg][savename];
            $data[oldname] = $info[upImg][name];
            $image = new \Think\Image();        //图像操作
            $image -> open('./Uploads/PrImages/'.$info[upImg][savename]);          //打开图像文件
            $width = $image -> width();
            $height = $image -> height();
            $thumbname = 'thumb_'.$info[upImg][savename];               //生成的缩略图名
            $image -> thumb(245,157)->save('./Uploads/PrImages/'.$thumbname);   //生成245*157的缩略图并保存名为$thumbname
            $data[thumbname] = $thumbname;
            $Primages = M('Primages');          //图片名保存操作
            $result = $Primages->add($data);
            $data[id] = $result;
            $data[imgwidth] = $width;
            $data[imgheight] = $height;
            $dataArr = json_encode($data);
            echo $dataArr;
            exit();
        }else{          //上传不成功，图片大于1M
            echo 0;
            exit();
        }
    }

    //删除项目图片
    public function imgDel()
    {
        if (IS_POST) {
            $id = $_POST['imgId'];
            $msg = M('primages')->delete($id);
            if ($msg) {
                echo "1";
            }else{
                echo "0";
            }
        }
    }

    //融资详情还款操作//
    //融资详情页
    public function finsinfo(){
        if ($_GET[id]) {
            $this->getMenu();
            $prid = $_GET[id];
            $proinfo = M('project')->where("id='$prid'")->limit("1")->select();
            $this ->assign('proinfo',$proinfo); // 注入项目详情
            $sql = "SELECT
                wft_financing.id,
                wft_homeuser.username,
                wft_financing.money,
                wft_financing.catipalperiod,
                wft_financing.interestperiod,
                wft_financing.yield,
                wft_financing.investtime,
                wft_financing.paybacktime,
                wft_financing.`name`,
                wft_financing.pid,
                wft_financing.prid
                FROM
                wft_financing
                LEFT JOIN wft_homeuser ON wft_financing.pid = wft_homeuser.id
                WHERE wft_financing.prid ='$prid'";
            $fins = M()->query($sql);
            $this ->assign('list',$fins);//注入融资详情
            $this ->assign('_total',count($fins));//注入总数
            $this->display();
        }else{
            $this->error("非法操作！");
        }
    }

    //还款计划
    public function create_repay_plan()
    {
        if (IS_POST) {
            $data[fin_id] = $_POST[fin_id];
            $fininfo = M('financing')->where("id='$data[fin_id]'")->limit("1")->select();
            $ok = 1;
            M()->startTrans();
            for ($i=1; $i<= $fininfo[0][catipalperiod]; $i++) { 
                $data[m_id] = $i;
                $data[m_name] = "回本期";
                $data[begin_time] = cal_time($fininfo[0][paybacktime],$i-1);
                $data[end_time] = cal_time($fininfo[0][paybacktime],$i);
                $data[plan_money] = intval($fininfo[0][money]/$fininfo[0][catipalperiod]);
                if (!M('repaydetail')->data($data)->add()) {
                    $ok = $ok*0;
                }
            }
            for ($i=$fininfo[0][catipalperiod]+1 ; $i<=$fininfo[0][catipalperiod] + $fininfo[0][interestperiod] ; $i++) { 
                $data[m_id] = $i;
                $data[m_name] = "收益期";
                $data[begin_time] = cal_time($fininfo[0][paybacktime],$i-1);
                $data[end_time] = cal_time($fininfo[0][paybacktime],$i);
                $data[plan_money] = intval($fininfo[0][money]*$fininfo[0][yield]/1000);
                if (!M('repaydetail')->data($data)->add()) {
                    $ok = $ok*0;
                }
            }
            if ($ok==0) {
                M()->rollback();
            }else{
                M()->commit();
            }
            echo $ok;
        }
        exit;
    }

    //还款计划明细页
    public function repaydetail()
    {
        if ($_GET[id]) {
            $this->getMenu();
            $fin_id = $_GET[id];
            $fininfo = M('financing')->where("id='$fin_id'")->limit("1")->select();
            $this->assign('fininfo',$fininfo); // 注入融资详情
            $repays = M("repay")->where("fin_id='$fin_id'")->select();
            $this->assign('repays',$repays); //注入各个还款
            $repaydetail = M('repaydetail')->where("fin_id='$fin_id'")->select();
            $this->assign('list',$repaydetail); // 注入还款详情
            $this->assign('_total',count($repaydetail));
            $this->display();
        }else{
            $this->error("非法操作！");
        }
    }

    //进行还款
    public function repay()
    {
        if (IS_POST) {
            // yc_vp($_POST,1);
            $data[fin_id] = $_POST[fin_id];
            $data[repay_m_id] = $_POST[repay_m_id];
            $data[repay_time] = $_POST[time];
            $data[repay_money] = $_POST[money];
            $data[repay_msg] = I("post.msg",'','htmlspecialchars');
            if (M('repay')->data($data)->add()) {
                echo "1";
            }else{
                echo "0";
            }
        }
    }

    //项目人还款记录页
    public function hasrepay()
    {
        if ($_GET[fin_id]) {
            $fin_id = $_GET[fin_id];
            $this->getMenu();
            $repays = M("repay")->where("fin_id='$fin_id'")->select();
            $this->assign('list',$repays); //注入各个还款
            $this->assign('_total',count($repays));
            if ($_POST[delete_id]) {
                if (M('repay')->where("id='$_POST[delete_id]'")->delete()) {
                    exit("删除成功");
                }else{
                    exit("删除失败");
                }
            }
            $this->display();
        }else{
            $this->error("非法操作！");
        }
    }
    
    //预约管理//
    //预出资管理
    public function yuchuzi()
    {
    	$this->getMenu();
    	$chuzis = M('Chuzi')->select();
    	$this->assign('_total',count($chuzis));
    	$this->assign('list',$chuzis);
    	$this->display();
    }
    
    //预投递管理
    public function yutoudi()
    {
    	$this->getMenu();
    	$toudis = M('Prodelivery')->select();
    	$this->assign('_total',count($toudis));
    	$this->assign('list',$toudis);
    	$this->display();
    }
    /**
     * 导出网站建议Excel
     */
    public function exportSuggestExcel(){
    	$xlsName  = "Suggest";
    	//填入表头
    	$xlsCellName  = array(
    			array('id','ID序列'),
    			array('suggestText','建议内容'),
    			array('contant','联系方式'),
    			array('subTime','提交时间'),
    	);
    	//查询结果
    	$xlsModel = M('Wwwsuggest');
    	if(empty($_GET[start]) OR empty($_GET[end])){
    		$xlsTableData  = $xlsModel->Field('id,suggestText,contant,subTime')->select();
    	}else{
    		$xlsTableData  = $xlsModel->Field('id,suggestText,contant,subTime')->where("'$_GET[start]' < wft_wwwsuggest.subTime AND wft_wwwsuggest.subTime < '$_GET[end]'")->select();
    	}
    	$xlsTitle=iconv('utf-8', 'gb2312', $xlsName);//文件名称
    	/* $fileName=$_SESSION['loginaccount'].data('_YmdHis');//or $xlsTitle文件名称可根据自己情况设定 */
    	$fileName=date("Y/m/d/H/i/s");//or $xlsTitle文件名称可根据自己情况设定
    	$cellNum=count($xlsCellName);		//列数
    	$dataNum=count($xlsTableData);		//数据条数
    	Vendor('Classes.PHPExcel');			//导入Vendor/Classes下的PHPExcel.php
    	$objPHPExcel = new \PHPExcel();		//实例化一个处理对象
    	$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
    	//合并单元格
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellName[$cellNum-1].'1');
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:'.$cellName[$cellNum-1].'2');
    	$objPHPExcel->getActiveSheet()->mergeCells('A'.($dataNum+4).':'.$cellName[$cellNum-1].($dataNum+4));
    	//设置当前活动sheet的名称
    	$objPHPExcel->getActiveSheet()->setTitle('自定义查询结果');
    	//填入主标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A1','河南梧桐盛嘉投资管理有限公司');
    	//填入副标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A2','————————weifengtou网站建议列表————————');
    	//Excel底部文字
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+4),'——————————————————————————');
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+5),'共计'.$dataNum.'条建议');
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+6),'导出时间：['.date('Y-m-d H:m:s').']');
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6.5);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(38);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(23);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
    	//设置字体样式
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('黑体');
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getFont()->setSize(16);
    	//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	//数据填充
    	for($i=0;$i<$cellNum;$i++){
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'3', $xlsCellName[$i][1]);
    	}
    	for($i=0;$i<$dataNum;$i++){
    		for($j=0;$j<$cellNum;$j++){
    			//自动换行
    			$objPHPExcel->getActiveSheet()->getStyle('B'.($i+4))->getAlignment()->setWrapText(true);
    			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    			$objPHPExcel->getActiveSheet()->getStyle('C'.($i+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    			$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+4), $xlsTableData[$i][$xlsCellName[$j][0]]);
    		}
    	}
    	//发送头信息设置
    	header('pragma:public');
    	header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    	header('Content-Disposition: attachment;filename="自定义表('.date('Ymd-His').').xls"');  //日期为文件名后缀
    	$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    	$objWriter->save('php://output');		//直接导出文件
    	exit;
    }
    /**
     * 导出路演报名名单 
     */
    public function exportLuyanExcel(){
    	$xlsName  = "Luyansign";
    	//填入表头
    	$xlsCellName  = array(
    			array('id','ID序列'),
    			array('realname','姓名'),
    			array('telnumber','联系方式'),
    			array('status','类型'),
    			array('leavemsg','留言'),
    			array('signuptime','报名时间'),
    	);
    	//查询结果
    	$xlsModel = M('Luyansignup');
    	if(empty($_GET[start]) OR empty($_GET[end])){
    		if($_GET[status]==2){
    			$xlsTableData = $xlsModel->Field('id,realname,telnumber,status,leavemsg,signuptime')->where("wft_luyansignup.status >= 0")->select();
    		}else{
    			$xlsTableData = $xlsModel->Field('id,realname,telnumber,status,leavemsg,signuptime')->where("wft_luyansignup.status = '$_GET[status]'")->select();
    		}
    	}else{
    		if($_GET[status]==2){
    			$xlsTableData = $xlsModel->Field('id,realname,telnumber,status,leavemsg,signuptime')->where("'$_GET[start]' < wft_luyansignup.signuptime AND wft_luyansignup.signuptime < '$_GET[end]' AND wft_luyansignup.status >= 0")->select();
    		}else{
    			$xlsTableData = $xlsModel->Field('id,realname,telnumber,status,leavemsg,signuptime')->where("'$_GET[start]' < wft_luyansignup.signuptime AND wft_luyansignup.signuptime < '$_GET[end]' AND wft_luyansignup.status = '$_GET[status]'")->select();
    		}
    		
    	}

    	$xlsTitle=iconv('utf-8', 'gb2312', $xlsName);//文件名称
    	$fileName=date("Y/m/d/H/i/s");//or $xlsTitle文件名称可根据自己情况设定
    	$cellNum=count($xlsCellName);		//列数
    	$dataNum=count($xlsTableData);		//数据条数
    	Vendor('Classes.PHPExcel');			//导入Vendor/Classes下的PHPExcel.php
    	$objPHPExcel = new \PHPExcel();		//实例化一个处理对象
    	$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
    	//合并单元格
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$cellName[$cellNum-1].'1');
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:'.$cellName[$cellNum-1].'2');
    	$objPHPExcel->getActiveSheet()->mergeCells('A'.($dataNum+4).':'.$cellName[$cellNum-1].($dataNum+4));
    	//设置当前活动sheet的名称
    	$objPHPExcel->getActiveSheet()->setTitle('自定义查询结果');
    	//填入主标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A1','河南梧桐盛嘉投资管理有限公司');
    	//填入副标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A2','—————————微风投路演报名列表—————————');
    	//Excel底部文字
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+4),'———————————————————————————');
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+5),'共计'.$dataNum.'位');
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+6),'导出时间：['.date('Y-m-d H:m:s').']');
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    	//设置字体样式
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('黑体');
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getFont()->setSize(16);
    	//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	//数据填充
    	for($i=0;$i<$cellNum;$i++){
    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'3', $xlsCellName[$i][1]);
    	}
    	for($i=0;$i<$dataNum;$i++){
    		$objPHPExcel->getActiveSheet()->getStyle('A'.($i+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		$objPHPExcel->getActiveSheet()->getStyle('B'.($i+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		$objPHPExcel->getActiveSheet()->getStyle('C'.($i+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    		$objPHPExcel->getActiveSheet(0)->setCellValue(A.($i+4), $xlsTableData[$i][$xlsCellName[0][0]]);
    		$objPHPExcel->getActiveSheet(0)->setCellValue(B.($i+4), $xlsTableData[$i][$xlsCellName[1][0]]);
    		$objPHPExcel->getActiveSheet(0)->setCellValue(C.($i+4), $xlsTableData[$i][$xlsCellName[2][0]]);
    		if($xlsTableData[$i][$xlsCellName[3][0]]==0){
    			$objPHPExcel->getActiveSheet(0)->setCellValue(D.($i+4), '投资人');
    		}else{
    			$objPHPExcel->getActiveSheet(0)->setCellValue(D.($i+4), '项目方');
    		}
    		$objPHPExcel->getActiveSheet(0)->setCellValue(E.($i+4), $xlsTableData[$i][$xlsCellName[4][0]]);
    		$objPHPExcel->getActiveSheet(0)->setCellValue(F.($i+4), $xlsTableData[$i][$xlsCellName[5][0]]);
    	}
    	//发送头信息设置
    	header('pragma:public');
    	header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    	header('Content-Disposition: attachment;filename="自定义表('.date('Ymd-His').').xls"');  //日期为文件名后缀
    	$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    	$objWriter->save('php://output');		//直接导出文件
    	exit;
    }
    /**
     * 导出项目基本信息
     */
    public function exportLookover01Excel(){
    	$xlsName  = "Project";
    	//查询项目基本信息结果
    	$xlsPrModel = M('Project');
     	$xlsPrTableData = $xlsPrModel->Field('id,pjname,prphone,pjintroduce,prabout,prwhysupport,prpromise,prdanger,stageid,province,city,town,fathertrade,fulltrade,logo')->where("id='$_GET[prid]'")->find();
     	//查询项目团队成员结果
     	$xlsMeModel = M('Prmember');
     	$xlsMeTableData = $xlsMeModel->Field('membername,memberposition,memberroleid,memberintroduce,photo')->where("prid = '$_GET[prid]'")->select();
    	$xlsTitle=iconv('utf-8', 'gb2312', $xlsName);//文件名称
    	$fileName=date("Y/m/d/H/i/s");//or $xlsTitle文件名称可根据自己情况设定
    	$cellNum=3;
    	$dataNum=count($xlsMeTableData);		//数据条数
    	Vendor('Classes.PHPExcel');			//导入Vendor/Classes下的PHPExcel.php ,引入phpexcel核心类文件
    	$objPHPExcel = new \PHPExcel();		/*实例化excel类*/
    	//合并单元格
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
    	$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
    	$objPHPExcel->getActiveSheet()->mergeCells('A'.($dataNum+$dataNum*3+14).':G'.($dataNum+$dataNum*3+14).'');
    	$objPHPExcel->getActiveSheet()->mergeCells('C6:G6');
     	$objPHPExcel->getActiveSheet()->mergeCells('C10:G10');
     	$objPHPExcel->getActiveSheet()->mergeCells('C11:G11');
     	$objPHPExcel->getActiveSheet()->mergeCells('C12:G12');
     	$objPHPExcel->getActiveSheet()->mergeCells('C13:G13');
     	$objPHPExcel->getActiveSheet()->mergeCells('C14:G14');
    	$objPHPExcel->getActiveSheet()->mergeCells('A4:A9');
    	//自动换行
    	$objPHPExcel->getActiveSheet()->getStyle('C6')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('B10')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('C10')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A11')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('B11')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('C11')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A12')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('B12')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('C12')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A13')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('B13')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('C13')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A14')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->getStyle('C14')->getAlignment()->setWrapText(true);
    	$objPHPExcel->getActiveSheet()->setTitle('自定义查询结果');//设置当前活动sheet的名称
    	$objPHPExcel->getActiveSheet()->setCellValue('A2','河南梧桐盛嘉投资管理有限公司');//填入主标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A3','微风投网站项目信息表');//填入副标题
    	//Excel底部文字
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+$dataNum*3+14),'——————————————————————————————————————————————————————');
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+$dataNum*3+15),'导出时间：['.date('Y-m-d H:m:s').']');
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(23);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    	// 设置行高
    	$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(120);
    	$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(120);
    	$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(120);
    	$objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(120);
    	$objPHPExcel->getActiveSheet()->getRowDimension('14')->setRowHeight(30);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('黑体');//设置字体样式
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(16);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objDrawing = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing->setName('Logo');
    	$objDrawing->setDescription('Logo');
    	$objDrawing->setPath('./Uploads/Album/'.$xlsPrTableData[logo]);
    	$objDrawing->setCoordinates('A4');
    	$objDrawing->setWidth(95);
    	$objDrawing->setHeight(84);
    	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    	
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B4', '项目名：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C4', $xlsPrTableData[pjname]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B5', '联系方式：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C5', $xlsPrTableData[prphone]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B6', '一句话介绍：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C6', $xlsPrTableData[pjintroduce]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B7', '所处阶段：');
    	if($xlsPrTableData[stageid]=1){
    		$objPHPExcel->getActiveSheet(0)->setCellValue('C7', '起步阶段');
    	}else if($xlsPrTableData[stageid]=2){
    		$objPHPExcel->getActiveSheet(0)->setCellValue('C7', '盈利阶段');
    	}else if($xlsPrTableData[stageid]=3){
    		$objPHPExcel->getActiveSheet(0)->setCellValue('C7', '亏损阶段');
    	}
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B8', '所在城市：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C8', $xlsPrTableData[province].$xlsPrTableData[city].$xlsPrTableData[town]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B9', '所属行业：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C9', $xlsPrTableData[fathertrade].$xlsPrTableData[fulltrade]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('A10', '简单介绍项目的亮点和不足，市场规模和产品的使用场景，已经取得的成绩和优势。');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B10', '关于我们：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C10', $xlsPrTableData[prabout]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('A11', '简单介绍项目的亮点和不足，市场规模和产品的使用场景，已经取得的成绩和优势。');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B11', '为什么我们需要你的支持：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C11', $xlsPrTableData[prwhysupport]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('A12', '简单介绍项目的亮点和不足，市场规模和产品的使用场景，已经取得的成绩和优势。');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B12', '我们的承诺与回报：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C12', $xlsPrTableData[prpromise]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('A13', '简单介绍项目的亮点和不足，市场规模和产品的使用场景，已经取得的成绩和优势。');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B13', '项目风险：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C13', $xlsPrTableData[prdanger]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue('A14', '天使投资很大程度就是“投人”，所以请认真填写以获得投资人的信任。');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('B14', '团队信息：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue('C14', '成员添加流程：1.线上添加 2.线下邀请他注册微风投 3.发出邀请 4.请他在系统私信中接受邀请');
    	//项目成员
    	for($i=0;$i<$dataNum;$i++){
    		$objDrawing = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    		$objDrawing->setName('Photo');
    		$objDrawing->setDescription('Photo');
    		$objDrawing->setPath('./Uploads/Portrait/'.$xlsMeTableData[$i][photo]);
    		$objDrawing->setCoordinates('C'.($i+$i*3+15).'');
    		$objDrawing->setWidth(80);
    		$objDrawing->setHeight(60);
    		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    		//合并单元格
    		$objPHPExcel->getActiveSheet()->mergeCells('A'.($i+14).':A'.($i+$i*3+17).'');
    		$objPHPExcel->getActiveSheet()->mergeCells('B'.($i+14).':B'.($i+$i*3+17).'');
    		$objPHPExcel->getActiveSheet()->mergeCells('C'.($i+$i*3+15).':C'.($i+$i*3+17).'');
    		$objPHPExcel->getActiveSheet()->mergeCells('D'.($i+$i*3+15).':D'.($i+$i*3+17).'');
    		$objPHPExcel->getActiveSheet()->mergeCells('C'.($i+$i*3+15).':D'.($i+$i*3+15).'');
    		$objPHPExcel->getActiveSheet()->mergeCells('E'.($i+$i*3+16).':G'.($i+$i*3+16).'');
    		//自动换行
    		$objPHPExcel->getActiveSheet()->getStyle('E'.($i+$i*3+16).'')->getAlignment()->setWrapText(true);
    		
    		$objPHPExcel->getActiveSheet(0)->setCellValue(E.($i+$i*3+15), $xlsMeTableData[$i][membername]);
    		$objPHPExcel->getActiveSheet(0)->setCellValue(F.($i+$i*3+15), $xlsMeTableData[$i][memberposition]);
    		if($xlsMeTableData[$i][memberroleid]==0){
    			$objPHPExcel->getActiveSheet(0)->setCellValue(G.($i+$i*3+15), '创建人');
    		}else{
    			$objPHPExcel->getActiveSheet(0)->setCellValue(G.($i+$i*3+15), '其他成员');
    		}
    		$objPHPExcel->getActiveSheet(0)->setCellValue(E.($i+$i*3+16), $xlsMeTableData[$i][memberintroduce]);
    	}
    	//发送头信息设置
    	header('pragma:public');
    	header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    	header('Content-Disposition: attachment;filename="自定义表('.date('Ymd-His').').xls"');  //日期为文件名后缀
    	$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    	$objWriter->save('php://output');		//直接导出文件
    	exit;
    }
    /**
     * 导出项目审核资料  
     */
    public function exportLookover02Excel(){
    	$xlsName  = "Prcompany";
    	//查询结果
    	$xlsModel = M('Companydata');
    	$xlsTableData = $xlsModel->Field('fornt,rear,legalperson,businesslicence,taxcertificate,companyimg')->where("prid = '$_GET[prid]'")->find();
    	$xlsTitle=iconv('utf-8', 'gb2312', $xlsName);//文件名称
    	$fileName=date("Y/m/d/H/i/s");//or $xlsTitle文件名称可根据自己情况设定
    	$cellNum=count($xlsCellName);		//列数
    	$dataNum=count($xlsTableData);		//数据条数
    	Vendor('Classes.PHPExcel');			//导入Vendor/Classes下的PHPExcel.php
    	$objPHPExcel = new \PHPExcel();		//实例化一个处理对象
    	//合并单元格
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
    	$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
    	$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
    	//设置当前活动sheet的名称
    	$objPHPExcel->getActiveSheet()->setTitle('自定义查询结果');
    	//填入主标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A2','河南梧桐盛嘉投资管理有限公司');
    	//填入副标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A3','-------------------微风投项目资料审核表-------------------');
    	//Excel底部文字
    	$objPHPExcel->getActiveSheet()->setCellValue('A10','—————————————————————————————————————————————————————');
    	$objPHPExcel->getActiveSheet()->setCellValue('A11','导出时间：['.date('Y-m-d H:m:s').']');
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
    	// 设置行高
    	$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
    	$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(150);
    	$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(150);
    	$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(150);
    	$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(150);
    	$objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(150);
    	$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(150);
    	//设置字体样式
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('黑体');
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(16);
    	//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	//数据填充
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A4, '法人身份证正面：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A5, '法人身份证反面：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A6, '法人证信报告：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A7, '营业执照副本：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A8, '税务登记证副本：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A9, '公司照片：');
    	$objDrawing1 = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing1->setName('fornt');
    	$objDrawing1->setDescription('fornt');
    	$objDrawing1->setPath('./Uploads/Company/'.$xlsTableData[fornt]);
    	$objDrawing1->setCoordinates('B4');
    	$objDrawing1->setWidth(95);
    	$objDrawing1->setHeight(84);
    	$objDrawing1->setWorksheet($objPHPExcel->getActiveSheet());
    	$objDrawing2 = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing2->setName('rear');
    	$objDrawing2->setDescription('rear');
    	$objDrawing2->setPath('./Uploads/Company/'.$xlsTableData[rear]);
    	$objDrawing2->setCoordinates('B5');
    	$objDrawing2->setWidth(95);
    	$objDrawing2->setHeight(84);
    	$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());
    	$objDrawing3 = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing3->setName('legalperson');
    	$objDrawing3->setDescription('legalperson');
    	$objDrawing3->setPath('./Uploads/Company/'.$xlsTableData[legalperson]);
    	$objDrawing3->setCoordinates('B6');
    	$objDrawing3->setWidth(95);
    	$objDrawing3->setHeight(84);
    	$objDrawing3->setWorksheet($objPHPExcel->getActiveSheet());
    	$objDrawing4 = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing4->setName('businesslicence');
    	$objDrawing4->setDescription('businesslicence');
    	$objDrawing4->setPath('./Uploads/Company/'.$xlsTableData[businesslicence]);
    	$objDrawing4->setCoordinates('B7');
    	$objDrawing4->setWidth(95);
    	$objDrawing4->setHeight(84);
    	$objDrawing4->setWorksheet($objPHPExcel->getActiveSheet());
    	$objDrawing5 = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing5->setName('taxcertificate');
    	$objDrawing5->setDescription('taxcertificate');
    	$objDrawing5->setPath('./Uploads/Company/'.$xlsTableData[taxcertificate]);
    	$objDrawing5->setCoordinates('B8');
    	$objDrawing5->setWidth(95);
    	$objDrawing5->setHeight(84);
    	$objDrawing5->setWorksheet($objPHPExcel->getActiveSheet());
    	$objDrawing6 = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
    	$objDrawing6->setName('companyimg');
    	$objDrawing6->setDescription('companyimg');
    	$objDrawing6->setPath('./Uploads/Company/'.$xlsTableData[companyimg]);
    	$objDrawing6->setCoordinates('B9');
    	$objDrawing6->setWidth(95);
    	$objDrawing6->setHeight(84);
    	$objDrawing6->setWorksheet($objPHPExcel->getActiveSheet());
    	//发送头信息设置
    	header('pragma:public');
    	header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    	header('Content-Disposition: attachment;filename="自定义表('.date('Ymd-His').').xls"');  //日期为文件名后缀
    	$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    	$objWriter->save('php://output');		//直接导出文件
    	exit;
    }
    /**
     * 导出项目融资需求
     */
    public function exportLookover03Excel(){
    	$xlsName  = "Prfinancing";
    	//查询结果
    	$xlsModel = M('Financingneeds');
    	$xlsTableData = $xlsModel->Field('budget,singleinvest,purpose,oldname,privacyset,addinfo')->where("prid = '$_GET[prid]'")->find();
    	$xlsTitle=iconv('utf-8', 'gb2312', $xlsName);//文件名称
    	$fileName=date("Y/m/d/H/i/s");//or $xlsTitle文件名称可根据自己情况设定
    	$cellNum=count($xlsCellName);		//列数
    	$dataNum=count($xlsTableData);		//数据条数
    	Vendor('Classes.PHPExcel');			//导入Vendor/Classes下的PHPExcel.php
    	$objPHPExcel = new \PHPExcel();		//实例化一个处理对象
    	//合并单元格
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
    	$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
    	$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
    	$objPHPExcel->getActiveSheet()->mergeCells('A11:B11');
    	//设置当前活动sheet的名称
    	$objPHPExcel->getActiveSheet()->setTitle('自定义查询结果');
    	//填入主标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A2','河南梧桐盛嘉投资管理有限公司');
    	//填入副标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A3','——————————微风投项目融资需求表——————————');
    	//Excel底部文字
    	$objPHPExcel->getActiveSheet()->setCellValue('A10','————————————————————————————————————————————————');
    	$objPHPExcel->getActiveSheet()->setCellValue('A11','导出时间：['.date('Y-m-d H:m:s').']');
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
    	//设置字体样式
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('黑体');
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(16);
    	//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	//数据填充
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A4, '预融资金额：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A5, '单笔最低投资金额：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A6, '资金用途：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A7, '商业计划书：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A8, '隐私设置：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(A9, '其他信息补充：');
    	$objPHPExcel->getActiveSheet(0)->setCellValue(B4, '￥'.number_format($xlsTableData[budget]));
    	$objPHPExcel->getActiveSheet(0)->setCellValue(B5, '￥'.number_format($xlsTableData[singleinvest]));
    	$objPHPExcel->getActiveSheet(0)->setCellValue(B6, $xlsTableData[purpose]);
    	$objPHPExcel->getActiveSheet(0)->setCellValue(B7, $xlsTableData[oldname]);
    	if($xlsTableData[privacyset]=0){
    		$objPHPExcel->getActiveSheet(0)->setCellValue(B8, '设为隐私');
    	}else if($xlsTableData[privacyset]=1){
    		$objPHPExcel->getActiveSheet(0)->setCellValue(B8, '所有人可见');
    	}
    	$objPHPExcel->getActiveSheet(0)->setCellValue(B9, $xlsTableData[addinfo]);
    	//发送头信息设置
    	header('pragma:public');
    	header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    	header('Content-Disposition: attachment;filename="自定义表('.date('Ymd-His').').xls"');  //日期为文件名后缀
    	$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    	$objWriter->save('php://output');		//直接导出文件
    	exit;
    }
    /**
     * 导出项目图片
     */
    public function exportLookover04Excel(){
    	$xlsName  = "Primages";
    	//查询结果
    	$xlsModel = M('Primages');
    	$xlsTableData = $xlsModel->Field('thumbname')->where("prid = '$_GET[prid]'")->select();
    	$xlsTitle=iconv('utf-8', 'gb2312', $xlsName);//文件名称
    	$fileName=date("Y/m/d/H/i/s");//or $xlsTitle文件名称可根据自己情况设定
    	$cellNum=count($xlsCellName);		//列数
    	$dataNum=count($xlsTableData);		//数据条数
    	Vendor('Classes.PHPExcel');			//导入Vendor/Classes下的PHPExcel.php
    	$objPHPExcel = new \PHPExcel();		//实例化一个处理对象
    	//合并单元格
    	$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
    	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
    	$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
    	$objPHPExcel->getActiveSheet()->mergeCells('A'.($dataNum+4).':B'.($dataNum+4));
    	//设置当前活动sheet的名称
    	$objPHPExcel->getActiveSheet()->setTitle('自定义查询结果');
    	//填入主标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A2','河南梧桐盛嘉投资管理有限公司');
    	//填入副标题
    	$objPHPExcel->getActiveSheet()->setCellValue('A3','——————————微风投项目图片表——————————');
    	//Excel底部文字
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+4),'————————————————————————————————————————————————');
    	$objPHPExcel->getActiveSheet()->setCellValue('A'.($dataNum+5),'导出时间：['.date('Y-m-d H:m:s').']');
    	//设置单元格宽度
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
    	//设置字体样式
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('黑体');
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('宋体');
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(16);
    	//设置水平居中
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getActiveSheet()->getStyle('A'.($dataNum+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	//数据填充
		for($i=0;$i<$dataNum;$i++){
			$objPHPExcel->getActiveSheet(0)->setCellValue(A.($i+4),'项目图片: ');
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+4))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getRowDimension($i+4)->setRowHeight(70);
			$objDrawing = new \PHPExcel_Worksheet_Drawing();/*实例化excel图片处理类*/
			$objDrawing->setName('Primages');
			$objDrawing->setDescription('Primages');
			$objDrawing->setPath('./Uploads/PrImages/'.$xlsTableData[$i][thumbname]);
			$objDrawing->setCoordinates('B'.($i+4).'');
			$objDrawing->setWidth(80);
			$objDrawing->setHeight(60);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		}
    	//发送头信息设置
    	header('pragma:public');
    	header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
    	header('Content-Disposition: attachment;filename="自定义表('.date('Ymd-His').').xls"');  //日期为文件名后缀
    	$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    	$objWriter->save('php://output');		//直接导出文件
    	exit;
    }
    

}
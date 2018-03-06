<?php
namespace Home\Controller;

class CasesController extends BaseController
{
    public function clists()
    {
        $Model = D('cases');
        $where = [];
        $where['_complex'] = $Model->getSearchWhere();
        $count = $Model->where($where)->count();
        $Page       = new \Think\LiPage($count,15);
        $show       = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;

        $order = ' corder desc ';
        $lists = $Model->where($where)->order($order)->limit($limit)->select();

        $assign = array(
            'lists' => $lists,
            'page' => $show
        );
        //dump($Page);die();
        $this->assign($assign);
        $this->display();
    }



    public function cadd()
    {
        $Model = D('category');
        $res = $Model->getList();

        $this->assign('ops',$res);

        $this->display();
    }


    public function uploadImg()
    {
        $res = [ 'code'=>'0' ];
        list($r,$msg) = $this->upload();
        if ( $r != false ) {
            $res['code'] = 1;
            $res['url'] = $msg;
            $res['thumb'] = basename($msg);
        } else {
            $res['msg'] = $msg;
        }
        $this->ajaxReturn($res);
    }

    protected function upload()
    {
        // 前端直接读取upload_dir 根据文件名自动定位到文件
        $upload_dir = C('upload_dir');
        $config = array(
            'maxSize'    =>    3145728,
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'rootPath'   =>    $upload_dir,
            'subName'    =>    date('Y/md'),    //subName会和saveName分开
            'saveName'   =>    date('YmdHis').substr(uniqid(),9,4),
            'autoSub'    =>    true,   //subName会当成文件的前缀文件夹
            //最终保存的结果为: ./rootPath subName/saveName
        );
        if ( !file_exists($upload_dir) ) {
            mkdir($upload_dir,0777,true);
        }

        $upload = new \Think\Upload($config);
        $info   =   $upload->upload(); // 上传所有post文件
        if(!$info) {
            $err = $upload->getError();
            return [false,$err];
        } else { // 上传成功
            $file = $info['pic'];
            $pic = $upload_dir.$file['savepath'].$file['savename']; // 文件路径
            return [true,'/'.$pic];
        }
    }

    public function caseAdd()
    {
        $ret = ['code'=>0];

        $Model = D('cases');
        $res = $Model->caseAdd();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = $res;
        }

        $this->ajaxReturn($ret);
    }

    public function removeCase()
    {
        $ret = ['code'=>0];

        $Model = D('cases');
        $res = $Model->removeCase();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '删除出错,请稍后再试!';
        }
        $this->ajaxReturn($ret);
    }
    public function changeStatus()
    {
        $ret = ['code'=>0];

        $Model = D('cases');
        $res = $Model->changeStatus();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '更新出错,请稍后再试!';
        }

        $this->ajaxReturn($ret);
    }

    public function updateOrder()
    {
        $ret = ['code'=>0];

        $Model = D('cases');
        $res = $Model->updateOrder();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '更新出错,请选择更新行并检查数据后重试!';
        }

        $this->ajaxReturn($ret);
    }

    public function deleteAll()
    {
        $ret = ['code'=>0];

        $Model = D('cases');
        $res = $Model->deleteAll();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '批量删除出错,请选择更新行并检查数据后重试!';
        }

        $this->ajaxReturn($ret);
    }

    public function editCase()
    {
        $id = I('get.id');

        $Cat = D('category');
        $Cases = D('cases');
        $ops = $Cat->getList();
        $items = $Cases->getItems($id);
        $li = $Cases->find($id);
        $assign = [
            'act'=>'cedit',
            'id'=>$id,
            'ops'=>$ops,
            'items'=>$items,
            'li' => $li
        ];
        $this->assign($assign);
        $this->display('cedit');
    }

    public function caseEdit()
    {
        $ret = ['code'=>0];

        $Model = D('cases');
        $res = $Model->caseEdit();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = $res;
        }

        $this->ajaxReturn($ret);
    }

    /*全部案例*/
    public function citems()
    {
        $Model = D('cases');
        $where = [];
        $where['status'] = 1;
        $where['_complex'] = $Model->getSearchWhere();
        $count = $Model->where($where)->count();
        $Page       = new \Think\LiPage($count,15);
        $show       = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;

        $order = ' corder desc ';
        $lists = $Model->where($where)->order($order)->limit($limit)->select();

        $assign = array(
            'lists' => $lists,
            'page' => $show
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 返回前台调用最新案例
     * @return [type] [description]
     */
    public function getCases()
    {
        $data = D('cases')->getCases(3);
        $this->ajaxReturn($data);
    }



}
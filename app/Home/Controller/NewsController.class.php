<?php
namespace Home\Controller;

class NewsController extends BaseController
{
    public function nlists()
    {
        $Model = D('News');
        $where = [];
        $where['ctime'] = $Model->getSearchTime();
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

    public function nadd()
    {
        $this->display();
    }

    public function changeStatus()
    {
        $ret = ['code'=>0];

        $Model = D('news');
        $res = $Model->changeStatus();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '更新出错,请稍后再试!';
        }

        $this->ajaxReturn($ret);
    }

    public function removeNews()
    {
        $ret = ['code'=>0];

        $Model = D('news');
        $res = $Model->removeMews();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '删除出错,请稍后再试!';
        }
        $this->ajaxReturn($ret);
    }

    public function updateOrder()
    {
        $ret = ['code'=>0];

        $Model = D('news');
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

        $Model = D('news');
        $res = $Model->deleteAll();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '批量删除出错,请选择更新行并检查数据后重试!';
        }

        $this->ajaxReturn($ret);
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

    public function newsAdd()
    {
        $ret = ['code'=>0];

        $Model = D('news');
        $res = $Model->newsAdd();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = $res;
        }

        $this->ajaxReturn($ret);
    }

    public function newsEdit()
    {
        $ret = ['code'=>0];

        $Model = D('news');
        $res = $Model->newsEdit();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = $res;
        }

        $this->ajaxReturn($ret);
    }

    public function editNews()
    {
        $id = I('get.id');

        $Model = D('news');
        $li = $Model->find($id);
        $li['content'] = htmlspecialchars_decode($li['content']);
        $assign = [
            'act'=>'nedit',
            'id'=>$id,
            'li' => $li
        ];
        $this->assign($assign);
        $this->display('nedit');
    }

    public function viewNews()
    {
        $ret = ['code'=>0];
        $Model = D('News');
        $id = I('post.id');
        if ( $news = $Model->find($id) ) {
            $ret['code'] = 1;
            $ret['content'] = htmlspecialchars_decode($news['content']);
        } else {
            $ret['code'] = 0;
        }
        $this->ajaxReturn($ret);
    }

    public function refreshNews()
    {
        $Model = D('News');
        $id = I('post.id');
        $where = array('status'=>1,'id'=>$id);
        if ( $t = $Model->where($where)->find()  ) {
            $Model->updateOnePage($id);
        } else {
            $Model->deleteOnePage($id);
        }
        $this->ajaxReturn(['code'=>1]);
    }


    // 前台调用方法
    /**
     * 返回前台调用最新新闻
     * @return [type] [description]
     */
    public function getNews()
    {
        $Model = D('news');
        $news = $Model->getNextNews(1);
        var_dump($news);
        dump(json_encode($news));
    }



}
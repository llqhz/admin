<?php
namespace Home\Controller;

class UserController extends BaseController
{
    public function ulists()
    {
        $Model = D('User');

        $where = [];
        //$where['_complex'] = $Model->getSearchWhere();
        $count = $Model->where($where)->count();
        $Page       = new \Think\LiPage($count,15);
        $show       = $Page->show();// 分页显示输出
        $limit = $Page->firstRow.','.$Page->listRows;

        $order = 'ctime asc';
        $lists = $Model->where($where)->order($order)->limit($limit)->select();

        $assign = array(
            'lists' => $lists,
            'page' => $show
        );
        //dump($Page);die();
        $this->assign($assign);
        $this->display();
    }

    public function uadd()
    {
        $this->display();
    }
}
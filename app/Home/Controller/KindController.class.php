<?php
namespace Home\Controller;

class KindController extends BaseController
{
    public function kcategory()
    {

        $Model = D('Category');
        $tree = $Model->getList();

        $this->assign('tree',$tree);
        $this->display();
    }

    public function kcateadd()
    {
        $Model = D('Category');
        $res = $Model->getOps();

        $this->assign('ops',$res);

        $this->display();
    }

    public function add()
    {
        $ret = ['code'=>0];

        $Model = D('Category');
        $res = $Model->cateAdd();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = $res;
        }

        $this->ajaxReturn($ret);
    }

    public function changeStatus()
    {
        $ret = ['code'=>0];

        $Model = D('Category');
        $res = $Model->changeStatus();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '更新出错,请稍后再试!';
        }

        $this->ajaxReturn($ret);

    }

    public function removeKind()
    {
        $ret = ['code'=>0];

        $Model = D('Category');
        $res = $Model->removeKind();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '删除出错,请稍后再试!';
        }

        $this->ajaxReturn($ret);
    }

    public function editKind()
    {
        $id = I('get.id');

        $Model = D('Category');
        $ops = $Model->getOps();
        $item = $Model->getItem($id);
        $parentId = $Model->getParentId($id);
        $assign = [
            'act'=>'kedit',
            'id'=>$id,
            'ops'=>$ops,
            't'=>$item,
            'parentId'=>$parentId
        ];
        $this->assign($assign);
        $this->display('kcateedit');
    }

    public function updateOrder()
    {
        $ret = ['code'=>0];

        $Model = D('Category');
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

        $Model = D('Category');
        $res = $Model->deleteAll();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = '批量删除出错,请选择更新行并检查数据后重试!';
        }

        $this->ajaxReturn($ret);
    }

    public function edit()
    {
        $ret = ['code'=>0];

        $Model = D('Category');
        $res = $Model->cateEdit();
        if ( $res === true ) {
            $ret['code'] = 1;
        } else {
            $ret['msg'] = $res;
        }

        $this->ajaxReturn($ret);
    }

    public function getJson()
    {
        $json = D('Category')->getJson();
        $this->ajaxReturn($json);
    }

}
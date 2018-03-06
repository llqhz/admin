<?php
/**
 * @Author: Marte
 * @Date:   2018-02-25 11:12:31
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-02-28 17:19:27
 */
namespace Home\Model;
use Think\Model;

class CategoryModel extends Model
{

    protected $patchValidate = true; //批量验证
    protected $_validate = array(
        array('name','require','分类名必填！'), //默认情况下用正则进行验证
        array('parentId','/^\d{1,5}$/','父级分类Id为1-5位数字',1,'regex'), //默认情况下用正则进行验证
        array('detail','require','请填入分类描述',1), //默认情况下用正则进行验证
        array('corder','/^\d{1,5}$/','排序号必须为1-5位数字',1,'regex'), //默认情况下用正则进行验证
   );


    public function getTree($id=1)
    {
        // 没有根节点 获取分类列表
        $where = 'concat(",",path) like "%,'.$id.',%"';
        $order = 'corder desc';
        $res = $this->where($where)->order($order)->select();
        return $res;
    }

    protected function getKindName($id='')
    {
        $t = $this->where(['id'=>$id])->find();
        return $t['name'];
    }
    public function getItem($id='')
    {
        $t = $this->where(['id'=>$id])->find();
        return $t;
    }
    public function getParentId($id='')
    {
        $t = $this->where(['id'=>$id])->find();
        $arr = explode(',',$t['path']);
        array_pop($arr);
        $parentId = array_pop($arr);
        return $parentId;
    }

    // 没有顶级分类
    public function getList()
    {
        $data = $this->getTree();
        foreach ($data as $k => $v) {
            $arr = explode(',',$v['path']);
            if ( count($arr) <= 2 ) {
                $firstId = $arr[0];
            } else {
                $firstId = $arr[1];
            }
            $data[$k]['prekind'] = $this->getKindName($firstId);
            $data[$k]['name'] = (($v['level']-1)>0?'|':'').str_repeat('—',$v['level']-1).$v['name'];
        }
        return $data;
    }

    // select 选项 有顶级分类
    public function getOps($id=1)
    {
        // 含有根节点 获取添加分类的opptions
        $top = array(
                'id' => '1',
                'name'    => '顶级分类',
                'path'    => '1',
                'level'   => 0
            );
        $ops = $this->getList();
        array_unshift($ops,$top);
        return $ops;
    }

    public function getOps2($id=1)
    {
        // 含有根节点 获取添加分类的opptions
        $where = 'concat(",",path,",") like "%,'.$id.',%"';
        $order = 'corder desc';
        $res = $this->where($where)->order($order)->select();
        foreach ($res as $k => $v) {
            $res[$k]['name'] = ($v['level']?'|':'').str_repeat('—',$v['level']).$v['name'];
        }
        return $res;
    }

    public function cateAdd()
    {
        if ( !$this->create($_POST,1) ) {
            return $this->getError();
        }
        $name = I('post.name');
        $parentId = I('post.parentId');
        $detail = I('post.detail');
        $corder = I('post.corder');

        $r = $this->where(['id'=>$parentId,'status'=>1])->find();
        if ( !$r ) {
            // parentId 不存在
            return ['parentId'=>'父级分类不存在!'];
        }

        $sql = "SELECT auto_increment as inc FROM information_schema.`TABLES` WHERE TABLE_SCHEMA='".C('DB_NAME')."' AND TABLE_NAME='__CATEGORY__'";
        $insertId = $this->query($sql);
        $insertId = $insertId[0]['inc'];
        $path = $r['path'].','.$insertId;

        $level = count(explode(',',$path)) - 1;

        $data = array(
            'name' => $name,
            'detail' => $detail,
            'path' => $path,
            'corder' => $corder,
            'level' => $level,
            'statuc' => 0 // 初始分类为0
        );

        if ( $this->data($data)->add() ) {
            return true;
        } else {
            return ['msg'=>'添加出错,请稍后再试!'];
        }
    }

    public function changeStatus()
    {
        $id = I('post.id');
        $t = $this->where(['id'=>$id])->find();
        if ( $t ) {
            if ( $t['status'] == 0 ) {
                $status = 1;
            } else {
                $status = 0;
            }
            $this->where(['id'=>$id])->setField('status',$status);
            return true;
        }
        return false;
    }

    public function removeKind()
    {
        $id = I('post.id');
        $t = $this->where(['id'=>$id])->find();
        if ( $t ) {
            $path = $t['path'];
            $this->where(['path'=>['like',$path]])->delete();
            return true;
        }
        return false;
    }

    public function updateOrder()
    {
        $ids = I('post.ids');
        $ods = I('post.ods');
        if ( (!is_array($ids)) || (!is_array($ods)) ) {
            return false;
        }
        if ( count($ids) != count($ods) ) {
            return false;
        }
        $this->startTrans();
        $flag = true;
        foreach ($ids as $k => $v) {
            if ( (!is_numeric($ods[$k])) || (!is_numeric($v)) ) {
                return false;
            }
            $r = $this->where(['id'=>$v])->save(['corder'=>$ods[$k]]);
            if ( $r === false ) {
                $flag = false;
                break;
            }
        }
        if ( $flag ) {
            $this->commit();
        } else {
            $this->rollback();
        }
        return $flag;

    }

    public function deleteAll()
    {
        $ids = I('post.ids');
        if ( !is_array($ids) ) {
            return false;
        }
        $this->startTrans();
        $flag = true;
        foreach ($ids as $k => $v) {
            if ( !is_numeric($v) ) {
                $flag = false;break;
            }
            $r = $this->where(['id'=>$v])->delete();
            if ( $r === false ) {
                $flag = false;
                break;
            }
        }
        if ( $flag ) {
            $this->commit();
        } else {
            $this->rollback();
        }
        return $flag;
    }


    protected function updateChildrenKind($oldpath,$newpath)
    {
        if ( $oldpath == $newpath ) {
            return true;
        }
        $sql = "update __CATEGORY__ set path = concat('".$newpath."',id) where path like ".$oldpath;
        $this->execute($sql);
    }

    public function cateEdit()
    {
        if ( !$this->create($_POST,1) ) {
            return $this->getError();
        }
        $id = I('post.id');
        $name = I('post.name');
        $parentId = I('post.parentId');
        $detail = I('post.detail');
        $corder = I('post.corder');

        $p = $this->where(['id'=>$parentId,'status'=>1])->find();
        if ( !$p ) {
            // parentId 不存在
            return ['parentId'=>'父级分类不存在!'];
        }
        $r = $this->where(['id'=>$id,'status'=>1])->find();

        $oldpath = $r['path'];
        $newpath = $p['path'].','.$id;
        $this->updateChildrenKind($oldpath,$newpath);

        $level = count(explode(',',$newpath)) - 1;

        $data = array(
            'id' => $id,
            'name' => $name,
            'detail' => $detail,
            'path' => $newpath,
            'corder' => $corder,
            'level' => $level,
        );

        if ( $this->data($data)->save() ) {
            return true;
        } else {
            return $data;
            return ['msg'=>'修改出错,请检查信息稍后再试!'];
        }
    }

    /**
     * 返回前台调用的分类json
     * @return [type] [description]
     */
    public function getJson()
    {
        return $this->getJsonTree();
    }

    /**
     * 根据数据库数据arr,生成api json数组
     * @param  integer $lv [description]
     * @return [type]      [description]
     */
    public function getJsonTree($lv=0,$id=1)  // 父级元素标识
    {
        static $arr;
        if ( empty($arr) ) {
            $arr = $this->getTree();
        }
        $tree = array();
        foreach ($arr as $k => $v) {
            if ( $v['level']==($lv+1) ) {  // 只需处理直接的下一级
                // 获取当前元素pid
                preg_match_all("/^[\s\S]*,(\d+),\d+$/",','.$v['path'],$match);
                $pid = $match[1][0];
                if ( $pid != $id ) {
                    continue;     // 只需本parent的直接下一级
                }
                $item = array();
                $item['id'] = $v['id'];
                $item['title'] = $v['name'];
                $child = $this->getJsonTree($lv+1,$v['id']);
                if ( !empty($child) ) {
                    $item['child'] = $child;
                }
                $tree[] = $item;
            }
        }
        return $tree;
    }

    public function getKindsName($kinds='')
    {
        $res = [];
        $kinds = explode(',',$kinds);
        foreach ($kinds as $k => $v) {
            $res[] = $this->getKindName($v);
        }
        return $res;
    }

}
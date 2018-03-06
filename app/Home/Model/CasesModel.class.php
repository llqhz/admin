<?php
/**
 * @Author: Marte
 * @Date:   2018-02-25 11:12:31
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-03-05 09:53:35
 */
namespace Home\Model;
use Think\Model;

class CasesModel extends Model
{

    protected $patchValidate = true; //批量验证
    protected $_validate = array(
        array('title','require','案例标题必填！'), //默认情况下用正则进行验证
        array('thumb','require','案例图片必填！'), //默认情况下用正则进行验证
        array('detail','require','请填入案例描述',1), //默认情况下用正则进行验证
        array('corder','/^\d{1,5}$/','排序号必须为1-5位数字',1,'regex'), //默认情况下用正则进行验证
   );


    public function caseAdd()
    {
        if ( !$this->create($_POST,1) ) {
            return $this->getError();
        }
        $title = I('post.title');
        $parentId = I('post.parentId');
        $parentId = implode(',',$parentId);
        $detail = I('post.detail');
        $img = I('post.thumb');
        $link = I('post.link');
        $corder = I('post.corder');

        $data = array(
            'title' => $title,
            'detail' => $detail,
            'kind' => $parentId,
            'corder' => $corder,
            'link' => $link,
            'img' => $img,
            'ctime' => time(),
            'status' => 0 // 初始分类为0
        );

        if ( $this->data($data)->add() ) {
            return true;
        } else {
            return ['msg'=>'添加出错,请稍后再试!'];
        }
    }

    public function removeCase()
    {
        $id = I('post.id');
        $t = $this->where(['id'=>$id])->find();
        if ( $t ) {
            $this->where(['id'=>$id])->delete();
            return true;
        }
        return false;
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


    public function getItems($id)
    {
        $t = $this->where(['id'=>$id])->find();
        $kinds = explode(',',$t['kind']);
        return $kinds;
    }

    // 编辑案例
    public function caseEdit()
    {
        if ( !$this->create($_POST,1) ) {
            return $this->getError();
        }
        $id = I('post.id');
        $title = I('post.title');
        $parentId = I('post.parentId');
        $parentId = implode(',',$parentId);
        $detail = I('post.detail');
        $img = I('post.thumb');
        $link = I('post.link');
        $corder = I('post.corder');

        $data = array(
            'id' => $id,
            'title' => $title,
            'detail' => $detail,
            'kind' => $parentId,
            'corder' => $corder,
            'link' => $link,
            'img' => $img,
            'status' => 0 // 初始分类为0
        );

        if ( $this->data($data)->save() ) {
            return true;
        } else {
            return ['msg'=>'修改出错,请稍后再试!'];
        }
    }

    /**
     * 返回前台调用的cases Json
     * @param  boolean $limit [description]
     * @return [type]         [description]
     */
    public function getCases($limit=3)
    {
        $filed = 'id,title,ctime,detail as "desc",img as imgUrl,link as caseUrl';
        $where = ['status'=>1];
        $order = ' corder desc ';
        $res = $this->field($filed)->where($where)->order($order)->limit($limit)->select();
        foreach ($res as $key => $val) {
            $res[$key] = $this->transFieldsName($val);
        }
        return $res;
    }

    public function transFieldsName($row)
    {
        $row['imgUrl'] = getImgPath($row['imgurl']);
        $row['caseUrl'] = $row['caseurl'];
        unset($row['imgurl']);
        unset($row['caseurl']);
        return $row;
    }

    public function getNextCases($id,$limit=6)
    {
        $item = $this->find($id);
        $where['corder'] = ['elt',$item['corder']];
        $where['id'] = ['neq',$item['id']];
        $data = $this->where($where)->limit($limit)->select();
        foreach ($data as $k => $v) {
            $data[$k] = $this->transFieldsName($v);
        }
        return $data;
    }

    /**
     * 获取模糊搜索where
     * @return [type] [description]
     */
    public function getSearchWhere()
    {
        $where = [];
        $word = I('get.word');
        if ( empty($word) ) {
            return ['1'=>'1'];
        }
        $where['title']  = array('like', '%'.$word.'%');
        $where['detail']  = array('like','%'.$word.'%');
        $kindIds = $this->getIdsFromKind($word);
        if ( !empty($kindIds) ) {
            $where["concat(',',kind,',')"] = array('like', $kindIds, 'or');
        }
        $where['_logic'] = 'or';
        return $where;
    }

    public function getIdsFromKind($word='')
    {
        // 找到分类的id数组
        $Cat = D('category');
        $where = [];
        $where['name'] = array('like', '%'.$word.'%');
        $kinds = $Cat->where($where)->select();
        $kindIds = [];
        foreach ($kinds as $k => $v) {
            $kindIds[] = '%,'.$v['id'].",%";
        }
        return $kindIds;
    }

    /**
     * 前台根据分类Id搜索
     * @param  string $kindId [description]
     * @return [type]         [description]
     */
    public function getCasesByKindId($kindId='')
    {
        $where = [];
        $where['status'] = 1;
        $order = ' corder desc ';
        $filed = 'id,title,detail as "desc",img as imgUrl,link as caseUrl';
        $where["concat(',',kind,',')"] = array('like', '%,'.$kindId.",%");
        $data = $this->field($filed)->where($where)->order($order)->select();
        foreach ($data as $key => $val) {
            $data[$key] = $this->transFieldsName($val);
        }
        return $data;
    }



}
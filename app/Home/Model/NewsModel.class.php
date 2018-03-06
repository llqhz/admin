<?php
/**
 * @Author: Marte
 * @Date:   2018-02-25 11:12:31
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-03-05 16:19:46
 */
namespace Home\Model;
use Think\Model;

class NewsModel extends Model
{

    protected $patchValidate = true; //批量验证
    protected $_validate = array(
        array('title','require','新闻标题必填！'), //默认情况下用正则进行验证
        array('thumb','require','新闻图片必填！'), //默认情况下用正则进行验证
        array('detail','require','请填入新闻简介',1), //默认情况下用正则进行验证
        array('corder','/^\d{1,5}$/','排序号必须为1-5位数字',1,'regex'), //默认情况下用正则进行验证
   );


    /**
     * 获取模糊搜索where
     * @return [type] [description]
     */
    public function getSearchWhere()
    {
        $where = [];
        $word = I('get.word');
        if ( empty($word) || $word == '__WORD__' ) {
            $where['_string'] = " '1' = '1' ";
        } else {
            $where['title']  = array('like', '%'.$word.'%');
            $where['detail']  = array('like','%'.$word.'%');
            $where['_logic'] = 'or';
        }
        return $where;
    }
    public function getSearchTime()
    {
        $t_s = I('get.t_s');
        $t_s = rtrim($t_s,'000');
        $t_e = I('get.t_e');
        $t_e = rtrim($t_e,'000');
        if ( !empty($t_s) && !empty($t_e) ) {
            return ['between',array($t_s,$t_e)];
        }
        if ( !empty($t_s) && empty($t_e) ) { //>$t_s
            return ['egt',$t_s];
        }
        if ( !empty($t_e) && empty($t_s) ) {
            return ['elt',$t_e];
        }
        return ['egt',0];
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

    public function removeMews()
    {
        $id = I('post.id');
        $t = $this->where(['id'=>$id])->find();
        $this->deleteOnePage($id);
        if ( $t ) {
            $this->where(['id'=>$id])->delete();
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

    public function newsAdd()
    {
        if ( !$this->create($_POST,1) ) {
            return $this->getError();
        }
        $title = I('post.title');
        $detail = I('post.detail');
        $img = I('post.thumb');
        $content = I('post.content');
        $corder = I('post.corder');

        $data = array(
            'title' => $title,
            'detail' => $detail,
            'kind' => $parentId,
            'corder' => $corder,
            'content' => $content,
            'img' => $img,
            'ctime' => time(),
            'status' => 0 // 初始状态为0
        );

        if ( $this->data($data)->add() ) {
            return true;
        } else {
            return ['msg'=>'添加出错,请稍后再试!'];
        }
    }

    public function newsEdit()
    {
        if ( !$this->create($_POST,1) ) {
            return $this->getError();
        }
        $id = I('post.id');
        $title = I('post.title');
        $detail = I('post.detail');
        $img = I('post.thumb');
        $content = I('post.content');
        $corder = I('post.corder');

        $data = array(
            'id' => $id,
            'title' => $title,
            'detail' => $detail,
            'kind' => $parentId,
            'corder' => $corder,
            'content' => $content,
            'img' => $img,
        );

        if ( $this->data($data)->save() ) {
            return true;
        } else {
            return ['msg'=>'修改出错,请稍后再试!'];
        }
    }

    // 前台调用方法
    public function getNews($limit=2)
    {
        $where = 'status = 1';
        $order = 'corder desc, ctime desc ';
        $field = ' id,title,detail as "desc",img,ctime as time';
        $data = $this->field($field)->where($where)->limit($limit)->select();
        foreach ($data as $k => $v) {
            $data[$k] = $this->transRows($v);
        }
        return $data;
    }

    public function transRows($row)
    {
        $row['imgUrl'] = getImgPath($row['img']);
        $row['detailUrl'] = $this->getNewsUrl($id);
        $row['time'] = date('Y年m月d日');
        unset($row['detail']);
        unset($row['img']);
        return $row;
    }

    public function getNewsUrl($id)
    {
        $news_dir = C('news_dir');
        return $news_dir.$id.'.html';
    }

    /**
     * 加载更多支持 获取后面的几条内容
     * @param  [type]  $id    [description]
     * @param  integer $limit [description]
     * @return [type]         [description]
     */
    public function getNextNews($id,$limit=4)
    {
        $item = $this->find($id);
        $where['status'] = 1;
        //$where['ctime'] = ['lt',$item['ctime']];
        $where['corder'] = ['elt',$item['corder']];
        $field = 'id,title,detail as "desc",img,ctime as time';
        $res = $this->field($field)->where($where)->limit($limit)->select();
        foreach ($res as $k => $v) {
            $res[$k] = $this->transRows($v);
            if ( $res[$k]['id'] == $id ) {
                unset($res[$k]);
            }
        }
        $res = array_merge($res);
        return $res;
    }

    /**
     * 更新一条新闻页面
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function updateOnePage($id='')
    {
        $news = $this->where(['status'=>1,'id'=>$id])->find();
        $lists = $this->getNextNews($id);
        $data = ['news'=>$news];
        $news_dir = C('news_dir');
        $file = $news_dir.$id.'.js';
        $json = json_encode($data,JSON_UNESCAPED_UNICODE);
        $json+= 'var data = ';
        $t = file_put_contents($file,$json);
        if ( $t !== false ) {
            return true;
        }
        return false;
    }

    public function deleteOnePage($id='')
    {
        $news_dir = C('news_dir');
        $file = $news_dir.$id.'.js';
        unlink($file);
    }

    public function updateNewsDetailAll()
    {
        $news_dir = C('news_dir');
        if ( !is_dir($news_dir) ) {
            mkdir($news_dir,0777,true);
        }
        $where['status'] = 1;
        $field = 'id';
        $res = $this->field($field)->where($where)->select();
        $ids = [];
        foreach ($res as $key => $val) {
            $id = $val['id'];
            $this->updateOnePage($id);
        }
        return true;
    }

    public function updateNewsNexts($id='')
    {
        $news_dir = C('news_dir');
        $file = $news_dir.'next/'.$id.'.json';

        $data = $this->getNextNews($id);
        $json = json_encode($data,JSON_UNESCAPED_UNICODE);
        file_put_contents($file,$json);
    }



}
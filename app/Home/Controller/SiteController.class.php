<?php
namespace Home\Controller;

class SiteController extends BaseController
{
    public function _initialize()
    {
        $this->data_dir = C('data_dir');
        if ( !is_dir($data_dir) ) {
            mkdir($this->data_dir,0777,true);
        }
    }


    public function sload()
    {
        $Cases = D('cases');
        $News = D('News');
        $lnews = $News->getNews(2);
        $lcases = $Cases->getCases(3);

        $news = $News->getNews(10);
        $cases = $Cases->getCases(9);
        $ids = $News->where('status=1')->order('corder desc')->getField('id',true);

        $assign = [
            'lnews' => $lnews,
            'lcases' => $lcases,
            'news' => $news,
            'cases' => $cases,
            'ids' => $ids,
        ];

        /*dump($assign);
        die();*/
        $this->assign($assign);
        $this->display();
    }

    public function uadd()
    {
        $this->display();
    }

    /**
     * 更新首页
     * @return [type] [description]
     */
    public function updateIndex()
    {

        $ret = ['code'=>0];
        $Case = D('Cases');
        $News = D('News');

        $cases = $Case->getCases();
        $news = $News->getNews();

        $data = array(
                'news' => $news,
                'cases' => $cases
            );
        $json = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $jsonp = 'var data = '.$json;
        $file = $this->data_dir.'index_data.js';
        $t = file_put_contents($file,$jsonp);
        if ( $t !== false ) {
            $ret['code'] = 1;
        }
        $this->ajaxReturn($ret);
    }

    public function updateNews()
    {
        $ret = ['code'=>0];
        $News = D('News');

        $news = $News->getNews(5);

        $data = array(
                'news' => $news,
            );
        $json = json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $jsonp = 'var data = '.$json;
        $file = $this->data_dir.'news_index.js';
        $t = file_put_contents($file,$jsonp);
        if ( $t !== false ) {
            $ret['code'] = 1;
        }
        $this->ajaxReturn($ret);
    }

    public function updateCases()
    {
        $ret = ['code'=>0];
        $Case = D('Cases');

        $cases = $Case->getCases(9);

        $json = json_encode($cases,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $jsonp = 'var caseData = '.$json;
        $file = $this->data_dir.'cases_index.js';
        $t = file_put_contents($file,$jsonp);
        if ( $t !== false ) {
            $ret['code'] = 1;
        }
        $this->ajaxReturn($ret);
    }

    public function updateNewsNexts()
    {
        $news_dir = C('news_dir');
        $next_dir = $news_dir.'next/';
        if ( is_dir($next_dir) ) {
            unlink($next_dir);
        }
        mkdir($next_dir,0777,true);

        $Model = D('News');
        $where['status'] = 1;
        $field = 'id';
        $res = $Model->field($field)->where($where)->select();
        foreach ($res as $key => $val) {
            $id = $val['id'];
            $Model->updateNewsNexts($id);
        }
        $this->ajaxReturn(['code'=>1]);

    }











}
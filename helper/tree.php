<?php


namespace app\helper;

class tree  {

	public $arr = array();
	public $icon = array('│','├','└');
	public $nbsp = "&nbsp;";
	public $ret = '';
	public $level = 0;

    public function __construct($arr=array()) {
         $this->arr = $arr;
	     $this->ret = '';
	     return is_array($arr);
    }
	public function getchild($bid){
		$a = $newarr = array();
		if(is_array($this->arr)){
			foreach($this->arr as $id => $a){
				if($a['parentId'] == $bid) $newarr[$id] = $a;
			}
		}
		return $newarr ? $newarr : false;
	}

	function get_tree($bid, $str, $sid = 0, $adds = '', $strgroup = ''){
		$number=1;
		$child = $this->getchild($bid);
		if(is_array($child)){
		    $total = count($child);
			foreach($child as $id=>$a){
				$j=$k='';
				if($number==$total){
					$j .= $this->icon[2];
				}else{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';

                @extract($a);
				if(empty($a['selected'])){$selected = $id==$sid ? 'selected' : '';}
                if(!isset($parentid)){
                    $parentid=0;
                }
                if(!isset($newstr)){
                    $newstr="";
                }
				$parentid == 0 && $strgroup ? eval("\$newstr = \"$strgroup\";") : eval("\$newstr = \"$str\";");

				$this->ret .= $newstr;
				$nbsp = $this->nbsp;
				$this->get_tree($id, $str, $sid, $adds.$k.$nbsp,$strgroup);
				$number++;
			}
		}
		return $this->ret;
	}

    public function getTree($cates, $pid = 0)
    {
        $tree = [];
        foreach($cates as $cate) {
            if ($cate['parentid'] == $pid) {
                $tree[] = $cate;
                $tree = array_merge($tree, $this->getTree($cates, $cate['id']));
            }
        }
        return $tree;
    }


    public function setPrefix($data, $p = "├─")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key - 1]['parentid'] != $val['parentid']) {
                    $num ++;
                }
            }
            if (array_key_exists($val['parentid'], $prefix)) {
                $num = $prefix[$val['parentid']];
            }

            if((count($data)-1)==$key){
                $val['title'] = str_repeat($p, ($num-1))."└─".$val['title'];
            }else{
                $val['title'] = str_repeat($p, $num).$val['title'];
            }

            $prefix[$val['parentid']] = $num;


            $tree[] = $val;

            next($data);
        }
        return $tree;
    }

}
?>
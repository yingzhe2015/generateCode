<?php
namespace app\index\controller;

class Index extends Base
{    
    public function index()
    {        
        return view();
    }
    
    public function page_model_step1(){
        $tables = $this->tables();//print_r($tables);        
        $this->assign('tables',$tables);
        return view();
    }
    
    public function page_model_step2($table,$autotimpspan='',$softdelete=''){
        if($table==''){
            $this->error('缺少表');
            return;
        }
        //$table=input('get.table');
        //$autotimpspan=input('get.autotimpspan');
        //$softdelete=input('get.softdelete');
        
        //$tbs = $this->tables();
        //$this->assign('tables',$tbs);
        
        if($table!=''){
            
            $cls = $this->columns($table);
            $istimestartfiled = false;
            $istimeendfiled = false;
            $istimefiled = false;
            $issoftdelete = false;
            $msg = '';
            
            foreach ($cls as $c){
                if($c=='create_time')
                    $istimestartfiled= true;
                if($c=='update_time')
                    $istimeendfiled= true;
                if($c=='delete_time')
                    $issoftdelete = true;
            }
            
            if($autotimpspan=='on'){
                if($istimeendfiled&&$istimeendfiled){
                    $istimefiled=true;
                    $this->assign('autotime',$istimefiled);
                }else
                    $msg='表'.$table.'缺少字段：默认创建时间字段为create_time，更新时间字段为update_time，默认识别为整型int类型';
            }
            
            if($softdelete=='on'){
                if($issoftdelete)
                    $this->assign('softdelete',$softdelete);
                else
                    $msg.='<br>表'.$table.'缺少字段：软删除的默认字段为 delete_time，可根据实际情况在代码中修改';
            }
            
            $this->assign('msg',$msg);
        }
                
        return view();
    }
    
    public function page_controller_step1(){
    
        $table=input('get.table');
        
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        
        if($table!=''){
        
            $cls = $this->columns($table);
            
            
        }
        
        return view();
    }
    
    public function page_controller_step2($table){

        $key ='';
        $wheresql = '';
        if($table!=''){
    
            $cls = $this->columns($table);//print_r($cls);exit;
            foreach ($cls as $c){
                if($c['Key']=='PRI')
                    $key = $c['Field'];
                if(strstr($c['Type'],'varchar')!=''){
                    $wheresql.=" and ".$c['Field']." like binary '%\$keyword%' ";
                }
            }
            
        }
        $this->assign('wheresql',$wheresql);
        $this->assign('tb',$table);
        $this->assign('key',$key);
        return view();
    }
    
    public function page_validata_step1(){
        $table=input('get.table');
        
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        
        if($table!=''){
            $cls = $this->columns($table);
        }
        return view();
    }
    
    public function page_validata_step2($table){
        
        if($table!=''){
        
            $cls = $this->columns($table);//print_r($cls);
            $this->assign('cls',$cls);
        
        }
        return view();
    }
    
    public function page_validata_step3(){
        
        $vals=input('post.');
        $cls = $this->columns($vals['table']); //print_r($cls);exit;
        //print_r($vals);exit;
        
        $rs = array();
        $ms = array();
        
        //for($i=0;$i<count($vals);$i++){
        //    $v=$vals[$i];
            for($k=0;$k<count($cls);$k++){
                $c = $cls[$k]['Field'];
                if(isset($vals[$c.'_'.'require'])){
                    if($vals[$c.'_'.'require']=='on'){
                        $rs[$c][]='require';
                        $ms[$c.'.require']=$this->_getf($cls[$k]).'必填';
                    }
                }
                if(isset($vals[$c.'_'.'number'])){
                    if($vals[$c.'_'.'number']=='on'){
                        $rs[$c][]='number';
                        $ms[$c.'.number']=$this->_getf($cls[$k]).'为数值';
                    }
                }
                if(isset($vals[$c.'_'.'float'])){
                    if($vals[$c.'_'.'float']=='on'){
                        $rs[$c][]='float';
                        $ms[$c.'.float']=$this->_getf($cls[$k]).'为小数';
                    }
                }
                if(isset($vals[$c.'_'.'boolean'])){
                    if($vals[$c.'_'.'boolean']=='on'){
                        $rs[$c][]='boolean';
                        $ms[$c.'.boolean']=$this->_getf($cls[$k]).'为布尔';
                    }
                }
                if(isset($vals[$c.'_'.'email'])){
                    if($vals[$c.'_'.'email']=='on'){
                        $rs[$c][]='email';
                        $ms[$c.'.email']=$this->_getf($cls[$k]).'为EMAIL';
                    }
                }
                if(isset($vals[$c.'_'.'accepted'])){
                    if($vals[$c.'_'.'accepted']=='on'){
                        $rs[$c][]='accepted';
                        $ms[$c.'.accepted']=$this->_getf($cls[$k]).'为yes/on';
                    }
                }
                if(isset($vals[$c.'_'.'date'])){
                    if($vals[$c.'_'.'date']=='on'){
                        $rs[$c][]='date';
                        $ms[$c.'.date']=$this->_getf($cls[$k]).'为日期';
                    }
                }
                if(isset($vals[$c.'_'.'alpha'])){
                    if($vals[$c.'_'.'alpha']=='on'){
                        $rs[$c][]='alpha';
                        $ms[$c.'.alpha']=$this->_getf($cls[$k]).'为字母';
                    }
                }
                if(isset($vals[$c.'_'.'array'])){
                    if($vals[$c.'_'.'array']=='on'){
                        $rs[$c][]='array';
                        $ms[$c.'.array']=$this->_getf($cls[$k]).'为数组';
                    }
                }
                if(isset($vals[$c.'_'.'alphaNum'])){
                    if($vals[$c.'_'.'alphaNum']=='on'){
                        $rs[$c][]='alphaNum';
                        $ms[$c.'.alphaNum']=$this->_getf($cls[$k]).'为字母数字';
                    }
                }
                if(isset($vals[$c.'_'.'alphaDash'])){
                    if($vals[$c.'_'.'alphaDash']=='on'){
                        $rs[$c][]='alphaDash';
                        $ms[$c.'.alphaDash']=$this->_getf($cls[$k]).'为字母数字—_';
                    }
                }
                if(isset($vals[$c.'_'.'activeUrl'])){
                    if($vals[$c.'_'.'activeUrl']=='on'){
                        $rs[$c][]='activeUrl';
                        $ms[$c.'.activeUrl']=$this->_getf($cls[$k]).'为域名/IP';
                    }
                }
                if(isset($vals[$c.'_'.'url'])){
                    if($vals[$c.'_'.'url']=='on'){
                        $rs[$c][]='url';
                        $ms[$c.'.url']=$this->_getf($cls[$k]).'为URL';
                    }
                }
                if(isset($vals[$c.'_'.'ip'])){
                    if($vals[$c.'_'.'ip']=='on'){
                        $rs[$c][]='ip';
                        $ms[$c.'.ip']=$this->_getf($cls[$k]).'为ip';
                    }
                }
                
                if(isset($vals[$c.'_'.'regex'])){
                    if($vals[$c.'_'.'regex']!=''){
                        $rs[$c][]='regex:'.$vals[$c.'_'.'regex'];
                        $ms[$c.'.regex']=$this->_getf($cls[$k]).'无法通过验证';
                    }
                }
                
                if(isset($vals[$c.'_'.'confirm'])){
                    if($vals[$c.'_'.'confirm']!=''){
                        $rs[$c][]='confirm:'.$vals[$c.'_'.'confirm'];
                        $ms[$c.'.confirm']=$this->_getf($cls[$k]).'和'.$vals[$c.'_'.'confirm'].'值相同';
                    }
                }
                if(isset($vals[$c.'_'.'max'])){
                    if($vals[$c.'_'.'max']!=''){
                        $rs[$c][]='max:'.$vals[$c.'_'.'max'];
                        $ms[$c.'.max']=$this->_getf($cls[$k]).'最大值为'.$vals[$c.'_'.'max'];
                    }
                }
                if(isset($vals[$c.'_'.'min'])){
                    if($vals[$c.'_'.'min']!=''){
                        $rs[$c][]='min:'.$vals[$c.'_'.'min'];
                        $ms[$c.'.min']=$this->_getf($cls[$k]).'最小值为'.$vals[$c.'_'.'min'];
                    }
                }
                if(isset($vals[$c.'_'.'before'])){
                    if($vals[$c.'_'.'before']!=''){
                        $rs[$c][]='before:'.$vals[$c.'_'.'before'];
                        $ms[$c.'.before']=$this->_getf($cls[$k]).'必须在'.$vals[$c.'_'.'before'].'之前';
                    }
                }
                if(isset($vals[$c.'_'.'after'])){
                    if($vals[$c.'_'.'after']!=''){
                        $rs[$c][]='after:'.$vals[$c.'_'.'after'];
                        $ms[$c.'.after']=$this->_getf($cls[$k]).'必须在'.$vals[$c.'_'.'before'].'之后';
                    }
                }
            }
        //}
        //print_r($rs);exit;
        $this->assign('table',$vals['table']);
        $this->assign('cls',$cls);
        $this->assign('rs',$rs);
        $this->assign('ms',$ms);
        return view();
    }
    
    public function page_form_step1(){
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        return view();
    }
    
    public function page_form_step2(){
        $d = input('get.');
        $table = $d['table'];
        $style = $d['style'];//h水平 b基本 i内联
        $key = '';
        
        if($table!=''){
        
            $cls = $this->columns($table);//print_r($cls);
            foreach ($cls as $c){
                if($c['Key']=='PRI'){
                    $key = $c['Field'];
                    break;
                }
            }
            $this->assign('cls',$cls);
            $this->assign('key',$key);
            $this->assign('table',$table);
            $this->assign('style',$style);
                        
        }else{
            $this->error('请选择要操作的数据表！');
        }
        
        return view();
    }
    
    public function page_table_step1(){
        $tbs = $this->tables();
        $this->assign('tables',$tbs);
        return view();
    }
    
    public function page_table_step2(){
        $d = input('post.');
        $table = $d['table'];//dump(input('post.style'));exit;
        $styles ='';
        if(isset($d['style']))
            $styles = implode(' ',$d['style']);
        $key="";
        
        if($table!=''){
            $cls = $this->columns($table);//print_r($cls);
            foreach ($cls as $c){
                if($c['Key']=='PRI'){
                    $key = $c['Field'];
                    break;
                }
            }
            $this->assign('cls',$cls);
            $this->assign('k',$key);
            $this->assign('table',$table);
            $this->assign('styles',$styles);
        }else{
            $this->error('请选择要操作的数据表！');
        }
        
        return view();
    }
    
    private function _getf($c){
        if($c['Comment']!=''){
            return $c['Comment'];
        }else
            return $c['Field'];
    }
}

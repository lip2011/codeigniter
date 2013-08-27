<?php

class MY_Model extends CI_Model
{

    /**
    * 规则定义形式
    * $validate  = array(          
    *      array(
    *              'field'   => 'fieldname',
    *              'label'   => 'fieldname',
    *              'rules'   => array(
    *                      'required' => 'call_back_example',                  
    *              )
    *      ),
    *      array(
    *              'field'   => 'fieldname2',
    *              'label'   => 'fieldname2',
    *              'rules'   => array(
    *                      'required'  => true,    
    *                      'numeric'   => true,
    *                      'less_than' => 'call_back_example'
    *              )
    *      )
    * );   
    *  
    *  function call_back_example(){
    *  
    *  }
    *  call_back_example() 为规则回调函数，
    *  返回值为 false,true 或 string 类型。
    *  false  对应规则不生效
    *  true   对应规则生效
    *  string 返回值即为对应规则。
    *   
    */
    /*
     * 将要接受验证的数组 存储到 $data_source中，方便在回调函数中调用。
     */
    protected $data_source = array();
    protected $validate;
    
    /**
     * 验证表单提交值
     * @param array() $data; 要验证 数据 key 要与 验证规则中 field 相对应。 
     */
    public function validate($data)
    {
        foreach($data as $key => $val){
            $_POST[$key] = $val;
            $this->data_source[$key] = $val;
        }       
        $validate = $this->translation_rule();
        if(!empty($validate)){
            $this->load->library('form_validation');
            if(is_array($validate)){
                $this->form_validation->set_rules($validate);
                if ($this->form_validation->run() === TRUE) {
                    return $data;
                } else {
                    return FALSE;
                }
            } else {
                if ($this->form_validation->run($validate) === TRUE) {
                    return $data;
                } else {
                    return FALSE;
                }
            }
        } else {
            return $data;
        }
    }   
    /**
     * 转换 验证规则。主要，调用回调函数，动态生成验证规则。
     */
    function translation_rule(){
        $form_validate  = array();
        $js_validate    = array();
        $setting_rule   = $this->validate;
        $form_validate  = $this->validate;
        if(isset($setting_rule) && count($setting_rule)>0) {
            foreach ($setting_rule as $key=>$list) {
                $rules = $list['rules'];
                foreach ($rules as $r_key=>$r_val) {
                    if($r_val !== true){
                        $function = $r_val;
                        $get_re =$this->$function();
                        if($get_re === false){
                            unset($form_validate[$key]['rules'][$r_key]);
                        }
                        else if ($get_re !== true && $get_re)
                        {
                            unset($form_validate[$key]['rules'][$r_key]);
                            $form_validate[$key]['rules'][$get_re] = $get_re;
                        }
                    }
                }
                $new_rules = $form_validate[$key]['rules'];
                $new_rules = array_keys($new_rules);
                $new_rules = implode('|', $new_rules);
                $form_validate[$key]['rules'] = $new_rules;
            }
        }
        return $form_validate;
    }


    /*
        $params = array('id' => 1)
    */
    public function fetchAll($sql, $params = null, $returnType = 'object')
    {
        $query = $this->_database->query($sql, $params);
        if($query->num_rows() > 0) {
            if ($returnType == 'object') {
                return $query->result();
            } else {
                return $query->result_array();
            }
        }
        
        return null;
    }

    public function fetchRow($sql, $params = null, $returnType = 'object')
    {
        $query = $this->_database->query($sql, $params);
        if($query->num_rows() > 0) {
            if ($returnType == 'object') {
                return $query->row();
            } else {
                return $query->row_array();
            }
            
        }
        return null;
    }

    public function fetchOne($sql, $params)
    {
        $query = $this->_database->query($sql, $params);
        if($query->num_rows() > 0) {
            $result = $query->row_array();
            foreach ($result as $key => $value) {
                return $value;
            }
        }
        return null;
    }

}
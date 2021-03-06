<?php
include ('config.php');
class SQL
{   
    protected $select;
    protected $selectDistinct;
    protected $where;
    protected $having;
    protected $tables;
    protected $from;
    protected $columns;
    protected $condition;
    protected $params;
    protected $orderBy;
    protected $order;
    protected $columnsGroupBy;
    protected $group;
    protected $limit;
    protected $havingCondition;
    protected $havingParams;
    protected $joinTable;
    protected $joinCondition;
    protected $join;
    protected $leftJoin;
    protected $rightJoin;
    protected $crossJoin;
    protected $naturalJoin;
    protected $insert;
    protected $insertValue;
    protected $insertKey;
    protected $update;
    protected $updateValue;
    protected $delete;
    protected $errors;
    
    

    public function __construct()
    {
        $this->select='';
        $this->selectDistinct='';
        $this->where='';
        $this->having='';
        $this->tables='';
        $this->from='';
        $this->columns=[];//columns for select
        $this->condition=[];// condition for where and having
        $this->params='';//params for where and having
        $this->orderBy=[];//params for order
        $this->order='';//query
        $this->columnsGroupBy=[];//arr columns for group
        $this->group='';//query
        $this->limit='';
        $this->havingCondition='';
        $this->havingParams='';
        $this->join='';
        $this->joinTable='';
        $this->joinCondition='';
        $this->leftJoin='';
        $this->rightJoin='';
        $this->crossJoin='';
        $this->naturalJoin='';
        $this->insert='';
        $this->insertValue='';
        $this->insertKey='';
        $this->update='';
        $this->updateValue='';
        $this->delete='';
        $this->errors=[];
        
       
    }

    

// ******* SELECT ()

    
    public function select($columns)
    {
        if($columns)
        {   
            $str= implode('',$columns);
            if ( FALSE=== stristr($str, '.'))//check for prefix scheme
            {
                $this->columns=implode("`,`",$columns);
                $this->select="SELECT ". "`".$this->columns."`"; 
                return true; 
            }else
            {
                $this->columns=implode(",",$columns);
                $this->select=" SELECT $this->columns "; 
                return true; 
            }                           
        }return false;
    }




    public function selectDistinct($columns)
    {
        if($columns)
        {
    
            $this->columns=implode("`,`",$columns);
            $this->select="SELECT DISTINCT ". "`".$this->columns."`"; 
            return true;    
        }return false;   
    }




    public function from($tables)
    {
        if ($tables)
        {
            try
            {
                $tables= trim(preg_replace('/\s+/', '', $tables));
                     if (empty($tables))
                    {
                        throw new Exception(COLUMN_ERROR);   
                    }
                    $this->tables = trim(htmlspecialchars($tables));
                    $this->from = " FROM $this->tables"; 
            }
            catch(Exception $e)
            {
                $this->errors = $this->arrayPush($this->errors, $e->getMessage() );
            }
            
        }
        else
        {
             $this->errors = $this->arrayPush($this->errors, COLUMN_ERROR1);
             
        }
    }



    public function where($condition, $params)
    {
        if($condition &&  $params)
        { 
            try
            {
                $condition= trim(preg_replace('/\s+/', '', $condition));
                $params= trim(preg_replace('/\s+/', '', $params));
                     if (empty($condition) || empty($params))
                    {
                        throw new Exception(COLUMN_ERROR);   
                    }
                    $this->condition = $condition; 
                    $this->params = $params;//print_r($this->params);
                    $this->where = " WHERE  $this->condition  :params";
                    //return $this;
            }
            catch(Exception $e)
            {
                $this->errors = $this->arrayPush($this->errors, $e->getMessage() );
            }   
        }
        else
        {
            $this->errors = $this->arrayPush($this->errors, COLUMN_ERROR1);
        }    
    }



    public function having($havingCondition, $havingParams)
    {
        if($havingCondition &&  $havingParams)
        {
            try
            {
                $havingCondition= trim(preg_replace('/\s+/', '', $havingCondition));
                $havingParams= trim(preg_replace('/\s+/', '', $havingParams));
                     if (empty($havingCondition) || empty($havingParams))
                    {
                        throw new Exception(COLUMN_ERROR);   
                    }
                    $this->havingCondition = $havingCondition; 
                    $this->havingParams = $havingParams;
                    $this->having = " HAVING $this->havingCondition   $this->havingParams"; 
            }
            catch(Exception $e)
            {
                $this->errors = $this->arrayPush($this->errors, $e->getMessage() );
            }   
        }
        else
        {
            $this->errors = $this->arrayPush($this->errors, COLUMN_ERROR1);
        }     
    }



    // add to array input  data for public function order($columns)

    public function setOrder($columns)
    {
        if ($columns)
        {
            $orderBy = trim(htmlspecialchars($columns));
            $this->orderBy = $this->arrayPush($this->orderBy,$orderBy);
            return $this;
        }return false;
        
    }



    public function getOrder()
    {
        if ($this->orderBy)
        {
            return $this->orderBy;
        }
    }



    public function order($columns)
    {
        if ($columns)
        {          
            $this->orderBy=implode(",",$this->orderBy);
            $this->order=" ORDER BY $this->orderBy ";//print_r($this->order);
            return true;  
        }return false;
    }

   

    //add to array data for  public function group($columns)

    public function setGroupBy($columnsGroupBy)
    {
        if ($columnsGroupBy)
        {
            try
           {
               $columnsGroupBy= trim(preg_replace('/\s+/', '', $columnsGroupBy));//print_r($columns);
                if (empty($columnsGroupBy))
                {
                    throw new Exception(COLUMN_ERROR);
                }
                $this->columnsGroupBy=$this->arrayPush($this->columnsGroupBy,htmlspecialchars($columnsGroupBy));
                return $this;

           }catch(Exception $e)
           {
                $this->errors= $this->arrayPush($this->errors, $e->getMessage());
                return $this;
           }
        }
        else 
        {
            $this->errors= $this->arrayPush($this->errors, COLUMN_ERROR1);
            return $this;
        }

    }



    public function getGroupBy()
    {
        if ($this->columnsGroupBy)
        {
            return $this->columnsGroupBy;
        }
    }


    
    public function group($columns)
    {
        if ($columns)
        {
            $this->columnsGroupBy= implode(",",$this->columnsGroupBy);
            $this->group= " GROUP BY $this->columnsGroupBy";
            return true;
        }return false;
    }



    public function limit($limit)
    { 
        if ($limit)
        {  
            try
           {        
               $limit= trim(preg_replace('/\s+/', '', $limit));
                if (empty($limit))
                {
                    throw new Exception(COLUMN_ERROR);
                }
                $this->limit = $limit;
                $this->limit = " LIMIT $this->limit";
               

           }catch(Exception $e)
           {
                $this->errors= $this->arrayPush($this->errors, $e->getMessage());
           }
        }
        else 
        {
            $this->errors= $this->arrayPush($this->errors, COLUMN_ERROR1);
        }
    }



    //****** */Join functions

    public function join($table, $conditions)
    {
        if ($table && $conditions)
        {
            $this->joinTable=trim(htmlspecialchars($table));
            $this->joinCondition=trim($conditions);
            $this->join=" INNER JOIN "."`". $this->joinTable."`"." ON $this->joinCondition ";
            return true;
        }return false;
    }



    public function leftJoin($table, $conditions)
    {
        if ($table && $conditions)
        {
            $this->joinTable=trim(htmlspecialchars($table));
            $this->joinCondition=trim($conditions);
            $this->leftJoin=" LEFT OUTER JOIN "."`". $this->joinTable."`"." ON $this->joinCondition ";
            return true;
        }return false;
    }



    public function rightJoin($table, $conditions)
    {
        if (is_string($table) && is_string($conditions))
        { 
            $this->joinTable=($table);
            $this->joinCondition=trim($conditions);
            $this->rightJoin=" RIGHT OUTER JOIN  $this->joinTable  ON $this->joinCondition "; //print_r( $this->joinCondition);
            return true;
        }
        return false; 
    }

    


    public function crossJoin($table)
    {
        if (is_string($table))
        {
            $this->joinTable=trim(htmlspecialchars($table));
            $this->crossJoin=" CROSS JOIN "."`". $this->joinTable."`";
            return true;
        }return false;
    }



    public function naturalJoin($table)
    {
        if (is_string($table))
        {
            $this->joinTable=trim(htmlspecialchars($table));
            $this->naturalJoin=" NATURAL JOIN "."`". $this->joinTable."`";
            return true;
        }return false;
    }
    


    //INSERT Function
  
    public function insert($table, $columns)
    {
        if ($table && is_array($columns))
        {
            $this->tables=trim(htmlspecialchars($table));
            $this->insertValue=$columns; 
            $this->insertKey=array_keys($columns);
            $this->insertKey=implode(', ', $this->insertKey);
            $values = array();
            foreach($columns as $key => $val) 
            {
                $values[] = ':' . $key;
            }
            $this->insert=" INSERT INTO  $this->tables ($this->insertKey) VALUES(" . implode(', ', $values) . ")";
            return true;
        }
        
        return false;
    }



//-----------UPDATE

    public function update($table, $columns)
    {
        if ($table && is_array($columns))
        {
            $this->tables=trim(htmlspecialchars($table));
            $this->updateValues=$columns;
            $key=array_keys($columns);
            $values= array();
            foreach($this->updateValues as $key => $val) 
            {
                $values[] = $key .'= :' .$key;
            }
            $this->update="UPDATE $this->tables SET ".implode(', ' ,$values).""; 
        }  
    }




//-----------DELETE

    public function delete($table)
    {
        if ($table)
        {
            $this->tables=trim(htmlspecialchars($table));
            $this->delete=" DELETE FROM $this->tables ";
        }
    }




    //check for "*" and pushing to array

    private function arrayPush($var, $val)
    {
    $val = trim($val);
    if ($val != '*')
    {
        array_push($var, $val);
        return $var;
    }
    return false;
    }




    //**check imput filds and add it to array */

    public function setColumns($columns)
    {
        if ($columns)
        {
            try
           {
               $columns= trim(preg_replace('/\s+/', '', $columns));//print_r($columns);
                if (empty($columns))
                {
                    throw new Exception(COLUMN_ERROR);
                }
                $this->columns=$this->arrayPush($this->columns,trim(htmlspecialchars($columns)));//var_dump($this->columns);
                return $this;

           }catch(Exception $e)
           {
                $this->errors= $this->arrayPush($this->errors, $e->getMessage());
                return $this;
           }
        }
        else 
        {
            $this->errors= $this->arrayPush($this->errors, COLUMN_ERROR1);
            return $this;
        }
        
    }   



    public function setJoinTable($JoinTable)
    {
        if($JoinTable)
        {
            try
            {
                $JoinTable= trim(preg_replace('/\s+/', '', $JoinTable));
                if (empty($JoinTable))
                {
                    throw new Exception(COLUMN_ERROR);
                }
               return $this->JoinTable=trim(htmlspecialchars($JoinTable));
            }
            catch(Exception $e)
            {
                $this->errors= $this->arrayPush($this->errors, $e->getMessage());
            }
        }
        else
        { 
            $this->errors= $this->arrayPush($this->errors, COLUMN_ERROR1);
        }
    }
        



    public function setJoinCondition($joinCondition)
    {
        if($joinCondition)
        {
            try
            {
                $joinCondition= trim(preg_replace('/\s+/', '', $joinCondition));
                if (empty($joinCondition))
                {
                    throw new Exception(COLUMN_ERROR);
                }
               return $this->joinCondition=trim(htmlspecialchars($joinCondition));
            }
            catch(Exception $e)
            {
                $this->errors= $this->arrayPush($this->errors, $e->getMessage());
            }
        }
        else
        { 
            $this->errors= $this->arrayPush($this->errors, COLUMN_ERROR1);
        }
    }
    


    public function getColumns()
    {
        if($this->columns)
        {
            return $this->columns;
        }

    }



    public function getErrors()
    {
        if (!empty($this->errors))
        {
           return $this->errors  ;  
        }
    }
}









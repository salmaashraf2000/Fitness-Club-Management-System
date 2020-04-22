<?php
require 'config.php';
trait mysql{
            protected $_config =array();
            protected $_link;
            protected $_result;
            
            public function __construct(array $config) 
            {
                if(count($config)!==4)
                {
                    throw new InvalidArgumentException('Invalid number of connection parameter');
                }
                 $this->_config=$config;
                 echo 'hello';
            }
            
            //connect to mysql
            public function connect()
            {
                global $config;
                $this->_config=$config;
                if($this->_link===null)
                {
                    list($host,$user,$password,$database)= $this->_config;
                    if(!$this->_link=@mysqli_connect($host,$user,$password,$database))
                    {
                        throw new RuntimeException('error connecting to server'. mysqli_connect_error());
                    }
                    //remove values
                    unset($host,$user,$password,$database);
                }
                return $this->_link;
            }
            
            public function query($query)
            {
                if(!is_string($query) || empty($query))
                {
                    throw new InvalidArgumentException('query mot valid');
                }
                $this->connect();
                if(!$this->_result= mysqli_query($this->_link,$query))
                {
                   // return false;
                    throw new RuntimeException('error executing query'.$query.mysqli_error($this->_link));
                 
                }
                return $this->_result;
            }
            
            public function select($table,$where='',$fields='*',$order='')
            {
                $query='SELECT '.$fields.' FROM '.$table
                        .(($where)? ' WHERE '.$where :'')
                        .(($order)? ' ORDER BY '.$order:'');
                return $this->query($query);
            }
            
             public function selectJoin($table1,$where='',$fields='*',$order='',$table2,$on1='',$table3='',$on2='',$table4='',$on3='')
            {
                $query='SELECT '.$fields.' FROM '.$table1.' LEFT JOIN '.$table2.' ON '.$on1
                        .(($table3)? ' LEFT JOIN '.$table3.' ON '.$on2: '')
                        .(($table4)? ' LEFT JOIN '.$table4.' ON '.$on3: '')
                        .(($where)? ' WHERE '.$where :'')
                        .(($order)? ' ORDER BY '.$order:'');
                return $this->query($query);
            }
            
            public function insert($table, array $data)
            {
                $fields = implode(',', array_keys($data));
                $values = implode(',', array_map(array($this,Escape), array_values($data)));
                $query='INSERT INTO '.$table.' ('.$fields. ') '.' VALUES ('.$values.') ';
                $this->query($query);
                return ;
            }
            
            public function update($table, array $data,$where='')
            {
                $set =array();
                foreach ($data as $field->$value)
                {
                    $set[]=$field. '='.$this->Escape($value);
                }
                //
                $Set= implode(',', $set);
                $query ='UPDATE '.$table.' SET '.$Set
                        .(($where)? ' WHERE '.$where : '');
                $this->query($query);
                return;
            }
            
            public function delete($table,$where='')
            {
                $query='DElETE FROM '.$table
                        .(($where)? ' WHERE '.$where:'');
                $this->query($query);
                return;
            }
            //escape special characters in string for use of SQL statements
            public function Escape($value)
            {
                $this->connect();
                if($value===null)
                {
                    $value='NULL';
                } else if(!is_numeric($value))
                {
                    $value="'".mysqli_real_escape_string($this->_link, $value)."'";
                }
                return $value;
            }
            
            //get inserted id
            public function getInsertedId()
            {
                return $this->_link!==null ? mysqli_insert_id($this->_link): null;
            }
            
            //count number of rows returned from current result set
            public function countRows()
            {
                return $this->_result!==null ? mysqli_num_rows($this->_result) : 0;
            }
            
            //get number of affected rows
            public function AffectedRows()
            {
                return $this->_link!==null ? mysqli_affected_rows($this->_link):0;
            }
            
            //free current result set
            public function FreeResult() 
            {
                if($this->_result===null)
                {
                    return false;
                }
                mysqli_free_result($this->_result);
                return true;
            }
            
            //close database connection
            public function disconnect() 
            {
                if($this->_link===null)
                {
                    return;
                }
                 mysqli_close($this->_link);
                $this->_link=null;
                return true;
            }
            
            //destructor to close database connection when instance of class destroyed
            public function __destruct() 
            {
                $this->disconnect();
            }
            
        }


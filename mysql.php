<?php
require 'config.php';
trait mysql{
            
            private static $_config =array();
            private static $_link;
            private static $_result;
            
            
            private function __construct(array $config) 
            {
                if(count($config)!==4)
                {
                    throw new InvalidArgumentException('Invalid number of connection parameter');
                }
                
                self::$_config=$config;
                 
            }
            
            //connect to mysql  
            public static function connect()
            {
                global $config;
                self::$_config=$config;
                if(self::$_link===null)
                {
                    list($host,$user,$password,$database)= self::$_config;
                    if(!self::$_link=@mysqli_connect($host,$user,$password,$database))
                    {
                        throw new RuntimeException('error connecting to server'. mysqli_connect_error());
                    }
                    //remove values
                    unset($host,$user,$password,$database);
                }
                return self::$_link;
            }
            
            public function query($query)
            {
                if(!is_string($query) || empty($query))
                {
                    throw new InvalidArgumentException('query mot valid');
                }
                $this->connect();
                if(!self::$_result= mysqli_query(self::$_link,$query))
                {
                   
                    throw new RuntimeException('error executing query'.$query.mysqli_error(self::$_link));
                 
                }
                return self::$_result;
            }
            
            public function select($table,$where='',$fields='*',$order='')
            {
                $query='SELECT '.$fields.' FROM '.$table
                        .(($where)? ' WHERE '.$where :'')
                        .(($order)? ' ORDER BY '.$order:'');
                return $this->query($query);
            }
            
             public function selectJoin($table1,$where='',$fields='*',$order='',$table2,$left1=0,$on1='',$table3='',$left2=0,$on2='',$table4='',$left3=0,$on3='',$table5='',$left4=0,$on4='')
            {
                $query='SELECT '.$fields.' FROM '.$table1.(($left1)?' LEFT':'' ).' JOIN '.$table2.' ON '.$on1
                        .(($left2)?' LEFT':'' ).(($table3)? ' JOIN '.$table3.' ON '.$on2: '')
                        .(($left3)?' LEFT':'' ).(($table4)? ' JOIN '.$table4.' ON '.$on3: '')
                        .(($left4)?' LEFT':'' ).(($table5)? ' JOIN '.$table5.' ON '.$on4: '')
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
                foreach ($data as $field=>$value)
                {
                    $set[]=$field. '='.$this->Escape($value);
                }
                
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
                    $value="'".mysqli_real_escape_string(self::$_link, $value)."'";
                }
                return $value;
            }
            
            //get inserted id
            public function getInsertedId()
            {
                return self::$_link!==null ? mysqli_insert_id(self::$_link): null;
            }
            
            //count number of rows returned from current result set
            public function countRows()
            {
                return self::$_result!==null ? mysqli_num_rows(self::$_result) : 0;
            }
            
            //get number of affected rows
            public function AffectedRows()
            {
                return self::$_link!==null ? mysqli_affected_rows(self::$_link):0;
            }
            
            //free current result set
            public function FreeResult() 
            {
                if(self::$_result===null)
                {
                    return false;
                }
                mysqli_free_result(self::$_result);
                return true;
            }
            
            //close database connection
            public function disconnect() 
            {
                if(self::$_link===null)
                {
                    return;
                }
                 mysqli_close(self::$_link);
                self::$_link=null;
                return true;
            }
            
            //destructor to close database connection when instance of class destroyed
            public function __destruct() 
            {
                $this->disconnect();
            }
            
        }


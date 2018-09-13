<?php
/**
 * A base model with a series of CRUD functions (powered by CI's query builder),
 * validation-in-model support, event callbacks and more.
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-model
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

class MY_Model extends CI_Model
{

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table;

    /**
     * The database connection object. Will be set to the default
     * connection. This allows individual models to use different DBs
     * without overwriting CI's global $this->db connection.
     */
    public $_database;

    /**
     * This model's default primary key or unique identifier.
     * Used by the get(), update() and delete() functions.
     */
    protected $primary_key = 'id';

    /**
     * user id for mark
     */
    public $_user_id = 0;

    /**
     * Support for soft deletes and this model's 'deleted' key
     */
    protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;
    protected $_temporary_only_deleted = FALSE;

    /**
     * The various callbacks available to the model. Each are
     * simple lists of method names (methods will be run on $this).
     */
    protected $before_create = array();
    protected $after_create = array();
    protected $before_update = array();
    protected $after_update = array();
    protected $before_get = array();
    protected $after_get = array();
    protected $before_delete = array();
    protected $after_delete = array();

    protected $callback_parameters = array();

    /**
     * Protected, non-modifiable attributes
     */
    protected $protected_attributes = array();

    /**
     * Relationship arrays. Use flat strings for defaults or string
     * => array to customise the class name and primary key
     */
    protected $belongs_to = array();
    protected $has_many = array();

    protected $_with = array();

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     */
    protected $validate = array();

    /**
     * Optionally skip the validation. Used in conjunction with
     * skip_validation() to skip data validation for any future calls.
     */
    protected $skip_validation = FALSE;

    /**
     * By default we return our results as objects. If we need to override
     * this, we can, or, we could use the `as_array()` and `as_object()` scopes.
     */
    protected $return_type = 'array';
    protected $_temporary_return_type = NULL;

    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the model, tie into the CodeIgniter superobject and
     * try our best to guess the table name.
     */
    public function __construct()
    {
        // parent::__construct();

        $this->load->helper('inflector');

        $this->_fetch_table();

        $this->_database = $this->db;

        array_unshift($this->before_create, 'protect_attributes');
        array_unshift($this->before_update, 'protect_attributes');

        $this->_temporary_return_type = $this->return_type;
    }

    /* --------------------------------------------------------------
     * CRUD INTERFACE
     * ------------------------------------------------------------ */

    /**
     * Assign select field.
     */
    public function select($field = '', $state = true)
    {
        $this->_database->select($field, $state);
    }

    /**
     * Fetch a single record based on the primary key. Returns an object.
     */
    public function get($primary_value)
    {
        return $this->get_by($this->primary_key, $primary_value);
    }

    /*
    just for 1 column to another
    $belongs_to = array('group' => array('from_column' => 'group_id', 'to_column' => 'id', 'mode' => 'LEFT'));
     */
    public function join($join_to = ''){
        foreach ($this->belongs_to as $key => $join){
            if($key == $join_to){
                if(!isset($join['mode'])) $join['mode'] = 'LEFT';
                if(!isset($join['table'])) $join['table'] = $this->_table;
                $this->_database->join($key, $join['table'].'.'.$join['from_column'].' = '.$key.'.'.$join['to_column'], $join['mode']);
            }
        }
    }

    /**
     * Fetch a single record based on an arbitrary WHERE call. Can be
     * any valid value to $this->_database->where().
     */
    public function get_by()
    {
        $where = func_get_args();

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }

        $this->_set_where($where);

        $this->trigger('before_get');

        $row = $this->_database->get($this->_table)
                        ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;

        $row = $this->trigger('after_get', $row);

        $this->_with = array();
        return $row;
    }

    /**
     * Fetch an array of records based on an array of primary values.
     */
    public function get_many($values)
    {
        $this->_database->where_in($this->_table.'.'.$this->primary_key, $values);

        return $this->get_all();
    }

    /**
     * Fetch an array of records based on an arbitrary WHERE call.
     */
    public function get_many_by()
    {
        $where = func_get_args();
        
        $this->_set_where($where);

        return $this->get_all();
    }

    public function get_many_like()
    {
        $where = func_get_args();

        foreach ($where as $value) {
            $this->_database->like($value);
        }

        return $this->get_all();
    }

    /**
     * Fetch all the records in the table. Can be used as a generic call
     * to $this->_database->get() with scoped methods.
     */
    public function get_all()
    {
        $this->trigger('before_get');

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }

        $result = $this->_database->get($this->_table)
                           ->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;

        foreach ($result as $key => &$row)
        {
            $row = $this->trigger('after_get', $row, ($key == count($result) - 1));
        }

        $this->_with = array();
        return $result;
    }

    /**
     * Insert a new row into the table. $data should be an associative array
     * of data to be inserted. Returns newly created ID.
     */
    public function insert($data, $skip_validation = FALSE)
    {
        if ($skip_validation === FALSE)
        {
            $data = $this->validate($data);
        }

        if ($data !== FALSE)
        {
            $data = $this->trigger('before_create', $data);

            $this->_database->insert($this->_table, $data);
            $insert_id = $this->_database->insert_id();

            // $this->trigger('after_create', $insert_id);
            $this->trigger('after_create', $data);

            return $insert_id;
            // return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Provide insert ignore SQL function
     */

    public function insert_update_duplicate($primary_field, $data, $skip_validation = FALSE){
        if ($skip_validation === FALSE)
        {
            $data = $this->validate($data);
        }

        if ($data !== FALSE)
        {
            $_prepared = array();
            $_prepared_nokey = array();
            foreach ($data as $col => $val)
            {
                $_prepared[$this->_database->protect_identifiers($col)] = $this->db->escape($val);
                if($col != $primary_field)
                    $_prepared_nokey[$this->_database->protect_identifiers($col)] = $this->db->escape($val);
            }

            $this->_database->query("INSERT INTO ".$this->_database->protect_identifiers($this->_table)." (".implode(',', array_keys($_prepared)).") VALUES (".implode(',', array_values($_prepared)).") ON DUPLICATE KEY UPDATE ".urldecode(http_build_query($_prepared_nokey, '', ', ')));
            $this->trigger('after_create', $_prepared);

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Insert multiple rows into the table. Returns an array of multiple IDs.
     */
    public function insert_many($data, $skip_validation = FALSE)
    {
        $ids = array();

        foreach ($data as $key => $row)
        {
            $ids[] = $this->insert($row, $skip_validation, ($key == count($data) - 1));
        }

        return $ids;
    }

    /**
     * Insert multiple rows into the table with insert batch. Returns an boolean.
     */
    public function insert_batch($data)
    {
        foreach ($data as $i => $d) {
            $data[$i] = $this->trigger('before_create', $d);
        }
        
        $insert =  $this->_database->insert_batch($this->_table, $data);
        $this->trigger('after_create', $data);
        return $insert;
    }

    /**
     * Updated a record based on the primary value.
     */
    public function update($primary_value, $data, $skip_validation = FALSE)
    {
        $data = $this->trigger('before_update', $data);

        if ($skip_validation === FALSE)
        {
            $data = $this->validate($data);
        }

        if ($data !== FALSE)
        {
            $result = $this->_database->where($this->primary_key, $primary_value)
                               ->set($data)
                               ->update($this->_table);

            $this->trigger('after_update', array($data, $result));

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Update multiple rows into the table with update batch. Returns an boolean.
     */
    public function update_batch($data = array(), $index = 'id')
    {
        return $this->_database->update_batch($this->_table, $data, $index);
    }

    /**
     * Update many records, based on an array of primary values.
     */
    public function update_many($primary_values, $data, $skip_validation = FALSE)
    {
        $data = $this->trigger('before_update', $data);

        if ($skip_validation === FALSE)
        {
            $data = $this->validate($data);
        }

        if ($data !== FALSE)
        {
            $result = $this->_database->where_in($this->primary_key, $primary_values)
                               ->set($data)
                               ->update($this->_table);

            $this->trigger('after_update', array($data, $result));

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Updated a record based on an arbitrary WHERE clause.
     */
    public function update_by()
    {
        $args = func_get_args();
        $data = array_pop($args);

        $data = $this->trigger('before_update', $data);

        if ($this->validate($data) !== FALSE)
        {
            $this->_set_where($args);
            $result = $this->_database->set($data)
                               ->update($this->_table);
            $this->trigger('after_update', array($data, $result));

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Update all records
     */
    public function update_all($data)
    {
        $data = $this->trigger('before_update', $data);
        $result = $this->_database->set($data)
                           ->update($this->_table);
        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    /**
     * Delete a row from the table by the primary value
     */
    public function delete($id)
    {
        $this->trigger('before_delete', $id);

        $this->_database->where($this->primary_key, $id);

        if ($this->soft_delete)
        {
            $result = $this->_database->update($this->_table, array( $this->soft_delete_key => TRUE ));
        }
        else
        {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    /**
     * Delete a row from the database table by an arbitrary WHERE clause
     */
    public function delete_by()
    {
        $where = func_get_args();

        $where = $this->trigger('before_delete', $where);

        $this->_set_where($where);


        if ($this->soft_delete)
        {
            $result = $this->_database->update($this->_table, array( $this->soft_delete_key => TRUE ));
        }
        else
        {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    /**
     * Delete many rows from the database table by multiple primary values
     */
    public function delete_many($primary_values)
    {
        $primary_values = $this->trigger('before_delete', $primary_values);

        $this->_database->where_in($this->primary_key, $primary_values);

        if ($this->soft_delete)
        {
            $result = $this->_database->update($this->_table, array( $this->soft_delete_key => TRUE ));
        }
        else
        {
            $result = $this->_database->delete($this->_table);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }


    /**
     * Truncates the table
     */
    public function truncate()
    {
        $result = $this->_database->truncate($this->_table);

        return $result;
    }

    /* --------------------------------------------------------------
     * RELATIONSHIPS
     * ------------------------------------------------------------ */

    public function with($relationship)
    {
        $this->_with[] = $relationship;

        if (!in_array('relate', $this->after_get))
        {
            $this->after_get[] = 'relate';
        }

        return $this;
    }

    public function relate($row)
    {
        if (empty($row))
        {
            return $row;
        }

        foreach ($this->belongs_to as $key => $value)
        {
            if (is_string($value))
            {
                $relationship = $value;
                $options = array( 'primary_key' => $value . '_id', 'model' => $value . '_model' );
            }
            else
            {
                $relationship = $key;
                $options = $value;
            }

            if (in_array($relationship, $this->_with))
            {
                $this->load->model($options['model'], $relationship . '_model');

                if (is_object($row))
                {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get($row->{$options['primary_key']});
                }
                else
                {
                    $row[$relationship] = $this->{$relationship . '_model'}->get($row[$options['primary_key']]);
                }
            }
        }

        foreach ($this->has_many as $key => $value)
        {
            if (is_string($value))
            {
                $relationship = $value;
                $options = array( 'primary_key' => singular($this->_table) . '_id', 'model' => singular($value) . '_model' );
            }
            else
            {
                $relationship = $key;
                $options = $value;
            }

            if (in_array($relationship, $this->_with))
            {
                $this->load->model($options['model'], $relationship . '_model');

                if (is_object($row))
                {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get_many_by($options['primary_key'], $row->{$this->primary_key});
                }
                else
                {
                    $row[$relationship] = $this->{$relationship . '_model'}->get_many_by($options['primary_key'], $row[$this->primary_key]);
                }
            }
        }

        return $row;
    }

    /* --------------------------------------------------------------
     * UTILITY METHODS
     * ------------------------------------------------------------ */

    /**
     * Retrieve and generate a form_dropdown friendly array
     */
    function dropdown()
    {
        $args = func_get_args();

        if(count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $this->trigger('before_dropdown', array( $key, $value ));

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, FALSE);
        }

        $result = $this->_database->select(array($key, $value))
                           ->get($this->_table)
                           ->result();

        $options = array();

        foreach ($result as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }

        $options = $this->trigger('after_dropdown', $options);

        return $options;
    }

    /**
     * Fetch a count of rows based on an arbitrary WHERE call.
     */
    public function count_by()
    {
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }

        $where = func_get_args();
        $this->_set_where($where);

        return $this->_database->count_all_results($this->_table);
    }

    /**
     * Fetch a total count of rows, disregarding any previous conditions
     */
    public function count_all()
    {
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->_database->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }

        return $this->_database->count_all($this->_table);
    }

    /**
     * Tell the class to skip the insert validation
     */
    public function skip_validation()
    {
        $this->skip_validation = TRUE;
        return $this;
    }

    /**
     * Get the skip validation status
     */
    public function get_skip_validation()
    {
        return $this->skip_validation;
    }

    /**
     * Return the next auto increment of the table. Only tested on MySQL.
     */
    public function get_next_id()
    {
        return (int) $this->_database->select('AUTO_INCREMENT')
            ->from('information_schema.TABLES')
            ->where('TABLE_NAME', $this->_table)
            ->where('TABLE_SCHEMA', $this->_database->database)->get()->row()->AUTO_INCREMENT;
    }

    /**
     * Getter for the table name
     */
    public function table()
    {
        return $this->_table;
    }

    /* --------------------------------------------------------------
     * GLOBAL SCOPES
     * ------------------------------------------------------------ */

    /**
     * Return the next call as an array rather than an object
     */
    public function as_array()
    {
        $this->_temporary_return_type = 'array';
        return $this;
    }

    /**
     * Return the next call as an object rather than an array
     */
    public function as_object()
    {
        $this->_temporary_return_type = 'object';
        return $this;
    }

    /**
     * Don't care about soft deleted rows on the next call
     */
    public function with_deleted()
    {
        $this->_temporary_with_deleted = TRUE;
        return $this;
    }

    /**
     * Only get deleted rows on the next call
     */
    public function only_deleted()
    {
        $this->_temporary_only_deleted = TRUE;
        return $this;
    }

    /* --------------------------------------------------------------
     * OBSERVERS
     * ------------------------------------------------------------ */

    /**
     * MySQL DATETIME created_at and updated_at
     */
    public function created_at($row)
    {
        if (is_object($row))
        {
            $row->created_at = date('Y-m-d H:i:s');
        }
        else
        {
            $row['created_at'] = date('Y-m-d H:i:s');
        }

        return $row;
    }

    /*
    @hanief isatech style
     */
    protected function create_mark($row){
        $this->_user_id = $this->session->userdata('id');
        if (is_object($row))
        {
            $row->create_date =  date('Y-m-d H:i:s');
            $row->create_by   =  $this->_user_id;
        }
        else
        {
            $row['create_date'] =  date('Y-m-d H:i:s');
            $row['create_by']   =  $this->_user_id;
        }
        
        return $row;
    }

    public function updated_at($row)
    {
        if (is_object($row))
        {
            $row->updated_at = date('Y-m-d H:i:s');
        }
        else
        {
            $row['updated_at'] = date('Y-m-d H:i:s');
        }

        return $row;
    }

    /*
    @hanief isatech style
     */
    protected function update_mark($row){
        $this->_user_id = $this->session->userdata('id');
        if (is_object($row))
        {
            $row->update_date =  date('Y-m-d H:i:s');
            $row->update_by   =  $this->_user_id;
        }
        else
        {
            $row['update_date'] =  date('Y-m-d H:i:s');
            $row['update_by']   =  $this->_user_id;
        }
        
        return $row;
    }

    /**
     * Serialises data for you automatically, allowing you to pass
     * through objects and let it handle the serialisation in the background
     */
    public function serialize($row)
    {
        foreach ($this->callback_parameters as $column)
        {
            $row[$column] = serialize($row[$column]);
        }

        return $row;
    }

    public function unserialize($row)
    {
        foreach ($this->callback_parameters as $column)
        {
            if (is_array($row))
            {
                $row[$column] = unserialize($row[$column]);
            }
            else
            {
                $row->$column = unserialize($row->$column);
            }
        }

        return $row;
    }

    /**
     * Protect attributes by removing them from $row array
     */
    public function protect_attributes($row)
    {
        foreach ($this->protected_attributes as $attr)
        {
            if (is_object($row))
            {
                unset($row->$attr);
            }
            else
            {
                unset($row[$attr]);
            }
        }

        return $row;
    }

    /* --------------------------------------------------------------
     * QUERY BUILDER DIRECT ACCESS METHODS
     * ------------------------------------------------------------ */

    /**
     * A wrapper to $this->_database->order_by()
     */
    public function order_by($criteria, $order = 'ASC')
    {
        if ( is_array($criteria) )
        {
            foreach ($criteria as $key => $value)
            {
                $this->_database->order_by($key, $value);
            }
        }
        else
        {
            $this->_database->order_by($criteria, $order);
        }
        return $this;
    }

    public function group_by($group = '')
    {
        $this->_database->group_by($group);
        return $this;
    }

    /**
     * A wrapper to $this->_database->limit()
     */
    public function limit($limit, $offset = 0)
    {
        $this->_database->limit($limit, $offset);
        return $this;
    }

    /* --------------------------------------------------------------
     * INTERNAL METHODS
     * ------------------------------------------------------------ */

    /**
     * Trigger an event and call its observers. Pass through the event name
     * (which looks for an instance variable $this->event_name), an array of
     * parameters to pass through and an optional 'last in interation' boolean
     */
    public function trigger($event, $data = FALSE, $last = TRUE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);

                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }

                $data = call_user_func_array(array($this, $method), array($data, $last));
            }
        }

        return $data;
    }

    /**
     * Run validation on the passed data
     */
    public function validate($data)
    {
        if($this->skip_validation)
        {
            return $data;
        }

        if(!empty($this->validate))
        {
            foreach($data as $key => $val)
            {
                $_POST[$key] = $val;
            }

            $this->load->library('form_validation');

            if(is_array($this->validate))
            {
                $this->form_validation->set_rules($this->validate);

                if ($this->form_validation->run() === TRUE)
                {
                    return $data;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                if ($this->form_validation->run($this->validate) === TRUE)
                {
                    return $data;
                }
                else
                {
                    return FALSE;
                }
            }
        }
        else
        {
            return $data;
        }
    }

    /**
     * Guess the table name by pluralising the model name
     */
    private function _fetch_table()
    {
        if ($this->_table == NULL)
        {
            $this->_table = plural(preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))));
        }
    }

    /**
     * Guess the primary key for current table
     */
    private function _fetch_primary_key()
    {
        if($this->primary_key == NULl)
        {
            $this->primary_key = $this->_database->query("SHOW KEYS FROM `".$this->_table."` WHERE Key_name = 'PRIMARY'")->row()->Column_name;
        }
    }

    /**
     * Set WHERE parameters, cleverly
     */
    public function _set_where($params)
    {
        if (count($params) == 1 && is_array($params[0]))
        {
            foreach ($params[0] as $field => $filter)
            {
                if (is_array($filter))
                {
                    $this->_database->where_in($field, $filter);
                }
                else
                {
                    if (is_int($field))
                    {
                        $this->_database->where($filter);
                    }
                    else
                    {
                        $this->_database->where($field, $filter);
                    }
                }
            }
        } 
        else if (count($params) == 1)
        {
            $this->_database->where($params[0]);
        }
        else if(count($params) == 2)
        {
            if (is_array($params[1]))
            {
                $this->_database->where_in($params[0], $params[1]);    
            }
            else
            {
                $this->_database->where($params[0], $params[1]);
            }
        }
        else if(count($params) == 3)
        {
            $this->_database->where($params[0], $params[1], $params[2]);
        }
        else
        {
            if (is_array($params[1]))
            {
                $this->_database->where_in($params[0], $params[1]);    
            }
            else
            {
                $this->_database->where($params[0], $params[1]);
            }
        }
    }

    /**
     * Return the method name for the current return type
     */
    protected function _return_type($multi = FALSE)
    {
        $method = ($multi) ? 'result' : 'row';
        return $this->_temporary_return_type == 'array' ? $method . '_array' : $method;
    }

    /**
     * For Datatable
     */
    
    public $dt_indexs           = array();
    public $dt_action_index     = 0; // start from 0
    public $dt_edit_action      = true;
    public $dt_edit_label       = 'Edit';
    public $dt_delete_action    = true;
    public $dt_delete_label     = 'Delete';
    public $dt_detail_action    = false;
    public $dt_read_action      = false;
    public $dt_url_action       = '';
    public $dt_index_edit       = 'id';
    public $dt_group            = '';
    public $dt_join             = array();
    public $dt_where            = array();

    public function datatable(){
        $search = $this->input->get('search');
        $columns = $this->input->get('columns');
        $search_value = $search['value'];
        $order  = $this->input->get('order');

        $return = array();
        $return['draw'] = $this->input->get('draw');
        $return['recordsTotal'] = 0;
        $return['recordsFiltered'] = 0;
        $return['data'] = array();

        $datas = $this->_get_data_datatable($order, $search_value, 'data', $columns);

        foreach ($datas as $i => $data) {
            foreach ($this->dt_indexs as $j => $index) {
                $dex = explode(' as ', $index);
                if(count($dex) > 1) $index = $dex[1];

                $dex = explode('.', $index);
                if(count($dex) > 1) $index = $dex[1];

                if($j != $this->dt_action_index) $return['data'][$i][] = $data[$index];
                else{
                    $act = '';
                    if($this->dt_edit_action == true){
                        $act .= '<a class="btn btn-success btn-xs" href="'.$this->dt_url_action.'edit?'.$this->dt_index_edit.'='.$data[$index].'">'.$this->dt_edit_label.'</a>&nbsp;';
                    }
                    if($this->dt_delete_action == true){
                        $act .= '<a class="btn btn-danger btn-xs delete" href="'.$this->dt_url_action.'delete?'.$this->dt_index_edit.'='.$data[$index].'">'.$this->dt_delete_label.'</a>';
                    }

                    $return['data'][$i][] = $act;
                }
            }
        }
        $return['lastQuery'] = $this->db->last_query();
        $return['recordsTotal'] = $this->_count_all_datatable();
        $return['recordsFiltered'] = $this->_get_data_datatable($order, $search_value, 'count', $columns);
        return json_encode($return);
    }

    private function _count_all_datatable(){
        
        if(count($this->dt_where) > 0){
            foreach ($this->dt_where as $index => $value) {
                $this->db->where($index, $value);
            }
        }

        $this->db->select("COUNT(*) as total");
        $data = $this->get_all();
        return $data[0]['total'];
    }

    private function _get_data_datatable($order = array(), $search_value = '', $type = 'data', $columns = array()){ // $type == 'data'/'count'
        
        if(count($this->dt_where) > 0){
            foreach ($this->dt_where as $index => $value) {
                $this->db->where($index, $value);
            }
        }

        $this->select(implode(',', $this->dt_indexs));
        foreach ($this->dt_join as $jn) {
            $this->join($jn);
        }

        if($search_value != ''){
            $this->db->group_start();
            foreach ($this->dt_indexs as $i => $index) {
                if($columns[$i]['searchable'] == 'true' or $columns[$i]['searchable'] == '1'){
                    $dex = explode(' as ', $index);
                    $index = $dex[0];
                    $this->db->or_like($index, $search_value);
                }
            }
            $this->db->group_end();
        }

        foreach ($this->dt_indexs as $i => $index) {
            $dex = explode(' as ', $index);
            $index = $dex[0];
            if(count($dex) > 1) $index = $dex[1];
            if($i == $order[0]['column']){
                $this->order_by($index, $order[0]['dir']);
            }
        }

        if($type == 'data'){
            $this->group_by($this->dt_group);
            $this->db->offset($this->input->get('start'));
            $this->db->limit($this->input->get('length'));
            return $this->get_all();
        }elseif($type == 'count'){
            // $this->db->select("COUNT(DISTINCT ".$this->dt_indexs[0].") as total");
            $this->db->select("COUNT(*) as total");
            $data = $this->get_all();
            return $data[0]['total'];
        }
    }

    /*
    @haniefhan
    2018-09-10 : add for common model use
    2018-09-12 : add function reformat_post_to_sql, reformat_sql_to_form for format data when insert, update and edit

    public $table_field = array(
        0 => array(
            // table param
            'name'          => '', // Name in table in CI view and form
            'table_index'   => '', // Name table field in database
            'style'         => '', // add style in table
            'in_table'      => true, // show in table : true / false
            // datatable param
            'searchable'    => false, // searchable in datatable : true / false
            'sortable'      => false, // sortable in datatable : true / false
            // form param
            'in_form'       => false, // show in form : true / false
            'type'          => 'hidden', // type in form : hidden, text, select, textarea, date, datepicker, numeric, money
            'value'         => '', // default value
            'required'      => false, // required in form
            'maxlength'     => '', // maxlength in form
        ),
        ...
    );
     */
    public $table_field = array();

    public function get_dt_table_field(){
        $ret = array();
        foreach ($this->table_field as $tf) {
            if($tf['in_table'] == true) $ret[] = $tf['table_index'];
        }
        return $ret;
    }

    public function reformat_post_to_sql($data = array()){
        $table_field = $this->table_field;

        foreach ($table_field as $i => $tf) {
            if($tf['in_form'] == true){
                if($tf['type'] == 'date' or $tf['type'] == 'datepicker') $data[$tf['table_index']] = $this->reformat_date($data[$tf['table_index']]);
                elseif($tf['type'] == 'numeric' or $tf['type'] == 'money') $data[$tf['table_index']] = $this->reformat_numeric($data[$tf['table_index']]);
            }
        }

        return $data;
    }

    public function reformat_sql_to_form($data = array()){
        $table_field = $this->table_field;

        foreach ($table_field as $i => $tf) {
            if($tf['in_form'] == true){
                if($tf['type'] == 'date' or $tf['type'] == 'datepicker') $data[$tf['table_index']] = $this->reformat_date($data[$tf['table_index']], '-', '/');
                elseif($tf['type'] == 'numeric' or $tf['type'] == 'money') $data[$tf['table_index']] = $this->reformat_numeric($data[$tf['table_index']]);
            }
        }

        return $data;
    }

    protected function reformat_date($date = '', $split = '/', $separator = '-'){
        $d = explode($split, $date);
        return $d[2].$separator.$d[1].$separator.$d[0];
    }

    protected function reformat_numeric($numeric = 0){
        // indonesian format
        if(strpos($numeric, '.')){
            $numeric = str_replace('.', '', $numeric);
        }elseif(strpos($numeric, ',')){
            $numeric = str_replace(',', '.', $numeric);
        }
        return $numeric;
    }

    public function populate_select($index_field = '', $value_field = '', $where = array()){
        $ret = array();
        $this->select("$index_field, $value_field");
        foreach ($this->get_many_by($where) as $data) {
            $ret[$data[$index_field]] = $data[$value_field];
        }
        return $ret;
    }
}

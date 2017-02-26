<?php
abstract class DataModel
{

    use LazyGet, LazySet, LazyInvoke, ReturnName;

    protected $dao_obj = null;
    protected $id;
    protected $is_deleted;
    protected $create_time;
    protected $modify_time;
    protected $delete_time;

    public function __construct($instance_data = 0)
    {

        $dao_name = substr(get_class($this), 0, -5).'Dao';
        $this->dao_obj = is_null($this->dao_obj) ? new $dao_name() : $this->dao_obj;
        $this->reset();
        if (!empty($instance_data)) {
            $this->set($instance_data);
        }

    }// end function __construct

    public function set($instance_data)
    {
        if (!is_array($instance_data)) {

            if ((int)$instance_data != $instance_data) {
                $message = get_class($this).': instance id "'.$instance_data.'" is illegal.';
                throw new RuntimeException($message);
            }

            $query_params = array(
                'field' => '*',
                'where' => 'id = :id',
                'param' => array(
                    ':id' => $instance_data
                )
            );
            $query_instance = $this->dao_obj->select($query_params);

            if (count($query_instance) == 0) {
                $this->reset();
                return;
            }

            foreach ($query_instance as $row_data) {
                $instance_data = $row_data;
                break;
            }

        }

        $this->reset();
        foreach ($instance_data as $attribute => $value) {
            switch ($attribute) {
                case 'dao_obj':
                    break;

                default:
                    $this->$attribute = $value;
                    break;
            }
        }

    }// end function set

    public function save()
    {

        $class_property_array = get_object_vars($this);
        $now = date('Y-m-d H:i:s');
        $object_data = array();

        foreach ($class_property_array as $property_key => $property_value) {

            switch ($property_key) {
                case 'dao_obj':
                case 'id':
                case 'is_deleted':
                case 'create_time':
                case 'modify_time':
                case 'delete_time':
                    break;

                default:
                    if (!is_null($property_value)) {

                        $object_data[$property_key] = $property_value;

                    }
                    break;
            }

        }
        $object_data['modify_time'] = $now;

        if ($this->id === false) {
            $object_data['create_time'] = $now;
            $this->id = $this->dao_obj->insert($object_data);
            return $this->id;
        } else {
            return $this->dao_obj->update($object_data, 'id = :id', array(':id' => $this->id)) == 1;
        }

    }// end function save

    public function destroy($type = 'mark')
    {
        if ($this->id !== false) {
            switch ($type) {
                case 'delete':
                    return $this->dao_obj->delete('id = :id', array(':id' => $this->id));

                case 'mark':
                default:
                    $now = date('Y-m-d H:i:s');
                    $update_data = array(
                        'is_deleted'  => 1,
                        'modify_time' => $now,
                        'delete_time' => $now
                    );
                    return $this->dao_obj->update($update_data, 'id = :id', array(':id' => $this->id));
            }
        }
    }// end function destroy

    public function recover()
    {
        if ($this->id !== false) {
            $now = date('Y-m-d H:i:s');
            $update_data = array(
                'is_deleted'  => 0,
                'modify_time' => $now,
                'delete_time' => $now
            );
            return $this->dao_obj->update($update_data, 'id = :id', array(':id' => $this->id));
        }
    }// end function recover

    public function reset()
    {

        $class_property_array = get_object_vars($this);

        foreach ($class_property_array as $property_key => $property_value) {

            switch ($property_key) {
                case 'dao_obj':
                    break;

                default:
                    $this->$property_key = false;
                    break;
            }

        }

    }// end function reset

    public function __destruct()
    {

        $class_property_array = get_object_vars($this);

        foreach ($class_property_array as $property_key => $property_value) {

            switch ($property_key) {
                case 'dao_obj':
                    break;

                default:
                    unset($this->$property_key);
                    break;
            }

        }

    }// end function __destruct

}// end of class DataModel

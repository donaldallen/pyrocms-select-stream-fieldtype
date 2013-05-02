<?php defined('BASEPATH') or exit('No direct script access allowed');

class Field_select_stream
{
    public $field_type_slug = 'select_stream';
    public $db_col_type     = 'varchar';
    public $version         = '1.0.0';
    public $author          = array('name' => 'Donald Allen', 'url' => 'http://donaldallen.com');

    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function form_output($params, $entry_id)
    {
        $choices = array();

        $streams = $this->ci->db
                            ->where('stream_namespace !=', 'users')
                            ->select('id, stream_name, stream_namespace, stream_slug')->get(STREAMS_TABLE)->result();

        foreach ($streams as $stream)
        {
            if ($stream->stream_namespace)
            {
                $choices[ucfirst($stream->stream_namespace)][$stream->stream_slug] = $stream->stream_name;
            }
        }

        $default_value = (isset($params['custom']['default_value'])) ? $params['custom']['default_value'] : null;

        $value = ( ! $entry_id) ? $default_value : $params['value'];

        return form_dropdown($params['form_slug'], $choices, $value, 'id="'.$params['form_slug'].'"');
    }
}
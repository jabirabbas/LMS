<?php if (!defined('BASEPATH')) exit('No direct script access allowed');





class To_excel {

    

    function create_excel($query, $filename='exceloutput')

    {

        $ci =& get_instance();

        $ci->load->helper('download');

    

        $headers = ''; // just creating the var for field headers to append to below

        $data = ''; // just creating the var for field data to append to below

        

		

		$fields = $query->list_fields();

		

		//print_r($fields); exit;

        if ($query->num_rows() == 0) {

            echo '<p>The table appears to have no data.</p>';

        } else {

            foreach ($fields as $field) {

               $headers .= ucwords(str_replace('_',' ',$field)) . "\t";

            }

       

            foreach ($query->result() as $row) {

                $line = '';

                foreach($row as $value) {                                            

                    if (( ! isset($value)) OR ($value == "")) {

                        $value = "\t";

                    } else {

                        $value = str_replace('"', '""', $value);

                        $value = '"' . strval($value) . '"' . "\t";

                    }

                    $line .= $value;

                }

                $data .= trim($line)."\n";

            }

            

            $data = str_replace("\r","",$data);

		

            force_download(ucwords($filename)."_".date('dMY').".xls", $headers . "\n" . $data);

        } 

    }

}

/* End of file */

/* Location: ./application/libraries/To_excel.php */  
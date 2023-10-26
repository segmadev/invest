<?php 
    class settings extends content {
    private $accepted_tables = ["key_features",  "why_us", "testimonies"];
        function new_settings($data, $what = "settings") {
            if($data  == ""){ return null; }
            foreach($data as $key => $row) {
                if($key == "input_data") { continue; }
                if($this->getall("$what", "meta_name = ?", [$key], fetch: "") > 0) { continue; }
                $value = "";
                if(isset($data['input_data'][$key])) {
                    $value = $data['input_data'][$key];
                }
                $this->quick_insert("$what", ["meta_name"=>$key, "meta_value"=>$value]);
            }
        }

        function update_settings($data, $what =  "settings") {
            if($data  == ""){ return null; }
            $info = $this->validate_form($data);
            // var_dump($info);
            if(!is_array($info) || $info == null || $info == false) { return null;}
            foreach ($info as $key => $value) {
                
                if($this->getall("$what", "meta_name = ?", [$key], fetch: "") == 0) { continue; }
                $update = $this->update("$what", ["meta_value"=>$value], "meta_name = '$key'");
            }
            $return = [
                "message" => ["Success", "$what Updated", "success"],
            ];
            return json_encode($return);  
        }

        function getdata($data, $what = "settings") {
            if($data == ""){ return null; }
            $info = [];
            foreach($data as $key => $row) {
                if($key == "input_data") { continue; }
                $datad = $this->getall("$what", "meta_name = ?", [$key], fetch: "details");
                if(!is_array($datad)) { continue; }
                $info[$key] = $datad['meta_value'];
                //  $this->quick_insert("settings", ["meta_name"=>$key, "meta_value"=>$value]);
            }
            return $info;
        }

        function new_details($data, $what = "key_features") {
            if(!in_array($what, $this->accepted_tables)){
                return null;
            }
            if(isset($data['ID'])) {
                unset($data['ID']);
            }
            $info = $this->validate_form($data, "$what");
            if(!is_array($info)) { return null; }
            $this->quick_insert("$what", $info, "New detail added.");
        }

        function edit_details($data, $what = "key_features") {
            if(!in_array($what, $this->accepted_tables)){
                return null;
            }
            $info = $this->validate_form($data, "$what");
            if(!is_array($info)) { return null; }
            $id = $info['ID'];
            unset($info['ID']);
            $this->update("$what", $info, "ID = '$id'", "Detail updated.");
        }

        function remove_details($id, $what = "key_features") {
            if(!in_array($what, $this->accepted_tables)){
                return null;
            }
            $delete = $this->delete("$what", "ID = ?", [$id]);
            $return = [
                "message" => ["Success", "one detail deleted", "success"],
                "function" => ["removediv", "data"=>[".detail-".$id, "success"]]
            ];
            return json_encode($return);
        }
    }
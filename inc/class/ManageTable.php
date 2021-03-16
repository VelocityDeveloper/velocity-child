<?php

class ManageTable {

    private
        $wpdb,
        $table_prefix,
        $charset_collate;
    
    public function __construct($name, array $args) {
        global $wpdb;
    
        $this->wpdb = $wpdb;
        $this->datas = $args;
        $this->table_prefix = $this->wpdb->prefix . $name;
        $charset_collate = $this->wpdb->get_charset_collate();
    
    }
    
    public function run() {
    
        $table_name = $this->table_prefix;
        
        $datas = $this->datas;
        $data = '';
        foreach($datas as $key => $val){
            $data .= $key.' '.$val.',';
        }
        $sql = "CREATE TABLE IF NOT EXISTS $table_name ( 
        id int(11) NOT NULL AUTO_INCREMENT,
        $data
        PRIMARY KEY  (id)
        ) $this->charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    
    }
    
    
    public function insert($args) {
        global $wpdb;
        
        $table_name = $this->table_prefix;
        $datas = $this->datas;
        $data = [];
        $i = 0;
        foreach($datas as $key => $val){
            $data[$key] = $args[$i++];
        }
        $wpdb->insert($table_name, $data);
    }
    
    public function delete($id=null) {
        global $wpdb;
        
        $table_name = $this->table_prefix;
        $wpdb->delete($table_name, array( 'id' => $id ));
    }
    
    public function update($id=null, array $args) {
        global $wpdb;
        
        $table_name = $this->table_prefix;
        $datas = $this->datas;
        $data = [];
        $i = 0;
        foreach($datas as $key => $val){
            $data[$key] = $args[$i++];
        }
        $wpdb->update($table_name, $data , array( 'id' => $id ));
    }
    
}

// Set table and data type
$args = [
            'nama' => 'VARCHAR(50) NOT NULL',
            'email' => 'VARCHAR(250) NOT NULL',
            'jenis_kelamin' => 'VARCHAR(50) NOT NULL',
            'tempat_lahir' => 'VARCHAR(250) NOT NULL',
            'tanggal_lahir' => 'DATE NOT NULL',
            'agama' => 'VARCHAR(50) NOT NULL',
            'telfon' => 'VARCHAR(50) NOT NULL',
            'alamat' => 'VARCHAR(250) NOT NULL',
            'dibuat' => 'DATETIME NOT NULL',
        ];
        
$baru = [ 'Wandi', 'wandi@gmail.com', 'Laki-Laki', 'Klaten', '1990-05-3', 'islam', '082147650800', 'Tunggul, jarum, Bayat, Klaten', date('Y-m-d H:i:s')];
$update = [ 'Wandi P', 'wandi@gmail.com', 'Laki-Laki', 'Klaten', '1990-05-3', 'islam', '082147650800', 'Tunggul, jarum, Bayat, Klaten', date('Y-m-d H:i:s')];

// Run ManageTable
$PPDB = new ManageTable('ppdb', $args);
$PPDB->run();

// Insert data to table based on $args
// $PPDB->insert($baru);
// Delete data from table based on id
// $PPDB->delete(1);
// Update data from table based on id
// $PPDB->update(2,$update);

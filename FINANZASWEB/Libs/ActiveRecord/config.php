ActiveRecord/config::initialize(function($cfg)){
    $cfg->set_model_directory($_SERVER["DOCUMENT_ROOT"] . 'finanzasweb/Model/Entities');
    $ctg->setconnections(
        array(
            'development' => 'mysql://root:root@localhost/mi_base_de_datos'
        )
    );
}
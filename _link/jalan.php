<?php
switch ($url->getByIndex(1)){
    case 'tambah':
        ?>
        <script type="text/javascript">
            $(function () {
                $(document).on('click', '#addOutGate', function () {
                    var mod     = $(this).parents('.modal');
                    var name    = mod.find('[name="name"]').val();
                    var dist    = mod.find('[name="distance"]').val();
                    var price   = mod.find('[name="price"]').val();

                    if(name !== "" && dist !== "" && price !== ""){
                        var list    = $('#listOutGate');
                        list.append(
                            '<div class="alert alert-success">' +
                                '<h4>'+name+'</h4>'+
                                '<input type="hidden" name="out-name[]" value="'+name+'"/>'+
                                '<p>'+dist+' KM</p>'+
                                '<input type="hidden" name="out-distance[]" value="'+dist+'"/>'+
                                '<p>Rp. '+price+'</p>'+
                                '<input type="hidden" name="out-price[]" value="'+price+'"/>'+
                            '</div>'
                        );
                        mod.modal('hide');
                        $('#formOutGate')[0].reset();
                    }
                    else{
                        mod.modal('hide');
                        bootbox.alert("Data belum lengkap, silahkan periksa kembali", function () {
                            mod.modal('show');
                        });
                    }
                });
            });
        </script>
        <div class="modal fade" id="modalOutGate">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tambah Gerbang Keluar</h4>
                    </div>
                    <div class="modal-body">
                        <form id="formOutGate">
                            <label><b>Nama gerbang</b></label>
                            <input type="text" class="form-control" name="name">
                            <br/>
                            <label><b>Panjang jalan (KM)</b></label>
                            <input type="number" class="form-control" name="distance">
                            <br/>
                            <label><b>Tarif</b></label>
                            <input type="number" class="form-control" name="price">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="addOutGate">Selesai</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <form id="formSubmit" method="post" action="_action/adminHandler.php" data-onfinish="redirect;jalan">
            <input type="hidden" name="action" value="road-add">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-header">Tambah Jalan Baru</h4>
                </div>
                <div class="panel-body">
                    <label><b>Nama jalan</b></label>
                    <input type="text" name="name" class="form-control">
                    <br/>
                    <label><b>Gerbang keluar</b></label>
                    <div id="listOutGate">
                        <button style="margin-bottom: 10px;" data-toggle="modal" data-target="#modalOutGate" type="button" class="btn btn-sm btn-success"><i class="icon-plus22"></i> Tambah</button>
                    </div>
                </div>
                <div class="panel-footer" style="padding: 15px 20px;">
                    <button type="button" class="btn btn-primary" data-plugin="submit" data-target="#formSubmit"><i class="icon-check"></i> Selesai Menambahkan</button>
                </div>
            </div>

        </form>
        <?php
        break;
    case 'edit':
        $packet   = $cnc->query(array(':id'=>$url->getByIndex(2)), "SELECT * FROM highway_road WHERE id=:id");
        if ($packet->rowCount() > 0){
            $dataPacket   = $packet->fetch(PDO::FETCH_OBJ);
            ?>
            <script type="text/javascript">
                $(function () {
                    $(document).on('click', '#addOutGate', function () {
                        var mod     = $(this).parents('.modal');
                        var name    = mod.find('[name="name"]').val();
                        var dist    = mod.find('[name="distance"]').val();
                        var price   = mod.find('[name="price"]').val();

                        if(name !== "" && dist !== "" && price !== ""){
                            var list    = $('#listOutGate');
                            list.append(
                                '<div class="alert alert-success">' +
                                '<h4>'+name+'</h4>'+
                                '<input type="hidden" name="out-name[]" value="'+name+'"/>'+
                                '<p>'+dist+' KM</p>'+
                                '<input type="hidden" name="out-distance[]" value="'+dist+'"/>'+
                                '<p>Rp. '+price+'</p>'+
                                '<input type="hidden" name="out-price[]" value="'+price+'"/>'+
                                '</div>'
                            );
                            mod.modal('hide');
                            $('#formOutGate')[0].reset();
                        }
                        else{
                            mod.modal('hide');
                            bootbox.alert("Data belum lengkap, silahkan periksa kembali", function () {
                                mod.modal('show');
                            });
                        }
                    });

                    $(document).on('click', '.delete-outgate', function () {
                        $(this).parents('.alert').remove();
                    })
                });
            </script>
            <div class="modal fade" id="modalOutGate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Tambah Gerbang Keluar</h4>
                        </div>
                        <div class="modal-body">
                            <form id="formOutGate">
                                <label><b>Nama gerbang</b></label>
                                <input type="text" class="form-control" name="name">
                                <br/>
                                <label><b>Panjang jalan (KM)</b></label>
                                <input type="number" class="form-control" name="distance">
                                <br/>
                                <label><b>Tarif</b></label>
                                <input type="number" class="form-control" name="price">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="addOutGate">Selesai</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <form id="formSubmit" method="post" action="_action/adminHandler.php" data-onfinish="redirect;jalan">
                <input type="hidden" name="action" value="road-edit">
                <input type="hidden" name="id" value="<?= $dataPacket->id ?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-header">Edit Jalan</h4>
                    </div>
                    <div class="panel-body">
                        <label><b>Nama jalan</b></label>
                        <input type="text" name="name" class="form-control" value="<?= $dataPacket->name ?>">
                        <br/>
                        <label><b>Gerbang keluar</b></label>
                        <div id="listOutGate">
                            <button style="margin-bottom: 10px;" data-toggle="modal" data-target="#modalOutGate" type="button" class="btn btn-sm btn-success"><i class="icon-plus22"></i> Tambah</button>
                            <?php
                            $setGate    = $cnc->query(array(':rd'=>$dataPacket->id), "SELECT * FROM highway_outgate WHERE road=:rd");
                            while ($getGate = $setGate->fetch(PDO::FETCH_OBJ)){
                                echo '
                                    <div class="alert alert-success">
                                        <button type="button" class="close delete-outgate" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4>'.$getGate->name.'</h4>
                                        <input type="hidden" name="out-name[]" value="'.$getGate->name.'"/>
                                        <p>'.$getGate->distance.'</p>
                                        <input type="hidden" name="out-distance[]" value="'.$getGate->distance.'"/>
                                        <p>'.$getGate->price.'</p>
                                        <input type="hidden" name="out-price[]" value="'.$getGate->price.'"/>
                                    </div>
                                ';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="panel-footer" style="padding: 15px 20px;">
                        <button type="button" class="btn btn-primary" data-plugin="submit" data-target="#formSubmit"><i class="icon-check"></i> Simpan Perubahan</button>
                    </div>
                </div>

            </form>
            <?php
        }
        else{
            echo '<div class="alert alert-warning">Data ini tidak ada di sistem</div>';
        }
        break;
    default:
        ?>
        <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/datatables_basic.js"></script>
        <script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/forms/selects/select2.min.js"></script>
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title text-semibold">Daftar Jalan</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <a href="jalan/tambah" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah Jalan</a>
            </div>
            <table class="table table-hover table-bordered">
                <thead  style="font-weight: bold;">
                    <tr class="text-semibold">
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama Jalan</th>
                        <th colspan="3" class="text-center">Gerbang Keluar</th>
                        <th rowspan="2" class="text-center">Aksi</th>
                    </tr>
                    <tr class="text-semibold">
                        <th>Nama Gerbang</th>
                        <th>Jarak</th>
                        <th>Tarif</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                <?php
                $query  = $cnc->query(null, "SELECT * FROM highway_road");
                $no     = 0;
                while ($dbquery=$query->fetch(PDO::FETCH_OBJ)){
                    $no++;
                    $setGate    = $cnc->query(array(':rd'=>$dbquery->id), "SELECT * FROM highway_outgate WHERE road=:rd");
                    $getGate    = $setGate->fetchAll(PDO::FETCH_OBJ);
                    echo '
                    <tr>
                        <td rowspan="'.$setGate->rowCount().'">'.$no.'</td>
                        <td rowspan="'.$setGate->rowCount().'">'.$dbquery->name.'</td>
                        <td>'.$getGate[0]->name.'</td>
                        <td>'.$getGate[0]->distance.' KM</td>
                        <td>Rp. '.$getGate[0]->price.'</td>
                        <td rowspan="'.$setGate->rowCount().'" class="text-center">
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>
        
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:;" data-plugin="action" data-url="_action/adminHandler.php" data-values="action=road-delete&id='.$dbquery->id.'" data-warning="data yang sudah terhapus tidak dapat dibalikan" data-onfinish="reload"><i class="icon-trash-alt"></i> Hapus</a></li>
                                        <li><a href="jalan/edit/'.$dbquery->id.'"><i class="icon-pencil"></i> Edit</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    ';

                    foreach ($getGate as $i=>$gate){
                        if ($i > 0){
                            echo '
                                <tr>
                                    <td>'.$gate->name.'</td>
                                    <td>'.$gate->distance.' KM</td>
                                    <td>Rp. '.$gate->price.'</td>
                                </tr>
                            ';
                        }
                    }
                }

                ?>
                </tbody>
            </table>
        </div>
        <?php
        break;
}
?>

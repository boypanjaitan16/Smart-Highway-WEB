<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/datatables_basic.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/forms/selects/select2.min.js"></script>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title text-semibold">Daftar Pengguna</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>
    <table class="table datatable-basic table-hover">
        <thead>
        <tr class="text-semibold">
            <th>Username</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Saldo</th>
            <th class="text-center">Aksi</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <?php
        $query  = $cnc->query(null, "SELECT a.*,b.balance FROM highway_member a LEFT JOIN highway_balance b ON a.id=b.id ORDER BY `name`");
        while ($dbquery=$query->fetch(PDO::FETCH_OBJ)){
            $balance    = empty($dbquery->balance) ? 0 : $dbquery->balance;
            echo '
                <tr>
                    <td>'.$dbquery->id.'</td>
                    <td>'.$dbquery->name.'</td>
                    <td>'.$dbquery->email.'</td>
                    <td>'.$dbquery->phone.'</td>
                    <td>Rp. '.$balance.'</td>
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
    
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:;" class="do-topup" data-member="'.$dbquery->id.'"><i class="icon-coins"></i> Top-up Saldo</a></li>
                                    <li><a href="javascript:;" data-plugin="action" data-url="_action/adminHandler.php" data-values="action=member-delete&id='.$dbquery->id.'" data-warning="data yang sudah terhapus tidak dapat dibalikan" data-onfinish="reload"><i class="icon-trash-alt"></i> Hapus</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>
                </tr>
                ';
        }

        ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).on('click', '.do-topup', function () {
        var member  = $(this).attr('data-member');

        swal({
                title: "Top-up Saldo",
                text: "Masukkan jumlah saldo yang ingin anda tambah",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Jumlah saldo"
            },
            function(inputValue){
                if (inputValue === false) return false;

                if (inputValue === "") {
                    swal.showInputError("Anda harus mengisikan jumlah saldo sebelum memproses!");
                    return false
                }

                $.ajax({
                    url     : "_action/adminHandler.php",
                    method  : "POST",
                    data    : {'action':'topup-add','id':member, 'value':inputValue},
                    dataType: "json",
                    error   : function () {
                        defaultConfig.error();
                    },
                    beforeSend  : function () {
                        defaultConfig.loading();
                    },
                    success     : function (data) {
                        defaultConfig.stopLoading();
                        if(data.status === "success"){
                            window.location.reload(true);
                        }
                        else{
                            defaultConfig.gagal(data.message);
                        }
                    }
                })
            });
    });
</script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/datatables_basic.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript">
    $('#deleteData').on('click', function () {
        var checkbox    = $('.check-activity:checked');
        if(checkbox.length > 0){
            swal({
                    title: "Apakah anda yakin?",
                    text: "Anda tidak dapat mengembalikan gambar yang sudah terhapus",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Lanjutkan",
                    closeOnConfirm: false
                },
                function(){
                    var ids = [];
                    $.each(checkbox, function( index, value ) {
                        var id  = $(value).attr('data-id');
                        ids.push(id);
                    });
                    $.ajax({
                        method  : "POST",
                        url     : "_action/handler.php",
                        dataType    : "json",
                        data    : { action:'galeri-delete',values:JSON.stringify(ids) },
                        error   : function () {
                            defaultConfig.error();
                        },
                        beforeSend  : function () {
                            defaultConfig.loading();
                        },
                        success : function (data) {
                            defaultConfig.stopLoading();
                            if(data.status === "success"){
                                for(var i=0; i<ids.length; i++){
                                    var tr  = $('.table-inbox tr[data-id="'+ids[i]+'"]');
                                    tr.remove();
                                }
                                swal.close();
                            }
                            else{
                                defaultConfig.gagal(data.message);
                            }
                        }
                    });
                });
        }
        else{
            bootbox.alert("Anda belum memilih data yang akan dihapus");
        }
    });
</script>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title text-semibold">Daftar Aktivitas Pengguna</h5>
        <div class="heading-elements">
            <ul class="icons-list">
                <li><a data-action="collapse"></a></li>
                <li><a data-action="reload"></a></li>
                <li><a data-action="close"></a></li>
            </ul>
        </div>
    </div>
    <div class="panel-body">
        <button type="button" id="deleteData" class="btn btn-danger"><i class="icon-bin"></i> Hapus</button>
    </div>
    <div class="table-responsive">
        <table class="table datatable-basic table-hover">
            <thead>
            <tr class="text-semibold">
                <th colspan="2">No</th>
                <th>Pengguna</th>
                <th>Jalan</th>
                <th>Tanggal</th>
                <th class="text-center">Aksi</th>
            </tr>
            </thead>
            <tbody id="tableBody">
            <?php
            $setAllCount    = $cnc->query(null, "SELECT count(id) AS jumlah FROM highway_activity");
            $getAllCount    = $setAllCount->fetch(PDO::FETCH_OBJ);

            $rowPerPage     = 10;
            $currentPage    = !empty($url->getByIndex(1)) ? $url->getByIndex(1) : 1;
            $lastPage       = ceil($getAllCount->jumlah/$rowPerPage);
            $offset         = ($currentPage-1)*$rowPerPage;

            $i      = $offset;
            $query  = $cnc->query(null, "SELECT a.*,b.name AS memberName, c.name AS roadName FROM highway_activity a LEFT JOIN highway_member b ON a.memberId=b.id LEFT JOIN highway_road c ON a.roadId=c.id ORDER BY a.id DESC LIMIT $offset,$rowPerPage");
            while ($dbquery=$query->fetch(PDO::FETCH_OBJ)){
                $i++;
                echo '
                <tr>
                    <td>'.$i.'</td>
                    <td><input type="checkbox" class="styled selection check-activity"></td>
                    <td>'.$dbquery->memberName.'</td>
                    <td>'.$dbquery->roadName.'</td>
                    <td>'.date("d M Y, H:i",$dbquery->time).'</td>
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
    
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:;" data-plugin="action" data-url="_action/adminHandler.php" data-values="action=activity-delete&id='.$dbquery->id.'" data-warning="data yang sudah terhapus tidak dapat dibalikan" data-onfinish="reload"><i class="icon-trash-alt"></i> Hapus</a></li>
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
    <div class="panel-body">
        <nav class="text-center">
            <ul class="pagination">
                <?php
                if ($currentPage != 1){
                    echo '
                        <li>
                            <a href="'.$url->getByIndex(0).'/'.($currentPage-1).'" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>   
                    ';
                }

                for($i=1; $i<=$lastPage; $i++){
                    $class  = $currentPage == $i ? 'active' : null;
                    echo '<li class="'.$class.'"><a href="'.$url->getByIndex(0).'/'.$i.'">'.$i.'</a></li>';
                }

                if ($currentPage != $lastPage){
                    echo '
                        <li>
                            <a href="'.$url->getByIndex(0).'/'.($currentPage+1).'" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>  
                    ';
                }
                ?>

            </ul>
        </nav>
    </div>

</div>
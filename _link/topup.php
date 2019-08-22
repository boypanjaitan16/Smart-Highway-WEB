<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/pages/datatables_basic.js"></script>
<script type="text/javascript" src="<?= $assets->getLimitless() ?>js/plugins/forms/selects/select2.min.js"></script>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title text-semibold">Riwayat Top-up Saldo</h5>
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
            <th>Nomor</th>
            <th>Nama Member</th>
            <th>Waktu Top-up</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        <?php
        $i=0;
        $where  = $url->getByIndex(1);
        $query  = $cnc->query(null, "SELECT a.*,b.name FROM highway_topup a LEFT JOIN highway_member b ON a.memberId=b.id WHERE status=$where ORDER BY a.id DESC");
        while ($dbquery=$query->fetch(PDO::FETCH_OBJ)){
            $status = $dbquery->status == 1 ? '<span class="label label-success">disetujui</span>':'<span class="label label-warning">menunggu</span>';
            $i++;
            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td><span title="'.$dbquery->memberId.'" data-toggle="tooltip">'.$dbquery->name.'</span></td>
                    <td>'.date("d M Y, H:i",$dbquery->time).'</td>
                    <td>Rp. '.$dbquery->nominal.'</td>
                    <td>'.$status.'</td>
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
    
                                <ul class="dropdown-menu dropdown-menu-right">';
                                    if ($dbquery->status == 0){
                                        echo '<li><a href="javascript:;" data-plugin="action" data-url="_action/adminHandler.php" data-values="action=topup-denied&id='.$dbquery->id.'" data-onfinish="reload"><i class="icon-cross"></i> Tolak</a></li>';
                                        echo '<li><a href="javascript:;" data-plugin="action" data-url="_action/adminHandler.php" data-values="action=topup-approve&id='.$dbquery->id.'" data-onfinish="reload"><i class="icon-check"></i> Setujui</a></li>';
                                    }

                                echo '
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
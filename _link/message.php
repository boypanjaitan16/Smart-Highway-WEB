<script type="text/javascript">
    $(function () {
        $(document).on('click', '#sendMessage', function () {
            var form    = $('#formMessage');
            var users   = $('.select-user');
            var ids     = [];

            $.each(users, function (i, val) {
                if($(this).prop('checked')){
                    ids.push($(this).attr('data-id'));
                }
            });

            $.ajax({
                url     : '_action/adminHandler.php',
                method  : 'POST',
                data    : 'action=send-broadcast&'+form.serialize()+'&receiver='+JSON.stringify(ids),
                dataType: 'JSON',
                error   : function (a,b,c) {
                    swal("Error", a.responseText, "error");
                },
                beforeSend  : function () {
                    swal({
                        title   : "Sedang mengirim pesan...",
                        showConfirmButton: false,
                        allowOutsideClick : false
                    });
                },
                success : function (result) {
                    if(result.status === "success"){
                        swal("Sukses", "Pesan berhasil dikirim");
                        form[0].reset();
                    }
                    else{
                        swal("Warning", result.message, "warning");
                    }
                }
            });
        });
    });
</script>
<form class="panel panel-body" id="formMessage" method="post" action="_action/adminHandler.php" data-onfinish="text;Pesan berhasil dikirim">
    <label>Judul</label>
    <input type="text" class="form-control" name="title">
    <br/>
    <label>Isi Pesan</label>
    <textarea class="form-control" name="body"></textarea>
    <br/>
    <label>Penerima</label>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><i class="icon-check"></i> </th>
                <th>Username</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $setAllAcc  = $cnc->query(null, "SELECT id,`name` FROM highway_member ORDER BY `name`");
            while($getAllAcc = $setAllAcc->fetch(PDO::FETCH_OBJ)){
                echo '
                    <tr>
                        <td><input data-id="'.$getAllAcc->id.'" type="checkbox" class="select-user"/></td>
                        <td>'.$getAllAcc->id.'</td>
                        <td>'.$getAllAcc->name.'</td>
                    </tr>
                ';
            }
        ?>
        </tbody>
    </table>
    <hr/>
    <button type="button" class="btn btn-lg btn-success" id="sendMessage">KIRIM PESAN</button>
</form>